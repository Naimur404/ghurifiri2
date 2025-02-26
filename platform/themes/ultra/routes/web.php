<?php

use Botble\Member\Models\Member;

// Custom routes
Route::group(['namespace' => 'Theme\UltraNews\Http\Controllers', 'middleware' => ['web', 'core']], function (): void {
    Route::group(apply_filters(BASE_FILTER_GROUP_PUBLIC_ROUTE, []), function (): void {
        // Add your custom route here
        Route::get('ajax/get-panel-inner', 'UltraNewsController@ajaxGetPanelInner')
            ->name('theme.ajax-get-panel-inner');
    });
});

Theme::routes();

Route::group(['namespace' => 'Theme\UltraNews\Http\Controllers', 'middleware' => ['web', 'core']], function (): void {
    Route::group(apply_filters(BASE_FILTER_GROUP_PUBLIC_ROUTE, []), function (): void {
        Route::get('posts/videos', 'UltraNewsController@getNewsVideos')
            ->name('public.posts-videos');

        Route::get(SlugHelper::getPrefix(Member::class, 'author') . '/{slug}')
            ->uses('UltraNewsController@getAuthor')
            ->name('author.show');

        Route::get('login', 'LoginController@showLoginForm')
            ->name('public.member.login');

        Route::get('register', 'RegisterController@showRegistrationForm')
            ->name('public.member.register');

        Route::get(
            'password/request',
            'ForgotPasswordController@showLinkRequestForm'
        )->name('public.member.password.request');
    });
});
