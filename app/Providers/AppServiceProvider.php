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
//        \Debugbar::disable();
        Blade::withoutDoubleEncoding();

        view()->composer(['home'], function($view) {
            $stores = Store::all();
            $store_formats = StoreFormat::all();
//            $items = Item::first()->paginate(60);
//            $items = Item::all();
//            $all_items = Item::all();
//            $total_records = Item::get()->count();
//            dd($itemcnt);
//            dd($items);

//            $view->with(compact(['items', 'total_records', 'all_items']));
        });

        view()->composer(['users.index'], function($view) {
            $users = User::first()->paginate(5);
            $stores = Store::all();

            $view->with(compact(['users', 'stores']));
        });

        view()->composer(['stores.index'], function($view) {
            $stores = Store::first()->paginate(5);
            $users = User::all();
            $store_formats = StoreFormat::all();

            $view->with(compact(['stores', 'users', 'store_formats']));
        });


    }
}
