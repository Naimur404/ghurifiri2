<?php

namespace Botble\Member\Http\Controllers;

use Botble\ACL\Traits\ResetsPasswords;
use Botble\Base\Http\Controllers\BaseController;
use Botble\SeoHelper\Facades\SeoHelper;
use Botble\Theme\Facades\Theme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ResetPasswordController extends BaseController
{
    use ResetsPasswords;

    public string $redirectTo = '/';

    public function __construct()
    {
        $this->redirectTo = route('public.member.dashboard');
    }

    public function showResetForm(Request $request, $token = null)
    {
        SeoHelper::setTitle(__('Reset Password'));

        $data = [
            'token' => $token,
            'email' => $request->input('email'),
        ];

        if (view()->exists(Theme::getThemeNamespace() . '::views.member.auth.passwords.reset')) {
            return Theme::scope('member.auth.passwords.reset', $data)->render();
        }

        return view('plugins/member::auth.passwords.reset', $data);
    }

    public function broker()
    {
        return Password::broker('members');
    }

    protected function guard()
    {
        return auth('member');
    }
}
