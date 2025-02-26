<?php

namespace Botble\AIWriter\Providers;

use Botble\Base\Supports\Helper;
use Botble\Base\Traits\LoadAndPublishDataTrait;
use Botble\Language\Repositories\Interfaces\LanguageInterface;
use Illuminate\Routing\Events\RouteMatched;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Route;

class AIWriterServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function register()
    {
        Helper::autoload(__DIR__ . '/../../helpers');
    }

    public function boot()
    {
        $this->setNamespace('plugins/ai-writer')
            ->loadAndPublishTranslations()
            ->loadAndPublishViews()
            ->loadRoutes(['web']);

        add_filter(BASE_FILTER_AFTER_SETTING_CONTENT, [$this, 'addSettings'], 49);
        add_filter(BASE_FILTER_FORM_EDITOR_BUTTONS, [$this, 'addPageBuilderButton'], 120, 1);

        add_shortcode('ai-writer', __('AI writer'), __('AI writer'), function ($shortcode) {
            $content = $shortcode->content ?? '';

            return view('plugins/ai-writer::shortcodes.ai-writer', compact('content'))->render();
        });

        shortcode()->setAdminConfig('ai-writer', function ($attributes) {
            if (interface_exists(LanguageInterface::class)) {
                $activeLanguages = app()->make(LanguageInterface::class)->all()->pluck('lang_name', 'lang_name');
            } else {
                $activeLanguages = [
                    'English' => 'English',
                    'Spanish' => 'Spanish',
                    'Portuguese' => 'Portuguese',
                    'French' => 'French',
                    'Hindustani' => 'Hindustani',
                ];
            }

            return view('plugins/ai-writer::shortcodes.ai-writer-admin-config', compact('attributes', 'activeLanguages'))->render();
        });

        Event::listen(RouteMatched::class, function (): void {
        });
    }

    /**
     * @param null|string $data
     * @return string
     */
    public function addSettings($data = null)
    {
        return $data . view('plugins/ai-writer::settings')->render();
    }

    /**
     * @param string $data
     * @return string
     */
    public function addPageBuilderButton($data)
    {
        if (in_array(Route::currentRouteName(), ['pages.create', 'pages.edit', 'posts.create', 'posts.edit'])) {
            return $data . view('plugins/ai-writer::button');
        }

        return $data;
    }
}
