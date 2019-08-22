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

    /**
     * @param Request $request
     */
    function search(Request $request)
    {
        if ($request->ajax()) {
            $output = '';
            $modalout = '';
            $query = $request->get('query');
            if ($query != '') {
                $data = DB::table('items')
                    ->where("name", "like", "%".$query."%")
                    ->orWhere("upc_code", "like", "%".$query."%")
                    ->orWhere("size", "like", "%".$query."%")
                    ->orWhere("net_cost", "like", "%".$query."%")
                    ->orWhere("net_case", "like", "%".$query."%")
                    ->orWhere("retail", "like", "%".$query."%")
                    ->orderBy("slug", "desc")
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
                        <td name="slug">'.$row->slug.'</td>
                         <td name="name">'.$row->name.'</td>
                         <td name="upc_code">'.$row->upc_code.'</td>
                         <td name="size">'.$row->size.'</td>
                         <td name="retail">'.$row->retail.'</td>
                         <td name="net_cost">'.$row->net_cost.'</td>
                         <td name="net_case">'.$row->net_case.'</td>
                         <td name="modal_link"><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#itemmodal_'.$row->id.'">View</button></td>
                        </tr>
';
                    $modalout .= '
                    <div class="modal fade" id="itemmodal_'.$row->id.'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document"><div class="modal-content"><div class="modal-header">
                    <h5 class="modal-title" id="modal_'.$row->id.'">'.$row->name.'</h5<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button></div><div class="modal-body">
                    <form id="form_'.$row->id.'">
                    <div class="form-group"><label for="'.$row->name.'">Name</label><input type="text" name="name" class="form-control" value="'.$row->name.'" readonly></div>
                    <div class="form-group"><label for="'.$row->upc_code.'">UPC Code</label><input type="text" name="upc_code" class="form-control" value="'.$row->upc_code.'" readonly></div>
                    <div class="form-group"><label for="'.$row->size.'">Size</label><input type="text" name="size" class="form-control" value="'.$row->size.'" readonly></div>
                    <div class="form-group"><label for="'.$row->quantity.'">Quantity</label><input type="text" name="quantity" class="form-control" value="'.$row->quantity.'" readonly></div>
                    <div class="form-group"><label for="'.$row->net_case.'">Net Case</label><input type="text" name="net_case" class="form-control" value="'.$row->net_case.'" readonly></div>
                    <div class="form-group"><label for="'.$row->net_cost.'">Net Cost</label><input type="text" name="net_cost" class="form-control" value="'.$row->net_cost.'" readonly></div>
                    <div class="form-group"><label for="'.$row->retail.'">Retail</label><input type="text" name="net_cost" class="form-control" value="'.$row->retail.'" readonly></div>
                    </form></div>
                    <div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button><button type="button" class="btn btn-primary" id="itemsave_'.$row->id.'">Save changes</button></div></div></div></div>';
                }
            }
            else {
                $output = '
                   <tr>
                    <td align="center" colspan="7">No Data Found</td>
                   </tr>
';
            }
            $data = array(
                'table_data'  => $output,
                'total_data'  => $total_row,
                'modal_data' => $modalout
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
