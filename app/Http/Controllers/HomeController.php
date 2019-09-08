<?php

namespace App\Http\Controllers;

use App\Store;
use App\Item;
use App\StoreUser;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['verified', 'auth']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
//        app('debugbar')->disable();

        if (!(session()->get('store'))) {
            return redirect('/store');
        }

        $selected_store = session()->get('selected-store');

        $store_nbr = str_pad(session()->get('store')->number, 4, 0,STR_PAD_LEFT);
//        dd($store_nbr);

        $items = Item::where('store_nbr', '=', $store_nbr)->first()->paginate(10);

        return view('home', compact('items'));
    }

    public function store(Request $request)
    {
        if (request()->method() === 'POST') {

            $store = Store::where('id', request('selected-store'))->first();

            session()->put('store', $store);

            return redirect()->home();
        }
        $user = auth()->user();

        session()->put('user', $user);

        $stores = $user->stores;

        return view('store', compact('stores'));
    }
}
