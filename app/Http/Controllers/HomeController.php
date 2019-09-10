<?php

namespace App\Http\Controllers;

use App\Invoice;
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
        $store_id = session()->get('store')->id;
        $delivery_date = session()->get('delivery_date');

        $items = Item::where('store_nbr', '=', $store_nbr)->first()->paginate(20);
//        dd($items);
        $invoice =  \App\Invoice::where('store_id', '=', $store_id)->where('delivery_date', '=', $delivery_date)->first();
//        dd($store_id, $delivery_date);
        session()->put('invoice', $invoice);
//        dd($invoice);

        return view('home', compact('items', 'invoice'));
    }

    public function store(Request $request)
    {
        if (request()->method() === 'POST') {

            $store = Store::where('id', request('selected-store'))->first();

            $delivery_date = request('delivery_date');

            session()->put('delivery_date', $delivery_date);

            session()->put('store', $store);

            return redirect()->home();
        }
        $user = auth()->user();

        session()->put('user', $user);

        $stores = $user->stores;


//        $delivery_dates = Invoice::where('store_id', '=', '124b880f-2b42-4ca6-98d7-8ccde000ba0a')->pluck('delivery_date');

//        $delivery_dates = Invoice::delivery_dates('124b880f-2b42-4ca6-98d7-8ccde000ba0a');
//
//        session()->put('delivery_dates', $delivery_dates);

        return view('store', compact('stores'));
    }
}
