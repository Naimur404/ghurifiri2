<?php

namespace Theme\UltraNews\Http\Controllers;

use Botble\Member\Http\Controllers\LoginController as MemberRegisterController;
use SeoHelper;
use Theme;

class RegisterController extends MemberRegisterController
{
    public function showRegistrationForm()
    {
        abort_if(theme_option('allow_account_login', '') != 'yes', 404);

        if (auth('member')->check()) {
            return redirect(route('public.member.dashboard'));
        }

        SeoHelper::setTitle(__('Register'));

        if (! session()->has('url.intended')) {
            session(['url.intended' => url()->previous()]);
        }

        Theme::breadcrumb()
            ->add(__('Home'), route('public.index'))
            ->add(__('Register'), route('public.member.register'));

        return Theme::scope('news.account.auth.register')->render();
    }
}
