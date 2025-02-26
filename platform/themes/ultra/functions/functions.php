<?php

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Models\MetaBox as MetaBoxModel;
use Botble\Blog\Models\Category;
use Botble\Blog\Models\Post;
use Botble\Blog\Repositories\Interfaces\PostInterface;
use Botble\Comment\Repositories\Interfaces\CommentInterface;
use Botble\Comment\Repositories\Interfaces\CommentRecommendInterface;
use Botble\Member\Models\Member;
use Botble\Member\Repositories\Interfaces\MemberInterface;
use Botble\Slug\Models\Slug;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Theme\UltraNews\Http\Requests\CustomPostRequest;
use Theme\UltraNews\Repositories\Eloquent\PostRepository;
use TheSky\ProPosts\Repositories\Interfaces\FavoritePostsInterface;

register_page_template([
    'default' => __('Default'),
    'full' => __('Full'),
    'homepage' => __('Homepage'),
    'homepage2' => __('Homepage 2'),
    'no-breadcrumbs' => __('No Breadcrumbs'),
    'right-sidebar' => __('Right sidebar'),
]);

register_sidebar([
    'id' => 'footer_sidebar_1',
    'name' => __('Footer sidebar 1'),
    'description' => __('Sidebar in the footer of page'),
]);

register_sidebar([
    'id' => 'footer_sidebar_2',
    'name' => __('Footer sidebar 2'),
    'description' => __('Sidebar in the footer of page'),
]);

register_sidebar([
    'id' => 'footer_sidebar_3',
    'name' => __('Footer sidebar 3'),
    'description' => __('Sidebar in the footer of page'),
]);

register_sidebar([
    'id' => 'footer_sidebar_4',
    'name' => __('Footer sidebar 4'),
    'description' => __('Sidebar in the footer of page'),
]);

register_sidebar([
    'id' => 'footer_copyright_menu',
    'name' => __('Footer copyright menu'),
]);

RvMedia::setUploadPathAndURLToPublic();

RvMedia::addSize('large', 1024)
    ->addSize('medium_large', 600, 421)
    ->addSize('medium', 400, 400);

if (is_plugin_active('blog')) {
    app()->bind(PostInterface::class, function () {
        return new PostRepository(new Post());
    });

    if (! function_exists('get_post')) {
        function get_post(): Post|null|bool
        {
            if (Route::currentRouteName() == 'public.single') {
                $slug = SlugHelper::getSlug(request()->route('slug'), '');
                if ($slug->reference_type == Post::class) {
                    return app(PostInterface::class)
                        ->getFirstBy([
                            'id' => $slug->reference_id,
                            'status' => BaseStatusEnum::PUBLISHED,
                        ], ['*']);
                }

                return false;
            }

            return false;
        }
    }

    if (! function_exists('query_post')) {
        function query_post(array $params): Collection|LengthAwarePaginator
        {
            $filters = [
                'limit' => empty($params['limit']) ? 10 : $params['limit'],
                'format_type' => $params['format_type'] ?? '',
                'categories' => empty($params['categories']) ? null : explode(',', $params['categories']),
                'categories_exclude' => empty($params['categories_exclude']) ? null : explode(
                    ',',
                    $params['categories_exclude']
                ),
                'exclude' => empty($params['exclude']) ? null : explode(',', $params['exclude']),
                'include' => empty($params['include']) ? null : explode(',', $params['include']),
                'order_by' => empty($params['order_by']) ? 'updated_at' : $params['order_by'],
            ];

            if (isset($params['featured'])) {
                $filters['featured'] = $params['featured'];
            }

            return app(PostInterface::class)->getFilters($filters);
        }
    }

    register_post_format([
        'video' => [
            'key' => 'video',
            'icon' => 'fa fa-camera',
            'name' => 'Video',
        ],
    ]);

    add_action(BASE_ACTION_META_BOXES, function ($context, $object): void {
        if (get_class($object) == Category::class && $context == 'side') {
            MetaBox::addMetaBox('additional_blog_category_fields', __('Addition Information'), function () {
                $image = null;
                $args = func_get_args();
                if (! empty($args[0])) {
                    $image = MetaBox::getMetaData($args[0], 'image', true);
                }

                return Theme::partial('blog-category-fields', compact('image'));
            }, get_class($object), $context);
        }
    }, 24, 2);

    add_action(BASE_ACTION_AFTER_CREATE_CONTENT, function ($type, $request, $object): void {
        if (get_class($object) == Category::class && $request->has('image')) {
            MetaBox::saveMetaBoxData($object, 'image', $request->input('image'));
        }
    }, 230, 3);

    add_action(BASE_ACTION_AFTER_UPDATE_CONTENT, function ($type, $request, $object): void {
        if (get_class($object) == Category::class && $request->has('image')) {
            MetaBox::saveMetaBoxData($object, 'image', $request->input('image'));
        }
    }, 231, 3);

    add_action(BASE_ACTION_META_BOXES, 'add_addition_fields_in_post_screen', 30, 3);

    if (is_plugin_active('external-source')) {
        add_filter(BASE_FILTER_BEFORE_RENDER_FORM, 'add_external_source_fields_into_form', 127, 2);

        function add_external_source_fields_into_form($form, $data)
        {
            if (get_class($data) == Post::class) {
                $form
                    ->addAfter('format_type', 'external_source_link', 'text', [
                        'label' => __('Bookmark external link'),
                        'label_attr' => ['class' => 'control-label'],
                        'attr' => [
                            'placeholder' => __('Bookmark external link'),
                        ],
                    ])
                    ->addAfter('format_type', 'source_link', 'text', [
                        'label' => __('Source link'),
                        'label_attr' => ['class' => 'control-label'],
                        'attr' => [
                            'placeholder' => __('Source link'),
                        ],
                    ]);
            }

            return $form;
        }
    }

    function add_addition_fields_in_post_screen($context, $object): void
    {
        if (get_class($object) == Post::class && $context == 'top') {
            MetaBox::addMetaBox(
                'additional_post_fields',
                __('Addition Information'),
                function () {
                    $layout = null;
                    $timeToRead = null;
                    $args = func_get_args();
                    if (! empty($args[0])) {
                        $layout = MetaBox::getMetaData($args[0], 'layout', true);
                        $timeToRead = MetaBox::getMetaData($args[0], 'time_to_read', true);
                    }

                    return Theme::partial('metabox.time-to-read', compact('layout', 'timeToRead'));
                },
                get_class($object),
                $context
            );
        }

        //add metabox video
        if (get_class($object) == Post::class && $context == 'advanced') {
            MetaBox::addMetaBox(
                'video_post_fields',
                __('Video'),
                function () {
                    $videoLink = null;
                    $args = func_get_args();
                    if (! empty($args[0])) {
                        $videoLink = MetaBox::getMetaData($args[0], 'video_link', true);
                        $videoEmbedCode = MetaBox::getMetaData($args[0], 'video_embed_code', true);
                        $videoUploadId = MetaBox::getMetaData($args[0], 'video_upload_id', true);
                    }

                    return Theme::partial(
                        'metabox.video-field',
                        compact('videoLink', 'videoEmbedCode', 'videoUploadId')
                    );
                },
                get_class($object),
                $context
            );
        }
    }

    add_action(BASE_ACTION_AFTER_CREATE_CONTENT, 'save_addition_post_fields', 230, 3);
    add_action(BASE_ACTION_AFTER_UPDATE_CONTENT, 'save_addition_post_fields', 231, 3);

    function save_addition_post_fields($type, $request, $object): void
    {
        if (is_plugin_active('blog') && get_class($object) == Post::class) {
            if ($request->has('layout')) {
                MetaBox::saveMetaBoxData($object, 'layout', $request->input('layout'));
            }

            if ($request->has('time_to_read')) {
                MetaBox::saveMetaBoxData($object, 'time_to_read', $request->input('time_to_read'));
            }

            if ($request->has('video_link')) {
                MetaBox::saveMetaBoxData($object, 'video_link', $request->input('video_link'));
            }

            if ($request->has('video_embed_code')) {
                MetaBox::saveMetaBoxData($object, 'video_embed_code', $request->input('video_embed_code'));
            }

            if ($request->has('video_upload_id')) {
                MetaBox::saveMetaBoxData($object, 'video_upload_id', $request->input('video_upload_id'));
            }
        }
    }
}

if (is_plugin_active('member')) {
    SlugHelper::registerModule(Member::class, 'Authors');
    SlugHelper::setPrefix(Member::class, 'author');

    add_action(BASE_ACTION_AFTER_CREATE_CONTENT, function ($type, $request, $object): void {
        save_member_slug($type, $request, $object);
    }, 124, 3);

    add_action(BASE_ACTION_AFTER_UPDATE_CONTENT, function ($type, $request, $object): void {
        save_member_slug($type, $request, $object);
    }, 125, 3);

    function save_member_slug($type, $request, $object): void
    {
        if ($type == MEMBER_MODULE_SCREEN_NAME) {
            $memberSlug = $object->slug;

            if (empty($memberSlug)) {
                $slug = Str::slug($object->name);

                //check slug exist
                $slugExist = Slug::query()->where('key', $slug)
                    ->where('reference_type', Member::class)
                    ->where('prefix', 'author')
                    ->first();

                if (! empty($slugExist)) {
                    $slug .= time();
                }

                Slug::query()->create([
                    'reference_type' => Member::class,
                    'reference_id' => $object->id,
                    'key' => $slug,
                    'prefix' => 'author',
                ]);
            }
        }
    }
}

app()->booted(function (): void {
    if (is_plugin_active('blog')) {
        Category::resolveRelationUsing('image', function ($model) {
            return $model->morphOne(MetaBoxModel::class, 'reference')->where('meta_key', 'image');
        });
    }

    if (setting('social_login_enable', false)) {
        remove_filter(BASE_FILTER_AFTER_LOGIN_OR_REGISTER_FORM);
        add_filter(BASE_FILTER_AFTER_LOGIN_OR_REGISTER_FORM, 'addLoginOptionsByTheme', 25);
    }
});

if (is_plugin_active('ads')) {
    AdsManager::registerLocation('panel-ads', __('Panel Ads'))
        ->registerLocation('header-ads', __('Header Ads'))
        ->registerLocation('top-sidebar-ads', __('Top Sidebar Ads'))
        ->registerLocation('bottom-sidebar-ads', __('Bottom Sidebar Ads'))
        ->registerLocation('custom-1', __('Custom 1'))
        ->registerLocation('custom-2', __('Custom 2'))
        ->registerLocation('custom-3', __('Custom 3'));
}

Form::component('themeIcon', Theme::getThemeNamespace() . '::partials.icons-field', [
    'name',
    'value' => null,
    'attributes' => [],
]);

if (! function_exists('get_category_layout')) {
    function get_category_layout(): array
    {
        return [
            'list' => __('List'),
            'grid' => __('Grid'),
            'metro' => __('Metro'),
        ];
    }
}

if (! function_exists('get_single_layout')) {
    function get_single_layout(): array
    {
        return [
            'default' => __('Default'),
            'top-full' => __('Top full'),
            'inline' => __('Inline'),
        ];
    }
}

if (! function_exists('get_related_style')) {
    function get_related_style(): array
    {
        return [
            'default' => __('Default'),
            'popup' => __('Popup'),
        ];
    }
}

if (! function_exists('display_ad')) {
    function display_ad(string $location, array $attributes = []): string
    {
        if (! is_plugin_active('ads') || empty($location)) {
            return '';
        }

        return AdsManager::display($location, $attributes);
    }
}

if (! function_exists('random_background')) {
    function random_background(): string
    {
        $backgrounds = [
            'background2',
            'background3',
            'background1',
            'background5',
            'background7',
            'background9',
            'background10',
        ];

        return $backgrounds[array_rand($backgrounds)];
    }
}

if (! function_exists('get_background_styles')) {
    /**
     * @return array
     */
    function get_background_styles()
    {
        return [
            '' => __('Not set'),
            'background-white' => __('Background White'),
        ];
    }
}

if (! function_exists('get_time_to_read')) {
    function get_time_to_read(Post $post): string
    {
        $timeToRead = MetaBox::getMetaData($post, 'time_to_read', true);

        if ($timeToRead) {
            return number_format($timeToRead);
        }

        return number_format(strlen(strip_tags($post->content)) / 300);
    }
}

if (! function_exists('post_date_format')) {
    function post_date_format(bool $longType = true): ?string
    {
        if ($longType) {
            return theme_option('post_date_format', 'd M, Y');
        }

        return theme_option('post_date_short_format', 'M d');
    }
}

if (! function_exists('is_video_post')) {
    function is_video_post(Post $post): bool
    {
        return $post->format_type == 'video';
    }
}

if (is_plugin_active('blog')) {
    add_filter(BASE_FILTER_BEFORE_RENDER_FORM, function ($form, $data) {
        if (auth()->user() && get_class($data) == Post::class) {
            $authors = app()->make(MemberInterface::class)
                ->allBy([]);

            $authorsArray = [];
            foreach ($authors as $author) {
                $authorsArray[$author->id] = $author->name;
            }

            $form
                ->setValidatorClass(CustomPostRequest::class)
                ->addAfter('status', 'author_id', 'customSelect', [
                    'label' => __('Author'),
                    'label_attr' => ['class' => 'control-label required'],
                    'attr' => [
                        'placeholder' => __('Select an author...'),
                    ],
                    'choices' => $authorsArray,
                ]);
        }

        return $form;
    }, 127, 2);

    add_action(BASE_ACTION_AFTER_CREATE_CONTENT, function ($type, $request, $object): void {
        if (auth()->user() && get_class($object) == Post::class) {
            $object->author_id = $request->input('author_id');
            $object->author_type = Member::class;
            $object->save();
        }
    }, 123, 3);

    add_action(BASE_ACTION_AFTER_UPDATE_CONTENT, function ($type, $request, $object): void {
        if (auth()->user() && get_class($object) == Post::class) {
            $object->author_id = $request->input('author_id');
            $object->author_type = Member::class;
            $object->save();
        }
    }, 123, 3);

    if (! function_exists('get_recent_comment_posts')) {
        function get_recent_comment_posts(int $limit = 4)
        {
            if (! is_plugin_active('comment')) {
                return [];
            }

            $latestCommentIds = app(CommentInterface::class)
                ->getModel()
                ->where('reference_type', Post::class)
                ->groupBy('reference_id')
                ->orderBy('created_at', 'DESC')
                ->selectRaw('reference_id, max(created_at) as created_at')
                ->limit($limit)
                ->pluck('reference_id');

            return app(PostInterface::class)
                ->getModel()
                ->whereIn('id', $latestCommentIds)
                ->get();
        }
    }

    if (! function_exists('get_most_comment_posts')) {
        function get_most_comment_posts(int $limit = 4)
        {
            return app(PostInterface::class)
                ->getModel()
                ->withCount('comments')
                ->orderBy('comments_count', 'DESC')
                ->take($limit)
                ->get();
        }
    }
}

if (! function_exists('get_total_comment')) {
    function get_total_comment($object): ?int
    {
        if (is_plugin_active('comment')) {
            if (setting('enable_cache')) {
                $cacheKey = md5('total-comment-' . get_class($object) . 'id-' . $object->id);
                if (Cache::has($cacheKey)) {
                    return Cache::get($cacheKey);
                }
            }

            $totalComment = app(CommentInterface::class)
                ->getModel()
                ->where('reference_type', get_class($object))
                ->where('reference_id', $object->id)
                ->count();

            if (setting('enable_cache')) {
                Cache::put($cacheKey, $totalComment, setting('cache_time', 3600));
            }

            return $totalComment;
        }

        return null;
    }

    function get_total_like($object): ?int
    {
        if (is_plugin_active('comment')) {
            if (setting('enable_cache')) {
                $cacheKey = md5('total-like-' . get_class($object) . 'id-' . $object->id);
                if (Cache::has($cacheKey)) {
                    return Cache::get($cacheKey);
                }
            }

            $totalLike = app(CommentRecommendInterface::class)
                ->getModel()
                ->where('reference_type', get_class($object))
                ->where('reference_id', $object->id)
                ->count();

            if (setting('enable_cache')) {
                Cache::put($cacheKey, $totalLike, setting('cache_time', 3600));
            }

            return $totalLike;
        }

        return null;
    }
}

if (! function_exists('comment_object_enable')) {
    function comment_object_enable($object): bool
    {
        $commentStatus = $object->getMetaData('comment_status', true);

        return setting('comment_enable') && ($commentStatus == 1 || $commentStatus == '') &&
            in_array(get_class($object), json_decode(setting('comment_menu_enable', '[]'), true));
    }
}

function addLoginOptionsByTheme(?string $html): string
{
    if (Route::currentRouteName() == 'access.login') {
        if (defined('THEME_OPTIONS_MODULE_SCREEN_NAME')) {
            Theme::asset()
                ->usePath(false)
                ->add(
                    'social-login-css',
                    asset('vendor/core/plugins/social-login/css/social-login.css'),
                    [],
                    [],
                    '1.0.0'
                );
        }

        return $html . view('plugins/social-login::login-options')->render();
    }

    return $html . Theme::partial('login-options');
}

function getIsFavoritePost(string $postId): bool
{
    return auth()->guard('member')->check() &&
        ! empty(auth()->guard('member')->user()->favorite_posts) &&
        in_array($postId, json_decode(auth()->guard('member')->user()->favorite_posts, true));
}

function getIsBookmarkPost(string $postId): bool
{
    return auth()->guard('member')->check() &&
        ! empty(auth()->guard('member')->user()->bookmark_posts) &&
        in_array($postId, json_decode(auth()->guard('member')->user()->bookmark_posts, true));
}

function getPostTotalFavorite(string $postId)
{
    return app()->make(FavoritePostsInterface::class)->count([
        'post_id' => $postId,
        'user_id' => auth()->guard('member')->id(),
        'type' => 'favorite',
    ]);
}

if (! function_exists('get_external_link')) {
    function get_external_link($post)
    {
        if (is_plugin_active('external-source') && ! empty($post->external_source_link)) {
            return $post->external_source_link;
        }

        return $post->url;
    }
}

if (! function_exists('is_external_link')) {
    function is_external_link(Post $post): bool
    {
        return is_plugin_active('external-source') && ! empty($post->external_source_link);
    }
}

if (! function_exists('nextPost')) {
    function nextPost($postId, $categoryIds)
    {
        return app(PostInterface::class)
            ->getModel()
            ->where('id', '>', $postId)
            ->orderBy('id')
            ->whereHas('categories', function ($query) use ($categoryIds): void {
                $query->whereIn('categories.id', $categoryIds);
            })
            ->first();
    }
}

if (! function_exists('previousPost')) {
    function previousPost($postId, $categoryIds)
    {
        return app(PostInterface::class)
            ->getModel()
            ->where('id', '<', $postId)
            ->orderBy('id', 'desc')
            ->whereHas('categories', function ($query) use ($categoryIds): void {
                $query->whereIn('categories.id', $categoryIds);
            })
            ->first();
    }
}
