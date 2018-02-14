<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\TimeEntry;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Schema::defaultStringLength(191);

        view()->composer('*', function($view) {
            $runningTimeEntry = null;

            if (auth()->user()) {
                $userId = auth()->user()->id;
                $runningTimeEntry = TimeEntry::where(['user_id' => $userId , 'end' => null])->first();
            }
            
            $view->with('runningTimeEntry', $runningTimeEntry);

        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        require_once __DIR__ . '/../Http/helpers.php';
    }
}
