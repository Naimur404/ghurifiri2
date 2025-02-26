<?php

namespace Botble\Member\Providers;

use Botble\Api\Facades\ApiHelper;
use Botble\Base\Facades\Breadcrumbs;
use Botble\Base\Facades\DashboardMenu;
use Botble\Base\Facades\EmailHandler;
use Botble\Base\Facades\PanelSectionManager;
use Botble\Base\Forms\FormAbstract;
use Botble\Base\PanelSections\PanelSectionItem;
use Botble\Base\Rules\OnOffRule;
use Botble\Base\Supports\BreadcrumbsGenerator;
use Botble\Base\Supports\ServiceProvider;
use Botble\Base\Traits\LoadAndPublishDataTrait;
use Botble\Captcha\Forms\CaptchaSettingForm;
use Botble\Language\Facades\Language;
use Botble\LanguageAdvanced\Supports\LanguageAdvancedManager;
use Botble\Member\Http\Middleware\RedirectIfMember;
use Botble\Member\Http\Middleware\RedirectIfNotMember;
use Botble\Member\Models\Member;
use Botble\Member\Models\MemberActivityLog;
use Botble\Member\Repositories\Eloquent\MemberActivityLogRepository;
use Botble\Member\Repositories\Eloquent\MemberRepository;
use Botble\Member\Repositories\Interfaces\MemberActivityLogInterface;
use Botble\Member\Repositories\Interfaces\MemberInterface;
use Botble\Setting\PanelSections\SettingOthersPanelSection;
use Botble\Slug\Facades\SlugHelper;
use Botble\SocialLogin\Facades\SocialService;
use Illuminate\Routing\Events\RouteMatched;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class MemberServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function register(): void
    {
        config([
            'auth.guards.member' => [
                'driver' => 'session',
                'provider' => 'members',
            ],
            'auth.providers.members' => [
                'driver' => 'eloquent',
                'model' => Member::class,
            ],
            'auth.passwords.members' => [
                'provider' => 'members',
                'table' => 'member_password_resets',
                'expire' => 60,
            ],
        ]);

        $router = $this->app['router'];

        $router->aliasMiddleware('member', RedirectIfNotMember::class);
        $router->aliasMiddleware('member.guest', RedirectIfMember::class);

        $this->app->bind(MemberInterface::class, function () {
            return new MemberRepository(new Member());
        });

        $this->app->bind(MemberActivityLogInterface::class, function () {
            return new MemberActivityLogRepository(new MemberActivityLog());
        });
    }

    public function boot(): void
    {
        SlugHelper::setPrefix(Member::class, 'author');
        SlugHelper::setColumnUsedForSlugGenerator(Member::class, 'last_name');

        add_filter(IS_IN_ADMIN_FILTER, [$this, 'setInAdmin'], 24);

        $this->setNamespace('plugins/member')
            ->loadHelpers()
            ->loadAndPublishConfigurations(['general', 'permissions', 'email'])
            ->loadAndPublishTranslations()
            ->loadAndPublishViews()
            ->loadRoutes(['web', 'member'])
            ->loadMigrations()
            ->publishAssets();

        DashboardMenu::default()->beforeRetrieving(function (): void {
            DashboardMenu::registerItem([
                'id' => 'cms-core-member',
                'priority' => 50,
                'parent_id' => null,
                'name' => 'plugins/member::member.menu_name',
                'icon' => 'ti ti-users',
                'url' => fn () => route('member.index'),
                'permissions' => ['member.index'],
            ]);
        });

        DashboardMenu::for('member')->beforeRetrieving(function (): void {
            DashboardMenu::make()
                ->registerItem([
                    'id' => 'cms-member-dashboard',
                    'priority' => 1,
                    'name' => 'Dashboard',
                    'url' => fn () => route('public.member.dashboard'),
                    'icon' => 'ti ti-home',
                ])
                ->registerItem([
                    'id' => 'cms-member-posts',
                    'priority' => 2,
                    'name' => 'plugins/blog::member.posts',
                    'url' => fn () => route('public.member.posts.index'),
                    'icon' => 'ti ti-article',
                ])
                ->registerItem([
                    'id' => 'cms-member-settings',
                    'priority' => 4,
                    'name' => 'plugins/member::dashboard.header_settings_link',
                    'url' => fn () => route('public.member.settings'),
                    'icon' => 'ti ti-settings',
                ]);
        });

        DashboardMenu::default();

        PanelSectionManager::default()->beforeRendering(function (): void {
            PanelSectionManager::registerItem(
                SettingOthersPanelSection::class,
                fn () => PanelSectionItem::make('members')
                    ->setTitle(trans('plugins/member::settings.title'))
                    ->withIcon('ti ti-user-cog')
                    ->withPriority(170)
                    ->withDescription(trans('plugins/member::settings.description'))
                    ->withRoute('member.settings')
            );
        });

        $this->app['events']->listen(RouteMatched::class, function (): void {
            if (! is_in_admin(true)) {
                Breadcrumbs::register('dashboard.index', function (BreadcrumbsGenerator $breadcrumbs): void {
                    $breadcrumbs->push(trans('core/base::layouts.dashboard'), route('public.member.dashboard'));
                }, true);
            }
        });

        if (class_exists('ApiHelper') && ApiHelper::enabled()) {
            ApiHelper::setConfig([
                'model' => Member::class,
                'guard' => 'member',
                'password_broker' => 'members',
                'verify_email' => true,
            ]);
        }

        $this->app->booted(function (): void {
            EmailHandler::addTemplateSettings(MEMBER_MODULE_SCREEN_NAME, config('plugins.member.email', []));

            if (
                defined('SOCIAL_LOGIN_MODULE_SCREEN_NAME') &&
                ! $this->app->runningInConsole() &&
                Route::has('public.member.login')
            ) {
                SocialService::registerModule([
                    'guard' => 'member',
                    'model' => Member::class,
                    'login_url' => route('public.member.login'),
                    'redirect_url' => route('public.member.dashboard'),
                ]);
            }
        });

        add_filter('social_login_before_saving_account', function ($data, $oAuth, $providerData) {
            if (Arr::get($providerData, 'model') == Member::class && Arr::get($providerData, 'guard') == 'member') {
                $firstName = implode(' ', explode(' ', $oAuth->getName(), -1));
                Arr::forget($data, 'name');
                $data = array_merge($data, [
                    'first_name' => $firstName,
                    'last_name' => trim(str_replace($firstName, '', $oAuth->getName())),
                ]);
            }

            return $data;
        }, 49, 3);

        $this->app->register(EventServiceProvider::class);

        if (is_plugin_active('language') && is_plugin_active('language-advanced')) {
            $this->loadRoutes(['language-advanced']);

            FormAbstract::beforeRendering(function (FormAbstract $form) {
                if ($form instanceof CaptchaSettingForm) {
                    $form
                        ->addAfter('captcha_secret', 'member_enable_recaptcha_in_register_page', 'onOffCheckbox', [
                            'label' => trans('plugins/member::settings.enable_recaptcha_in_register_page'),
                            'value' => setting('member_enable_recaptcha_in_register_page', false),
                        ])
                        ->addAfter('open_fieldset_math_captcha_setting', 'member_enable_math_captcha_in_register_page', 'onOffCheckbox', [
                            'label' => trans('plugins/member::settings.enable_math_captcha_in_register_page'),
                            'value' => setting('member_enable_math_captcha_in_register_page', false),
                        ]);
                }

                $adminLocale = Language::getCurrentAdminLocaleCode();

                $isDefaultLocale = $adminLocale == Language::getDefaultLocaleCode();

                $model = $form->getModel();

                if (
                    in_array('member', Route::current()->middleware()) &&
                    Auth::guard('member')->check() &&
                    ! $isDefaultLocale &&
                    $model->getKey() &&
                    LanguageAdvancedManager::isSupported($model)
                ) {
                    $refLang = '?ref_lang=' . $adminLocale;

                    $form->setFormOption('url', route('public.member.language-advanced.save', $model->getKey()) . $refLang);
                }

                return $form;
            }, 9999);

            add_filter('captcha_settings_validation_rules', [$this, 'addMemberSettingRules'], 99);
        }
    }

    public function addMemberSettingRules(array $rules): array
    {
        return array_merge($rules, [
            'member_enable_recaptcha_in_register_page' => $onOffRule = new OnOffRule(),
            'member_enable_math_captcha_in_register_page' => $onOffRule,
        ]);
    }

    public function setInAdmin(bool $isInAdmin): bool
    {
        return request()->segment(1) === 'member' || $isInAdmin;
    }
}
