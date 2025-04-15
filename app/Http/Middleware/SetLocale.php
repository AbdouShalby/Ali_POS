<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if locale is set in the session
        if (Session::has('locale')) {
            $locale = Session::get('locale');
            
            // Ensure the locale is valid
            if (in_array($locale, ['en', 'ar'])) {
                // Set the application locale
                App::setLocale($locale);
                
                // Set locale for Carbon dates
                setlocale(LC_TIME, $locale == 'ar' ? 'ar_SA.UTF-8' : 'en_US.UTF-8');
                
                // Update config
                Config::set('app.locale', $locale);
                
                // Set RTL/LTR direction
                $request->session()->put('text_direction', $locale == 'ar' ? 'rtl' : 'ltr');
            }
        }
        
        return $next($request);
    }
}
