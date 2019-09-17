<?php

namespace App\Http\Controllers;

use App\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $store_id = session()->get('store')->id;
        $delivery_date = session()->get('delivery_date');

//        $query = "select invoice_details.* from `invoices`
//                    	join invoice_details on invoice_details.invoice_id = invoices.id
//                    	where invoices.store_id = '$store_id'
//                    		and invoices.delivery_date = '$delivery_date'";

        $invoices = DB::table('invoices')
            ->join('invoice_details', 'invoice_details.invoice_id', '=', 'invoices.id')
//            ->join('invoice_totals', 'invoice_totals.invoice_id', '=', 'invoices.id')
            ->select('invoice_details.*')
            ->paginate(5);

//        $invoices = DB::select(DB::raw($query));
//dd($invoices);
        return view('invoices.index', compact('invoices'));
    }

    function search(Request $request)
    {
        $store_id = session()->get('store')->id;
        $delivery_date = session()->get('delivery_date');

        if ($request->ajax()) {
            $output = '';
            $modalout = '';
            $data = [];
            $query = $request->get('query');
            if ($query != '') {

//                $data = DB::table('invoices')
//                    ->join('invoice_details', 'invoice_details.invoice_id', '=', 'invoices.id')
//                    ->select('invoice_details.*')
//                    ->where('invoice_details.item_desc', 'LIKE', $query)
//                    ->orWhere('invoice_details.upc_code', 'LIKE', $query)
//                    ->get();
                $dbq = "select invoice_details.* from `invoices`
	join invoice_details on invoice_details.invoice_id = invoices.id 
	where (invoice_details.item_desc like '%$query%' or invoice_details.upc_code like '%$query%');
";
                $data = DB::select(DB::raw($dbq));

            } else {

//                $data = DB::table('invoices')
//                    ->join('invoice_details', 'invoice_details.invoice_id', '=', 'invoices.id')
//                    ->select('invoice_details.*')
//                    ->get();

            }
            $total_row = count($data);

            if ($total_row > 0) {

                foreach($data as $row) {

                    $output .= '
                        <tr id="item_' . $row->id . '" data-toggle="modal" data-target="#purchasemodal_' . $row->id . '">
                            <td>' . $row->upc_code . '</td>
                            <td>' . $row->item_desc . '</td>
                            <td></td>
                            <td>' . $row->pack . '</td>
                            <td>' . $row->pack . ' / ' . $row->mbr_case_cost . '</td>
                            <td>' . $row->pack . ' / ' . $row->mbr_ext_case_cost . '</td>
                            <td>' . $row->store_nbr . '</td>
                            <td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#purchasemodal_' . $row->id . '">View</button></td>
                        </tr>';

                    $modalout .= '<div class="modal fade" id="purchasemodal_' . $row->id . '" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">' .
                        '<div class="modal-dialog" role="document">' .
                        '<div class="modal-content">' .
                        '<div class="modal-header">' .
                        '<h5 class="modal-title" id="purchasemodal_' . $row->id . '">' . $row->item_desc . '</h5>' .
                        '<button type="button" class="close" data-dismiss="modal" aria-label="Close">' .
                        '<span aria-hidden="true">&times;</span>' .
                        '</button>' .
                        '</div>' .
                        '<div class="modal-body">' .
                        '<form id="form_' . $row->id . '">' .
                        '<div class="form-group">' .
                        '<label for="' . $row->item_desc . '">Name</label>' .
                        '<input type="text" name="name" class="form-control" value="' . $row->item_desc . '" readonly>' .
                        '</div>' .
                        '<div class="form-group">' .
                        '<label for="' . $row->upc_code . '">UPC Code</label>' .
                        '<input type="text" name="upc_code" class="form-control" value="' . $row->upc_code . '" readonly>' .
                        '</div>' .
                        '<div class="form-group">' .
                        '<label for="' . $row->size . '">Size</label>' .
                        '<input type="text" name="size" class="form-control" value="' . $row->size . '" readonly>' .
                        '</div>' .
                        '<div class="form-group">' .
                        '<label for="' . $row->mbr_case_cost . '">Quantity</label>' .
                        '<input type="text" name="quantity" class="form-control" value="' . $row->mbr_case_cost . '" readonly>' .
                        '</div>' .
                        '<div class="form-group">' .
                        '<label for="' . $row->mbr_case_cost . '">Case Cost</label>' .
                        '<input type="text" name="net_case" class="form-control" value="' . $row->mbr_case_cost . '" readonly>' .
                        '</div>' .
                        '<div class="form-group">' .
                        '<label for="' . $row->mbr_case_cost . '">Net Cost</label>' .
                        '<input type="text" name="net_cost" class="form-control" value="' . $row->mbr_case_cost . '" readonly>' .
                        '</div>' .
                        '</form>' .
                        '</div>' .
                        '<div class="modal-footer">' .
                        '<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>' .
                        '<button type="button" class="btn btn-primary" id="itemsave_' . $row->id . '">Save changes</button>' .
                        '</div>' .
                        '</div>' .
                        '</div>' .
                        '</div>';
                    }

            } else {

                $output = '<tr><td align="center" colspan="16">No Data Found</td></tr>';

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

    public function get()
    {
        if (request()->method() === 'POST') {
            echo(request('store_id')).'<br>';
            echo(request('delivery_date'));

            $invoice = Invoice::where('store_id', request('store,id'))->first();

            echo '<pre>';
            print_r($invoice);
            echo '</pre>';

//            $invoice = Invoice::where('store_id', request('store_id')->where('delivery_date', request('delivery_date')->first()));
//            dd($invoice);
            dd();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show(Invoice $invoice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function edit(Invoice $invoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Invoice $invoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invoice $invoice)
    {
        //
    }

    public function get_delivery_dates(Request $request)
    {
        if (request()->method() === 'POST') {
            return json_encode(Invoice::delivery_dates(request('store_id')));
        }
    }

    /**
     * Get invoices by store number
     *
     *
     */
    public function get_by_store()
    {
        if (request()->ajax()) {

            $store_id = request('store_id');
            $delivery_date = request('delivery_date');

            $query = "select invoice_details.* from `invoices`
                    	join invoice_details on invoice_details.invoice_id = invoices.id 
                    	where invoices.store_id = '$store_id' 
                    		and invoices.delivery_date = '$delivery_date'";

            $results = DB::select(DB::raw($query));

            echo json_encode($results);

        }
    }


}
