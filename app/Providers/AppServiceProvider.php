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
            $stores = Store::all();
            $store_formats = StoreFormat::all();
            $items = Item::first()->paginate(10);
            $all_items = Item::all();
            $total_records = Item::get()->count();
//            dd($itemcnt);
//            dd($items);

            $view->with(compact(['items', 'total_records', 'all_items']));
        });

        view()->composer(['users.index'], function($view) {
            $users = User::first()->paginate(5);

            $view->with(compact(['users']));
        });

        view()->composer(['stores.index'], function($view) {
            $stores = Store::first()->paginate(10);
            $users = User::first()->paginate(10);
            $store_formats = StoreFormat::all();

            $view->with(compact(['stores', 'users', 'store_formats']));
        });


    }
}
