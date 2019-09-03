<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Store;
use Illuminate\Support\Facades\DB;
use App\StoreUser;
use Illuminate\Support\Facades\Storage;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        $user = User::where('first_name', 'Admin')->first();
//        dd($user->stores);

        return view('users.index');
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(string $slug)
    {
        $user = User::where(['slug' => $slug])->first();

        return view('users.edit');
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request)
    {
        $appStores = Store::all();
        if (request()->method() === 'POST') {
            $this->validate(request(), [
                'id' => 'required',
                'role' => 'required',

            ]);

            $user = User::where(['id' => request('id')])->first();
            $user->role = request('role');
            $user->email_verified_at = request('email_verified_at');
            $user->save();

            foreach ($appStores as $a => $appStore) {
                if (is_array(request('stores'))) {
                    if (in_array($appStore->id, request('stores'))) {
                        if (!StoreUser::where([['user_id', '=', request('id')], ['store_id', '=', $appStore->id]])->first()) {
                            $user->stores()->attach($appStore->id);
                        }
                    } else {
                        $user->stores()->detach($appStore->id);
                    }
                } else {
                    $user->stores()->detach($appStore->id);
                }
            }

            session()->flash('message', 'The user was successfully updated');

            return User::where(['id' => request('id')])->first();

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function test()
    {
        echo 'hello!';
//        echo json_encode(Storage::disk('local')->get('master_list_070219_1.csv'));
    }
}
