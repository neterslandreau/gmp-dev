<?php

namespace App\Http\Controllers;

use App\Item;
use App\Imports\ItemsImport;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function import()
    {
        set_time_limit(500);

        $itemscsv = Storage::disk('local')->get('master_list_070219_1.csv');
        $rows = preg_split('/\n/',$itemscsv);
        foreach ($rows as $r => $row) {
            $row = str_getcsv($row);
            if ($r !== 0) {
                $item = new Item([
                    'name' => $row[3],
                    'upc_code' => $row[0],
                    'size' => $row[5],
                    'quantity' => $row[6],
                    'net_cost' => $row[15],
                    'net_case' => $row[32],
                ]);
                $item->save();
            }
        }
//        dd();
//
//        Excel::import(new ItemsImport, Storage::disk('local')->get('master_list_070219.csv'));
        session()->flash('message', 'The items was successfully imported');

        return redirect('/home');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $item)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Item $item)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {
        //
    }
}
