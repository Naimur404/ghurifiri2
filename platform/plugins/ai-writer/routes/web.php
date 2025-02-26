<?php

Route::group(['namespace' => 'Botble\AIWriter\Http\Controllers', 'middleware' => ['web', 'core']], function (): void {
    Route::group(apply_filters(BASE_FILTER_GROUP_PUBLIC_ROUTE, []), function (): void {
        Route::post('ajax/get-ai-content', 'AIWriterController@ajaxGetAIContent')
            ->name('theme.ajax-get-ai-content');
    });
});
