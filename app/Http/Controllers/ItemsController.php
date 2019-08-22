<?php

namespace App\Http\Controllers;

use App\Item;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class ItemsController extends Controller
{
    public function import()
    {
        set_time_limit(500);

        $itemscsv = Storage::disk('local')->get('master_list_070219_1.csv');
        $rows = array_map('str_getcsv', explode("\n", $itemscsv));
        dd($rows);
        foreach ($rows as $r => $row) {
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

    function search(Request $request)
    {
        if ($request->ajax()) {
            $output = '';
            $query = $request->get('query');
            if ($query != '') {
                $data = DB::table('items')
                    ->where('name', 'like', '%'.$query.'%')
                    ->orWhere('upc_code', 'like', '%'.$query.'%')
                    ->orWhere('size', 'like', '%'.$query.'%')
                    ->orWhere('net_cost', 'like', '%'.$query.'%')
                    ->orWhere('net_case', 'like', '%'.$query.'%')
                    ->orderBy('slug', 'asc')
                    ->get();

            }
            else {
                $data = DB::table('items')
                    ->orderBy('slug', 'desc')
                    ->get();
            }
            $total_row = $data->count();
            if ($total_row > 0) {
                foreach ($data as $row) {
                    $output .= '
        <tr>
        <td>'.$row->slug.'</td>
         <td>'.$row->name.'</td>
         <td>'.$row->upc_code.'</td>
         <td>'.$row->size.'</td>
         <td>'.$row->net_cost.'</td>
         <td>'.$row->net_case.'</td>
        </tr>
        ';
                }
            }
            else {
                $output = '
       <tr>
        <td align="center" colspan="5">No Data Found</td>
       </tr>
       ';
            }
            $data = array(
                'table_data'  => $output,
                'total_data'  => $total_row
            );

            echo json_encode($data);
        }
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
