<?php
namespace App\Pages;

use App\Http\Common\Component;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;

#[Layout('layouts.auth')]
class Login extends Component
{
    public $username;
    public $password;
    public $remember;

    public function login()
    {
        $this->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $this->ensureIsNotRateLimited();

        if (Auth::attempt([
            'username' => $this->username,
            'password' => $this->password,
            'is_banned' => null,
        ], $this->password)) {
            return redirect()->intended(RouteServiceProvider::HOME);
        } elseif (Auth::attempt([
            'mobile' => $this->username,
            'password' => $this->password,
            'is_banned' => null,
        ], $this->password)) {
            return redirect()->intended(RouteServiceProvider::HOME);
        } else {
            RateLimiter::hit($this->throttleKey());

            if (User::where('username', $this->username)->whereNotNull('is_banned')->exists()) {
                $this->addError('username', 'Your account is banned. Please contact admin.');

                return true;
            }

            throw ValidationException::withMessages([
                'username' => __('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
    }

    public function ensureIsNotRateLimited()
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'username' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    public function throttleKey()
    {
        return Str::lower($this->username) . '|' . request()->ip();
    }

    public function render()
    {
        return view('pages.login');
    }
}