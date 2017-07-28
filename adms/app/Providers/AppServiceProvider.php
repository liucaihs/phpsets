<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

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
        DB::listen(function ($query) {
            file_put_contents('aaaaaaa.txt' ,
             $query->sql  .PHP_EOL .
            var_export(  $query->bindings , true )  .PHP_EOL.
             $query->time .PHP_EOL , FILE_APPEND);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
