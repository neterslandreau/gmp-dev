<?php

namespace App\Http\Controllers;

use App\Store;
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
        if (!(session()->get('store'))) {
            return redirect('/store');
        }

        $selected_store = session()->get('selected-store');

        return view('home');
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
