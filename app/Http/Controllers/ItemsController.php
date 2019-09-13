<?php

namespace App\Http\Controllers;

use App\CaseEligibleAllowance;
use App\Item;
use App\InvoiceDetail;
use App\InvoiceDetailAllowance;
use App\OrderExemption;
use App\InvoiceTotal;
use App\DeliveryCharge;
use App\Store;
use App\Invoice;
use App\Sales;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ItemsController extends Controller
{

    /**
     * search, duh
     *
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
                    ->where("description", "like", "%".$query."%")
                    ->orWhere("upc_code", "like", "%".$query."%")
                    ->orWhere("size", "like", "%".$query."%")
//                    ->orWhere("net_cost", "like", "%".$query."%")
//                    ->orWhere("net_case", "like", "%".$query."%")
//                    ->orWhere("retail", "like", "%".$query."%")
                    ->orderBy("slug", "asc")
                    ->get();

            }
            else {
                $data = DB::table('items')
                    ->orderBy('slug', 'asc')
                    ->get();
            }
            $total_row = $data->count();
            if ($total_row > 0) {
                foreach ($data as $row) {
                    $output .= '
                        <tr id="item_'.$row->id.'" class="items-tr"  data-toggle="modal" data-target="#itemmodal_'.$row->id.'">
                         <td name="upc_code">'.str_pad($row->upc_code,15, 0, STR_PAD_LEFT).'</td>
                         <td name="description">'.$row->description.'</td>
                         <td name="pack">'.$row->pack.'</td>
                         <td name="size">'.$row->size.'</td>
                         <td name="retail">'.$row->retail.'</td>
                         <td name="quantity">'.$row->quantity.'</td>
                         <td name="gross_margin">'.$row->gross_margin.'</td>
                         <td name="net_cost">'.$row->net_cost.'</td>
                         <td name="net_case">'.$row->net_case.'</td>
                        </tr>
';
                    $modalout .= '
                    <div class="modal fade" id="itemmodal_'.$row->id.'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document"><div class="modal-content"><div class="modal-header">
                    <h5 class="modal-title" id="modal_'.$row->id.'">'.$row->description.'</h5<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button></div><div class="modal-body">
                    <form id="form_'.$row->id.'">
                    <div class="form-group"><label for="'.$row->upc_code.'">UPC Code</label><input type="text" name="upc_code" class="form-control" value="'.$row->upc_code.'" readonly></div>
                    <div class="form-group"><label for="'.$row->description.'">Name</label><input type="text" name="name" class="form-control" value="'.$row->description.'" readonly></div>
                    <div class="form-group"><label for="'.$row->pack.'">Pack</label><input type="text" name="name" class="form-control" value="'.$row->description.'" readonly></div>
                    <div class="form-group"><label for="'.$row->size.'">Size</label><input type="text" name="size" class="form-control" value="'.$row->size.'" readonly></div>
                    <div class="form-group"><label for="'.$row->retail.'">Retail</label><input type="text" name="retail" class="form-control" value="'.$row->retail.'" readonly></div>
                    <div class="form-group"><label for="'.$row->quantity.'">Quantity</label><input type="text" name="quantity" class="form-control" value="'.$row->quantity.'" readonly></div>
                    <div class="form-group"><label for="'.$row->gross_margin.'">Gross Margin</label><input type="text" name="gross_margin" class="form-control" value="'.$row->gross_margin.'" readonly></div>
                    <div class="form-group"><label for="'.$row->net_case.'">Net Case</label><input type="text" name="net_case" class="form-control" value="'.$row->net_case.'" readonly></div>
                    <div class="form-group"><label for="'.$row->net_cost.'">Net Cost</label><input type="text" name="net_cost" class="form-control" value="'.$row->net_cost.'" readonly></div>
                    </form></div>
                    <div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button><button type="button" class="btn btn-primary" id="itemsave_'.$row->id.'">Save changes</button></div></div></div></div>';
                }
            }
            else {
                $output = '
                   <tr>
                    <td align="center" colspan="10">No Data Found</td>
                   </tr>
';
            }
            $data = array(
                'table_data'  => $output,
                'total_data'  => $total_row,
                'modal_data' => $modalout
            );

            return json_encode($data);
        }
    }

    /**
     * Get items by store number
     *
     *
     * @throws \Exception
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function get_by_store()
    {
        if (request()->ajax()) {
            Log::notice(Cache::store('file')->get('get_by_store'));

            if (!cache()->has('get_by_store')) {
                Log::notice('The query is not stored.. storing');
                $rtn = 'no have the key';
                cache()->put('get_by_store', Item::where('store_nbr', '=', str_pad(request('store_nbr'), 4, '0', STR_PAD_LEFT))->get(), 10);
            }

            Log::notice(cache()->get('get_by_store'));

            echo json_encode(cache()->get('get_by_store'));

        }
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
