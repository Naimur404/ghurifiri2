<?php

namespace Theme\UltraNews\Http\Controllers;

use Botble\Member\Http\Controllers\LoginController as MemberLoginController;
use SeoHelper;
use Theme;

class LoginController extends MemberLoginController
{
    public function showLoginForm()
    {
        abort_if(theme_option('allow_account_login', '') != 'yes', 404);

        SeoHelper::setTitle(trans('plugins/member::member.login'));

        if (! session()->has('url.intended')) {
            session(['url.intended' => url()->previous()]);
        }

        Theme::breadcrumb()->add(__('Home'), route('public.index'))->add(__('Login'), route('public.member.login'));

        return Theme::scope('news.account.auth.login')->render();
    }
}
