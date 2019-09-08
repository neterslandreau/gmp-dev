<?php

namespace App\Http\Controllers;

use App\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    public function search(Request $request)
    {
        if ($request->ajax()) {
            $output = '';
            $modalout = '';
            $query = $request->get('query');
        }
        if ($query != '') {
            $data = DB::table('sales')
                ->where("pos_description", "like", "%".$query."%")
                ->orWhere("upc_code", "like", "%".$query."%")
                ->orderBy("pos_description", "asc")
                ->get();

        }
        else {
            $data = DB::table('sales')
                ->orderBy('pos_description', 'asc')
                ->get();
        }
        $total_row = $data->count();
        if ($total_row > 0) {
            foreach ($data as $row) {
                $output .= '
                        <tr id="sales_'.$row->id.'" class="sales-tr"  data-toggle="modal" data-target="#salesmodal_'.$row->id.'">
                         <td name="upc_code">'.$row->upc_code.'</td>
                         <td name="pos_description">'.$row->pos_description.'</td>
                         <td name="quantity_sold">'.$row->quantity_sold.'</td>
                         <td name="amount_sold">'.$row->amount_sold.'</td>
                         <td name="weight_sold">'.$row->weight_sold.'</td>
                         <td name="unit_cost">'.$row->unit_cost.'</td>
                        </tr>
';
                $modalout .= '
                    <div class="modal fade" id="salesmodal_'.$row->id.'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document"><div class="modal-content"><div class="modal-header">
                    <h5 class="modal-title" id="modal_'.$row->id.'">'.$row->pos_description.'</h5<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button></div><div class="modal-body">
                    <form id="form_'.$row->id.'">
                    <div class="form-group"><label for="'.$row->upc_code.'">UPC Code</label><input type="text" name="upc_code" class="form-control" value="'.$row->upc_code.'" readonly></div>
                    <div class="form-group"><label for="'.$row->pos_description.'">Name</label><input type="text" name="name" class="form-control" value="'.$row->pos_description.'" readonly></div>
                    </form></div>
                    <div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button><button type="button" class="btn btn-primary" id="salessave_'.$row->id.'">Save changes</button></div></div></div></div>';
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

        echo json_encode($data);
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
     * @param  \App\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function show(Purchase $purchase)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function edit(Purchase $purchase)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Purchase $purchase)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function destroy(Purchase $purchase)
    {
        //
    }
}
