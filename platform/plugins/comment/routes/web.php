<?php

use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Botble\Comment\Http\Controllers', 'middleware' => ['web', 'core']], function (): void {
    Route::group(['prefix' => BaseHelper::getAdminPrefix(), 'middleware' => 'auth'], function (): void {
        Route::group(['prefix' => 'comments', 'as' => 'comment.'], function (): void {
            Route::resource('', 'CommentController')->parameters(['' => 'comment']);

            Route::delete('items/destroy', [
                'as' => 'deletes',
                'uses' => 'CommentController@deletes',
                'permission' => 'comment.destroy',
            ]);

            Route::get('approve/{id}', [
                'as' => 'approve',
                'uses' => 'CommentController@approve',
                'permission' => 'comment.edit',
            ]);

            Route::post('save/setting', [
                'as' => 'storage-settings',
                'uses' => 'CommentController@storeSettings',
                'permission' => 'setting.options',
            ]);
        });

        Route::get('comment/settings', 'CommentController@getSettings')->name('comment.setting');
    });

    Route::post('comments/login/current', 'CommentController@checkCurrenUser')->name('comment.current-user');
});
