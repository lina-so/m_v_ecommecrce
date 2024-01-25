<?php

namespace App\Providers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Laravel\Fortify\Fortify;
use Illuminate\Support\Facades\Auth;
use App\Actions\Fortify\CreateNewUser;
use Illuminate\Support\Facades\Config;
use App\Actions\Fortify\CreateNewAdmin;
use Illuminate\Support\ServiceProvider;
use App\Actions\Fortify\CreateNewVendor;
use Illuminate\Cache\RateLimiting\Limit;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use Illuminate\Support\Facades\RateLimiter;
use Laravel\Fortify\Contracts\LoginResponse;
use Illuminate\Validation\ValidationException;
use App\Actions\Fortify\UpdateUserProfileInformation;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $request = request();
        if($request->is('admin/*') )
        {
            Config::set('fortify.guard','admin');
            Config::set('fortify.passwords','admins');
            Config::set('fortify.prefix','admin');
            Config::set('fortify.home','admin/dashboard/dashboard');
        }
        else if($request->is('vendor/*') )
        {
            Config::set('fortify.guard','vendor');
            Config::set('fortify.passwords','vendors');
            Config::set('fortify.prefix','vendor');
            Config::set('fortify.home','vendor/dashboard/dashboard');
        }else
        {
            Config::set('fortify.guard','web');
            Config::set('fortify.passwords','web');
            Config::set('fortify.prefix','');
            Config::set('fortify.home','home');
        }

        // dd(Config::get('fortify.guard') );

    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {


        Fortify::verifyEmailView(function () {
            return view('auth.verify-email');
        });

        Fortify::registerView(function () {
            return view('auth.register');
        });

        if(Config::get('fortify.guard') == 'web'){
            Fortify::createUsersUsing(CreateNewUser::class);
        }
        else if(Config::get('fortify.guard') == 'admin')
        {
           Fortify::createUsersUsing(CreateNewAdmin::class);
        }
        else if(Config::get('fortify.guard') == 'vendor')
        {
           Fortify::createUsersUsing(CreateNewVendor::class);
        }


        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())).'|'.$request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });


        // Fortify::viewPrefix('auth.');

        if(Config::get('fortify.guard') == 'web' || Config::get('fortify.guard') == 'vendor')
        {
            Fortify::loginView(function () {
                return view('auth.login');
            });
        }
        else{
            Fortify::loginView(function () {
                return view('dashboard.admin.auth.login');
            });
        }

    }
}
