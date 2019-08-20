<?php

namespace App\Providers;

use App\Store;
use App\Item;
use App\User;
use App\StoreFormat;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::withoutDoubleEncoding();

        view()->composer(['home'], function($view) {
            $users = User::get();
            $stores = Store::all();
            $store_formats = StoreFormat::all();
            $items = Item::first()->paginate(5);

//            echo '<pre>';
//            print_r($stores);
//            echo '</pre>';
//
//            echo '<pre>';
//            print_r($store_formats);
//            echo '</pre>';

//            dd($stores[0]->manager());

            $view->with(compact('stores', 'users', 'store_formats', 'items'));
        });


    }
}
