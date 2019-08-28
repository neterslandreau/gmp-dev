<?php

namespace App\Http\Controllers;

use App\Store;
use App\User;
use App\StoreFormat;
use Illuminate\Http\Request;

class StoresController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stores = Store::all();
        $users = User::all();

        $store_formats = StoreFormat::all();

//        dd($stores);

        return view('stores.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function show(Store $store)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function edit(Store $store)
    {
        //
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request)
    {
        if (request()->method() === 'POST') {

//            $this->validate(request(), [
//                'id' => 'required',
//                'store_format_id' => 'required',
//
//            ]);

//            dd(request('store_format_id'));
            $store = Store::where(['id' => request('id')])->first();
            $store->manager_id = request('manager_id');
            if (request('manager_id')) {
                $user = User::where(['id' => request('manager_id')])->first();
                $user->store_id = request('manager_id');
                $user->save();
            }
            $store->store_format_id = request('store_format_id');
            $store->save();

            session()->flash('message', 'The store was successfully updated');
            return redirect()->home();
//            dd( request('manager_id'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function destroy(Store $store)
    {
        //
    }
}
