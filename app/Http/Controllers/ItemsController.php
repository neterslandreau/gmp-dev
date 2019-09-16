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
                    ->where("pos_description", "like", "%".$query."%")
                    ->orWhere("upc_code", "like", "%".$query."%")
//                    ->orWhere("size", "like", "%".$query."%")
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
                <tr id="item_'.$row->id.'" class="sales-tr" data-toggle="modal" data-target="#itemmodal_'. $row->id .'">
                    <td>'. $row->store_nbr .'</td>
                    <td>'. $row->upc_code .'</td>
                    <td>'. $row->pos_description .'</td>
                    <td>'. $row->qty_sold .'</td>
                    <td>'. $row->amt_sold .'</td>
                    <td>'. $row->weight_sold .'</td>
                    <td></td>
                    <td>'. $row->price_qty .'</td>
                    <td>'. $row->price .'</td>
                    <td>'. $row->unit_cost .'</td>
                    <td>'. $row->size .'</td>
                    <td>'. $row->case_cost .'</td>
                    <td>'. $row->cur_price_qty .'</td>
                    <td>'. $row->cur_price .'</td>
                    <td>'. $row->base_unit_cost .'</td>
                    <td>'. $row->base_case_cost .'</td>
                </tr>
';
//                    $modalout = '';
                    $modalout .= '
                    <div class="modal fade" id="itemmodal_'.$row->id.'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document"><div class="modal-content"><div class="modal-header">
                    <h5 class="modal-title" id="modal_'.$row->id.'">'.$row->pos_description.'</h5<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button></div><div class="modal-body">
                    <form id="form_'.$row->id.'">
                    <div class="form-group"><label for="'.$row->upc_code.'">UPC Code</label><input type="text" name="upc_code" class="form-control" value="'.$row->upc_code.'" readonly></div>
                    <div class="form-group"><label for="'.$row->pos_description.'">Pos Description</label><input type="text" name="pos_description" class="form-control" value="'.$row->pos_description.'" readonly></div>
                    <div class="form-group"><label for="'.$row->qty_sold.'">Qty Sold</label><input type="text" name="qty_sold" class="form-control" value="'.$row->qty_sold.'" readonly></div>
                    <div class="form-group"><label for="'.$row->amt_sold.'">Amt Sold</label><input type="text" name="amt_sold" class="form-control" value="'.$row->amt_sold.'" readonly></div>
                    <div class="form-group"><label for="'.$row->cur_price.'">Cur Price</label><input type="text" name="cur_price" class="form-control" value="'.$row->cur_price.'" readonly></div>
                    <div class="form-group"><label for="'.$row->price_qty.'">Price Qty</label><input type="text" name="price_qty" class="form-control" value="'.$row->price_qty.'" readonly></div>
                    <div class="form-group"><label for="'.$row->unit_cost.'">Unit Cost</label><input type="text" name="unit_cost" class="form-control" value="'.$row->unit_cost.'" readonly></div>
                    <div class="form-group"><label for="'.$row->base_unit_cost.'">Base Unit Cost</label><input type="text" name="bas_unit_cost" class="form-control" value="'.$row->base_unit_cost.'" readonly></div>
                    <div class="form-group"><label for="'.$row->base_case_cost.'">Base Case Cost</label><input type="text" name="base_case_cost" class="form-control" value="'.$row->base_case_cost.'" readonly></div>
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

            echo json_encode(Item::where('store_nbr', '=', str_pad(request('store_nbr'), 4, '0', STR_PAD_LEFT))->paginate(10));

        }
    }

    public function index()
    {
//        dd(session('store')->number);
        $items = Item::where('store_nbr', '=', str_pad(session('store')->number, 4, '0', STR_PAD_LEFT))->paginate(10);
//        dd($items);
        return view('items.index', compact($items));
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

    public function analytics()
    {
        echo session()->get('store')->number;
        return view('items.analytics');
    }

}
