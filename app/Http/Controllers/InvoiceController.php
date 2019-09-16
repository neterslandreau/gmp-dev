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

        $query = "select invoice_details.* from `invoices`
                    	join invoice_details on invoice_details.invoice_id = invoices.id 
                    	where invoices.store_id = '$store_id' 
                    		and invoices.delivery_date = '$delivery_date'";

        $invoices = DB::table('invoices')
            ->join('invoice_details', 'invoice_details.invoice_id', '=', 'invoices.id')
            ->select('invoice_details.*')
            ->paginate(5);

//        $invoices = DB::select(DB::raw($query));
//dd($invoices);
        return view('invoices.index', compact('invoices'));
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
