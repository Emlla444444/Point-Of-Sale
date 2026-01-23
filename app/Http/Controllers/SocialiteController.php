<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Socialite;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class SocialiteController extends Controller
{
    public function redirect($provider) {
        return Socialite::driver($provider)->redirect(); // call google
    }

    public function callback($provider) {
        $document = Socialite::driver($provider)->user();

        $data = [
            'name' => $document->name == null ? $document->nickname : $document->name,
            'email' => $document->email ,
            'profile' => $document->avatar ,
            'provider' => $provider ,
            'provider_id' => $document->id ,
            'provider_token' => $document->token ,
        ];
        $user = User::updateOrCreate([
            'provider_id' => $document->id
        ],$data);

        Auth::login($user);

        return to_route('user#home');

        // $user->token
        // $githubUser = Socialite::driver('github')->user();

        // $user = User::updateOrCreate([
        //     'github_id' => $githubUser->id,
        // ], [
        //     'name' => $githubUser->name,
        //     'email' => $githubUser->email,
        //     'github_token' => $githubUser->token,
        //     'github_refresh_token' => $githubUser->refreshToken,
        // ]);

        // Auth::login($user);

        // return redirect('/dashboard');
    }
}
