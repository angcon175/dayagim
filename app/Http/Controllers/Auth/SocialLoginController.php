<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\SocialSetting;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Validator;

class SocialLoginController extends Controller
{
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callback($provider)
    {
        try {
            $socialiteUser = Socialite::driver($provider)->user();
        } catch (\Exception $e) {
            return redirect()->route('users.login');
        }
        // dd($socialiteUser);

        $socialiteUserId = $socialiteUser->getId();
        $socialiteUserName = $socialiteUser->getName();
        $socialiteUseremail = $socialiteUser->getEmail();

        $user = User::where([
            'provider' => $provider,
            'provider_id' =>  $socialiteUserId,
        ])->first();

        if (!$user) {

            $validator = Validator::make(
                ['email' => $socialiteUseremail],
                ['email' => ['unique:users,email']],
                ['email.unique' => 'Couldn\'t login. Maybe you used a different login method?'],
            );

            if ($validator->fails()) {
                return redirect()->route('users.login')->withErrors($validator);
            }
            $name = $this->split_name($socialiteUserName);

            $random = Str::random(4);
            $username = $name[0].'_'.$random;

            $user = User::create([
                'name' => $socialiteUserName,
                'email' => $socialiteUseremail ?? $socialiteUserId,
                'username' => $username,
                'provider' => $provider,
                'provider_id' =>  $socialiteUserId,
            ]);
        }

        Auth::guard('user')->login($user);

        return redirect('/dashboard');
    }
    function split_name($name) {
        $name = trim($name);
        $last_name = (strpos($name, ' ') === false) ? '' : preg_replace('#.*\s([\w-]*)$#', '$1', $name);
        $first_name = trim( preg_replace('#'.$last_name.'#', '', $name ) );
        return array($first_name, $last_name);
    }
}
