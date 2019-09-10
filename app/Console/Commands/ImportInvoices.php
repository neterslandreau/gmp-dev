<?php

namespace App\Console\Commands;

use App\CaseEligibleAllowance;
use App\DeliveryCharge;
use App\Invoice;
use App\InvoiceDetail;
use App\InvoiceDetailAllowance;
use App\InvoiceTotal;
use App\OrderExemption;
use App\Store;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ImportInvoices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:invoices {file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This allows for importing invoices for a specific date. This loads the .K file.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     */
    public function handle()
    {
        $path = 'Import/Invoices/';
        if (Storage::disk('local')->exists($path.$this->argument('file'))) {
            $fsize = Storage::disk('local')->size($path . $this->argument('file'));
            if ($fsize > 0) {
                $f = Storage::disk('local')->get($path . $this->argument('file'));
            } else {
                die('File is empty.'."\n");
            }
        } else {
            die('File Not Found'."\n");
        }

        $rows = preg_split('/\n/', $f);
//        $this->line(count($rows));

        $totalCounts = [];
        $field_lengths = [
            'record-type' => [
                'start' => 1,
                'end' => 2,
                'length' => 2,
            ],
            'store-nbr' => [
                'start' => 3,
                'end' => 6,
                'length' => 4,
            ],
            'invoice-nbr' => [
                'start' => 7,
                'end' => 13,
                'length' => 7,
            ],
            'retail-dept' => [
                'start' => 14,
                'end' => 16,
                'length' => 3,
            ],
            'delivery-date' => [
                'start' => 17,
                'end' => 24,
                'length' => 8,
            ],
            'case-qty-billed' => [
                'start' => 25,
                'end' => 29,
                'length' => 5,
            ],
            'cost-ext' => [
                'start' => 30,
                'end' => 42,
                'length' => 13,
            ],
            'deferred-bill-date' => [
                'start' => 43,
                'end' => 51,
                'length' => 8,
            ],
            'deferred-bill-flag' => [
                'start' => 51,
                'end' => 51,
                'length' => 1,
            ],
            'upc-code' => [
                'start' => 52,
                'end' => 66,
                'length' => 15,
            ],
            'facility' => [
                'start' => 67,
                'end' => 68,
                'length' => 2,
            ],
            'whse' => [
                'start' => 69,
                'end' => 70,
                'length' => 2,
            ],
            'item-code-ckdgt-bil' => [
                'start' => 71,
                'end' => 76,
                'length' => 6,
            ],
            'item-code-ckdgt-ord' => [
                'start' => 77,
                'end' => 82,
                'length' => 6,
            ],
            'sub-code' => [
                'start' => 82,
                'end' => 83,
                'length' => 1,
            ],
            'reject-code' => [
                'start' => 83,
                'end' => 86,
                'length' => 4,
            ],
            'item-desc' => [
                'start' => 88,
                'end' => 110,
                'length' => 23,
            ],
            'deal-number' => [
                'start' => 87,
                'end' => 93,
                'length' => 7,
            ],
            'deal-type' => [
                'start' => 94,
                'end' => 94,
                'length' => 1,
            ],
            'promotion-program' => [
                'start' => 95,
                'end' => 95,
                'length' => 1,
            ],
            'start-date' => [
                'start' => 96,
                'end' => 103,
                'length' => 8,
            ],
            'end-date' => [
                'start' => 104,
                'end' => 111,
                'length' => 8,
            ],
            'type-expense' => [
                'start' => 112,
                'end' => 112,
                'length' => 1,
            ],
            'ba-retail-ext' => [
                'start' => 110,
                'end' => 117,
                'length' => 8,
            ],
            'picking-slot' => [
                'start' => 121,
                'end' => 126,
                'length' => 6,
            ],
            'size' => [
                'start' => 127,
                'end' => 132,
                'length' => 6,
            ],
            'pack' => [
                'start' => 133,
                'end'=> 137,
                'length' => 5,
            ],
            'retail-pricing-unit' => [
                'start' => 138,
                'end' => 140,
                'length' => 3,
            ],
            'retail-price' => [
                'start' => 141,
                'end' => 147,
                'length' => 7,
            ],
            'mbr-case-cost' => [
                'start' => 158,
                'end' => 154,
                'length' => 7,
            ],
            'mbr-ext-case-cost' => [
                'start' => 155,
                'end' => 163,
                'length' => 7,
            ],
            'freight' => [
                'start' => 164,
                'end' => 168,
                'length' => 5,
            ],
            'pallet-weight' => [
                'start' => 169,
                'end' => 173,
                'length' => 5,
            ],
            'deal-seqnum' => [
                'start' => 174,
                'end' => 179,
                'length' => 6,
            ],
            'deal-amount' => [
                'start' => 113,
                'end' => 119,
                'length' => 7,
            ],
            'excpt-desc' => [
                'start' => 147,
                'end' => 176,
                'length' => 30,
            ],
            'total-fees' => [
                'start' => 163,
                'end' => 167,
                'length' => 5,
            ],
            'total-retail' => [
                'start' => 179,
                'end' => 186,
                'length' => 8,
            ],
            'record-count' => [
                'start' => 14,
                'end' => 19,
                'length' => 6,
            ],
            'date-created' => [
                'start' => 20,
                'end' => 27,
                'length' => 8,
            ],
            'time-created' => [
                'start' => 28,
                'end' => 33,
                'length' => 8,
            ],
            'order-qty' => [
                'start' => 188,
                'end' => 192,
                'length' => 5,
            ],
            'item-rfrnc-cd' => [
                'start' => 195,
                'end' => 204,
                'length' => 10,
            ],
            'rwi' => [
                'start' => 119,
                'end' => 119,
                'length' => 1,
            ],



        ];

        $store_number = (int) substr($rows[0], $field_lengths['store-nbr']['start'] - 1, $field_lengths['store-nbr']['length']);
        $store = Store::where('number', '=', $store_number)->first();
        $invoice_date = substr($rows[0], $field_lengths['delivery-date']['start'] - 1, $field_lengths['delivery-date']['length']);
        $newdate = substr($invoice_date, 0, 4).'-'.substr($invoice_date, 4, 2).'-'.substr($invoice_date, 6,2);

        $invoice = new Invoice([
            'store_id' => $store->id,
            'delivery_date' => $newdate,

        ]);
        $invoice->save();

        $billedItemsCnt = 0;
        $dealsCnt = 0;
        $allowancesCnt = 0;
        $orderExemptionsCnt = 0;
        $deliveryChargesCnt = 0;
        $invoiceTotalsCnt = 0;

        $bar = $this->output->createProgressBar(count($rows));
        foreach ($rows as $r => $row) {
            if (substr($row, $field_lengths['record-type']['start'] - 1, $field_lengths['record-type']['length']) == '01') {
                $invoiceDetail =  new InvoiceDetail([
                    'invoice_id' => $invoice->id,
                    'rec_type' => substr($row, $field_lengths['record-type']['start'] - 1, $field_lengths['record-type']['length']),
                    'store_nbr' => substr($row, $field_lengths['store-nbr']['start'] - 1, $field_lengths['store-nbr']['length']),
                    'invoice_nbr' => substr($row, $field_lengths['invoice-nbr']['start'] - 1, $field_lengths['store-nbr']['length']),
                    'retail_dept' => substr($row, $field_lengths['retail-dept']['start'] - 1, $field_lengths['retail-dept']['length']),
                    'delivery_date' => substr($row, $field_lengths['delivery-date']['start'] - 1, $field_lengths['delivery-date']['length']),
                    'case_qty_billed' => strtodecimal(substr($row, $field_lengths['case-qty-billed']['start'] - 1, $field_lengths['case-qty-billed']['length'])),
                    'cost_ext' => strtodecimal(substr($row, $field_lengths['cost-ext']['start'] - 1, $field_lengths['cost-ext']['length'])),
                    'deferred_bill_date' => substr($row, $field_lengths['deferred-bill-date']['start'] - 1, $field_lengths['deferred-bill-date']['length']),
                    'deferred_bill_flag' => substr($row, $field_lengths['deferred-bill-flag']['start'] - 1, $field_lengths['deferred-bill-flag']['length']),
                    'upc_code' => substr($row, $field_lengths['upc-code']['start'] - 1, $field_lengths['upc-code']['length']),
                    'facility' => substr($row, $field_lengths['facility']['start'] - 1, $field_lengths['facility']['length']),
                    'whse' => substr($row, $field_lengths['whse']['start'] - 1, $field_lengths['whse']['length']),
                    'item_code_ckdgt_bil' => substr($row, $field_lengths['item-code-ckdgt-bil']['start'] - 1, $field_lengths['item-code-ckdgt-bil']['length']),
                    'item_code_ckdgt_ord' => substr($row, $field_lengths['item-code-ckdgt-ord']['start'] - 1, $field_lengths['item-code-ckdgt-ord']['length']),
                    'sub_code' => substr($row, $field_lengths['sub-code']['start'] - 1, $field_lengths['sub-code']['length']),
                    'item_desc' => substr($row, $field_lengths['item-desc']['start'] - 1, $field_lengths['item-desc']['length']),
                    'ba_retail_ext' => substr($row, $field_lengths['ba-retail-ext']['start'] - 1, $field_lengths['ba-retail-ext']['length']),
                    'rwi' => substr($row, $field_lengths['rwi']['start'] - 1, $field_lengths['rwi']['length']),
                    'picking_slot' => substr($row, $field_lengths['picking-slot']['start'] - 1, $field_lengths['picking-slot']['length']),
                    'size' => substr($row, $field_lengths['size']['start'] - 1, $field_lengths['size']['length']),
                    'pack' => substr($row, $field_lengths['pack']['start'] - 1, $field_lengths['pack']['length']),
                    'retail_price' => strtodecimal(substr($row, $field_lengths['retail-price']['start'] - 1, $field_lengths['retail-price']['length'])),
                    'retail_pricing_unit' => strtodecimal(substr($row, $field_lengths['retail-pricing-unit']['start'] - 1, $field_lengths['retail-pricing-unit']['length'])),
                    'mbr_case_cost' => substr($row, $field_lengths['mbr-case-cost']['start'] - 1, $field_lengths['mbr-case-cost']['length']),
                    'mbr_ext_case_cost' => substr($row, $field_lengths['mbr-ext-case-cost']['start'] - 1, $field_lengths['mbr-ext-case-cost']['length']),
                    'freight' => substr($row, $field_lengths['freight']['start'] - 1, $field_lengths['freight']['length']),
                    'pallet_weight' => substr($row, $field_lengths['pallet-weight']['start'] - 1, $field_lengths['pallet-weight']['length']),
                    'order_qty' => substr($row, $field_lengths['order-qty']['start'] - 1, $field_lengths['order-qty']['length']),
                    'item_rfnc_cd' => substr($row, $field_lengths['item-rfrnc-cd']['start'] - 1, $field_lengths['item-rfrnc-cd']['length']),
                ]);
                $billedItemsCnt++;
//                var_dump($billedItem);
                $invoiceDetail->save();
            } else if (substr($row, $field_lengths['record-type']['start'] - 1, $field_lengths['record-type']['length']) == '02') {
                $invoiceDetailAllowance = new InvoiceDetailAllowance([
//                $deals[] = [
                    'invoice_id' => $invoice->id,
                    'rec_type' => substr($row, $field_lengths['record-type']['start'] - 1, $field_lengths['record-type']['length']),
                    'store_nbr' => substr($row, $field_lengths['store-nbr']['start'] - 1, $field_lengths['store-nbr']['length']),
                    'invoice_nbr' => substr($row, $field_lengths['invoice-nbr']['start'] - 1, $field_lengths['store-nbr']['length']),
                    'retail_dept' => substr($row, $field_lengths['retail-dept']['start'] - 1, $field_lengths['retail-dept']['length']),
                    'delivery_date' => substr($row, $field_lengths['delivery-date']['start'] - 1, $field_lengths['delivery-date']['length']),
                    'case_qty_billed' => strtodecimal(substr($row, $field_lengths['case-qty-billed']['start'] - 1, $field_lengths['case-qty-billed']['length'])),
                    'cost_ext' => substr($row, $field_lengths['cost-ext']['start'] - 1, $field_lengths['cost-ext']['length']),
                    'deferred_bill_date' => substr($row, $field_lengths['deferred-bill-date']['start'] - 1, $field_lengths['deferred-bill-date']['length']),
                    'deferred_bill_flag' => substr($row, $field_lengths['deferred-bill-flag']['start'] - 1, $field_lengths['deferred-bill-flag']['length']),
                    'upc_code' => substr($row, $field_lengths['upc-code']['start'] - 1, $field_lengths['upc-code']['length']),
                    'facility' => substr($row, $field_lengths['facility']['start'] - 1, $field_lengths['facility']['length']),
                    'whse' => substr($row, $field_lengths['whse']['start'] - 1, $field_lengths['whse']['length']),
                    'item_code_ckdgt_bil' => substr($row, $field_lengths['item-code-ckdgt-bil']['start'] - 1, $field_lengths['item-code-ckdgt-bil']['length']),
                    'item_code_ckdgt_ord' => substr($row, $field_lengths['item-code-ckdgt-ord']['start'] - 1, $field_lengths['item-code-ckdgt-ord']['length']),
                    'sub_code' => substr($row, $field_lengths['sub-code']['start'] - 1, $field_lengths['sub-code']['length']),
                    'reject_code' => substr($row, $field_lengths['reject-code']['start'] - 1, $field_lengths['reject-code']['length']),
                    'deal_number' => substr($row, $field_lengths['deal-number']['start'] - 1, $field_lengths['deal-number']['length']),
                    'deal_type' => substr($row, $field_lengths['deal-type']['start'] - 1, $field_lengths['deal-type']['length']),
                    'promotion_program' => substr($row, $field_lengths['promotion-program']['start'] - 1, $field_lengths['promotion-program']['length']),
                    'start_date' => substr($row, $field_lengths['start-date']['start'] - 1, $field_lengths['start-date']['length']),
                    'end_date' => substr($row, $field_lengths['end-date']['start'] - 1, $field_lengths['end-date']['length']),
                    'type_expense' => substr($row, $field_lengths['type-expense']['start'] - 1, $field_lengths['type-expense']['length']),
                    'deal_amount' => substr($row, $field_lengths['deal-amount']['start'] - 1, $field_lengths['deal-amount']['length']),
                    'picking_slot' => substr($row, $field_lengths['picking-slot']['start'] - 1, $field_lengths['picking-slot']['length']),
                    'size' => substr($row, $field_lengths['size']['start'] - 1, $field_lengths['size']['length']),
                    'pack' => substr($row, $field_lengths['pack']['start'] - 1, $field_lengths['pack']['length']),
                    'retail_price' => strtodecimal(substr($row, $field_lengths['retail-price']['start'] - 1, $field_lengths['retail-price']['length'])),
                    'retail_pricing_unit' => strtodecimal(substr($row, $field_lengths['retail-pricing-unit']['start'] - 1, $field_lengths['retail-pricing-unit']['length'])),
                    'mbr_case_cost' => strtodecimal(substr($row, $field_lengths['mbr-case-cost']['start'] - 1, $field_lengths['mbr-case-cost']['length'])),
                    'mbr_ext_case_cost' => strtodecimal(substr($row, $field_lengths['mbr-ext-case-cost']['start'] - 1, $field_lengths['mbr-ext-case-cost']['length'])),
                    'freight' => strtodecimal(substr($row, $field_lengths['freight']['start'] - 1, $field_lengths['freight']['length'])),
                    'pallet_weight' => strtodecimal(substr($row, $field_lengths['pallet-weight']['start'] - 1, $field_lengths['pallet-weight']['length'])),
                    'deal_seqnum' => strtodecimal(substr($row, $field_lengths['deal-seqnum']['start'] - 1, $field_lengths['deal-seqnum']['length'])),
//                ];
                ]);
                $dealsCnt++;
                $invoiceDetailAllowance->save();

            } else if (substr($row, $field_lengths['record-type']['start'] - 1, $field_lengths['record-type']['length']) == '03') {
                $caseEligibleAlllowance = new CaseEligibleAllowance([
//                $allowances[] = [
                    'invoice_id' => $invoice->id,
                    'rec_type' => substr($row, $field_lengths['record-type']['start'] - 1, $field_lengths['record-type']['length']),
                    'store_nbr' => substr($row, $field_lengths['store-nbr']['start'] - 1, $field_lengths['store-nbr']['length']),
                    'invoice_nbr' => substr($row, $field_lengths['invoice-nbr']['start'] - 1, $field_lengths['store-nbr']['length']),
                    'retail_dept' => substr($row, $field_lengths['retail-dept']['start'] - 1, $field_lengths['retail-dept']['length']),
                    'delivery_date' => substr($row, $field_lengths['delivery-date']['start'] - 1, $field_lengths['delivery-date']['length']),
                    'case_qty_billed' => strtodecimal(substr($row, $field_lengths['case-qty-billed']['start'] - 1, $field_lengths['case-qty-billed']['length'])),
                    'cost_ext' => substr($row, $field_lengths['cost-ext']['start'] - 1, $field_lengths['cost-ext']['length']),
                    'deferred_bill_date' => substr($row, $field_lengths['deferred-bill-date']['start'] - 1, $field_lengths['deferred-bill-date']['length']),
                    'deferred_bill_flag' => substr($row, $field_lengths['deferred-bill-flag']['start'] - 1, $field_lengths['deferred-bill-flag']['length']),
                    'upc_code' => substr($row, $field_lengths['upc-code']['start'] - 1, $field_lengths['upc-code']['length']),
                    'facility' => substr($row, $field_lengths['facility']['start'] - 1, $field_lengths['facility']['length']),
                    'whse' => substr($row, $field_lengths['whse']['start'] - 1, $field_lengths['whse']['length']),
                    'item_code_ckdgt_bil' => substr($row, $field_lengths['item-code-ckdgt-bil']['start'] - 1, $field_lengths['item-code-ckdgt-bil']['length']),
                    'item_code_ckdgt_ord' => substr($row, $field_lengths['item-code-ckdgt-ord']['start'] - 1, $field_lengths['item-code-ckdgt-ord']['length']),
                    'sub_code' => substr($row, $field_lengths['sub-code']['start'] - 1, $field_lengths['sub-code']['length']),
                    'reject_code' => substr($row, $field_lengths['reject-code']['start'] - 1, $field_lengths['reject-code']['length']),
                    'item_desc' => substr($row, $field_lengths['item-desc']['start'] - 1, $field_lengths['item-desc']['length']),
                    'ba_retail_ext' => substr($row, $field_lengths['ba-retail-ext']['start'] - 1, $field_lengths['ba-retail-ext']['length']),
                    'picking_slot' => substr($row, $field_lengths['picking-slot']['start'] - 1, $field_lengths['picking-slot']['length']),
                    'size' => substr($row, $field_lengths['size']['start'] - 1, $field_lengths['size']['length']),
                    'pack' => substr($row, $field_lengths['pack']['start'] - 1, $field_lengths['pack']['length']),
                    'retail_price' => strtodecimal(substr($row, $field_lengths['retail-price']['start'] - 1, $field_lengths['retail-price']['length'])),
                    'retail_pricing_unit' => strtodecimal(substr($row, $field_lengths['retail-pricing-unit']['start'] - 1, $field_lengths['retail-pricing-unit']['length'])),
                    'mbr_case_cost' => strtodecimal(substr($row, $field_lengths['mbr-case-cost']['start'] - 1, $field_lengths['mbr-case-cost']['length'])),
                    'mbr_ext_case_cost' => strtodecimal(substr($row, $field_lengths['mbr-ext-case-cost']['start'] - 1, $field_lengths['mbr-ext-case-cost']['length'])),
                    'freight' => substr($row, $field_lengths['freight']['start'] - 1, $field_lengths['freight']['length']),
                    'pallet_weight' => strtodecimal(substr($row, $field_lengths['pallet-weight']['start'] - 1, $field_lengths['pallet-weight']['length'])),
                    'deal_seqnum' => substr($row, $field_lengths['deal-seqnum']['start'] - 1, $field_lengths['deal-seqnum']['length']),
                    'excpt_desc' => substr($row, $field_lengths['excpt-desc']['start'] - 1, $field_lengths['excpt-desc']['length']),
                ]);
//                ];
                $allowancesCnt++;
                $caseEligibleAlllowance->save();
            } else if (substr($row, $field_lengths['record-type']['start'] - 1, $field_lengths['record-type']['length']) == '05') {
                $orderExemption = new OrderExemption([
//                $orderExemptions[] = [
                    'invoice_id' => $invoice->id,
                    'rec_type' => substr($row, $field_lengths['record-type']['start'] - 1, $field_lengths['record-type']['length']),
                    'store_nbr' => substr($row, $field_lengths['store-nbr']['start'] - 1, $field_lengths['store-nbr']['length']),
                    'invoice_nbr' => substr($row, $field_lengths['invoice-nbr']['start'] - 1, $field_lengths['store-nbr']['length']),
                    'retail_dept' => substr($row, $field_lengths['retail-dept']['start'] - 1, $field_lengths['retail-dept']['length']),
                    'delivery_date' => substr($row, $field_lengths['delivery-date']['start'] - 1, $field_lengths['delivery-date']['length']),
                    'case_qty_billed' => strtodecimal(substr($row, $field_lengths['case-qty-billed']['start'] - 1, $field_lengths['case-qty-billed']['length'])),
                    'cost_ext' => strtodecimal(substr($row, $field_lengths['cost-ext']['start'] - 1, $field_lengths['cost-ext']['length'])),
                    'deferred_bill_date' => substr($row, $field_lengths['deferred-bill-date']['start'] - 1, $field_lengths['deferred-bill-date']['length']),
                    'deferred_bill_flag' => substr($row, $field_lengths['deferred-bill-flag']['start'] - 1, $field_lengths['deferred-bill-flag']['length']),
                    'upc_code' => substr($row, $field_lengths['upc-code']['start'] - 1, $field_lengths['upc-code']['length']),
                    'facility' => substr($row, $field_lengths['facility']['start'] - 1, $field_lengths['facility']['length']),
                    'whse' => substr($row, $field_lengths['whse']['start'] - 1, $field_lengths['whse']['length']),
                    'item_code_ckdgt_bil' => substr($row, $field_lengths['item-code-ckdgt-bil']['start'] - 1, $field_lengths['item-code-ckdgt-bil']['length']),
                    'item_code_ckdgt_ord' => substr($row, $field_lengths['item-code-ckdgt-ord']['start'] - 1, $field_lengths['item-code-ckdgt-ord']['length']),
                    'sub_code' => substr($row, $field_lengths['sub-code']['start'] - 1, $field_lengths['sub-code']['length']),
                    'reject_code' => substr($row, $field_lengths['reject-code']['start'] - 1, $field_lengths['reject-code']['length']),
                    'item_desc' => substr($row, $field_lengths['item-desc']['start'] - 1, $field_lengths['item-desc']['length']),
                    'ba_retail_ext' => substr($row, $field_lengths['ba-retail-ext']['start'] - 1, $field_lengths['ba-retail-ext']['length']),
                    'picking_slot' => substr($row, $field_lengths['picking-slot']['start'] - 1, $field_lengths['picking-slot']['length']),
                    'size' => substr($row, $field_lengths['size']['start'] - 1, $field_lengths['size']['length']),
                    'pack' => substr($row, $field_lengths['pack']['start'] - 1, $field_lengths['pack']['length']),
                    'retail_price' => strtodecimal(substr($row, $field_lengths['retail-price']['start'] - 1, $field_lengths['retail-price']['length'])),
                    'retail_pricing_unit' => strtodecimal(substr($row, $field_lengths['retail-pricing-unit']['start'] - 1, $field_lengths['retail-pricing-unit']['length'])),
//                ];
                ]);
                $orderExemptionsCnt++;
                $orderExemption->save();
            } else if (substr($row, $field_lengths['record-type']['start'] - 1, $field_lengths['record-type']['length']) == '11') {
                $deliveryCharge = new DeliveryCharge([
//                $deliveryCharges[] = [
                    'invoice_id' => $invoice->id,
                    'rec_type' => substr($row, $field_lengths['record-type']['start'] - 1, $field_lengths['record-type']['length']),
                    'store_nbr' => substr($row, $field_lengths['store-nbr']['start'] - 1, $field_lengths['store-nbr']['length']),
                    'invoice_nbr' => substr($row, $field_lengths['invoice-nbr']['start'] - 1, $field_lengths['store-nbr']['length']),
                    'retail_dept' => substr($row, $field_lengths['retail-dept']['start'] - 1, $field_lengths['retail-dept']['length']),
                    'delivery_date' => substr($row, $field_lengths['delivery-date']['start'] - 1, $field_lengths['delivery-date']['length']),
                    'cost_ext' => strtodecimal(substr($row, $field_lengths['cost-ext']['start'] - 1, $field_lengths['cost-ext']['length'])),
                    'deferred_bill_date' => substr($row, $field_lengths['deferred-bill-date']['start'] - 1, $field_lengths['deferred-bill-date']['length']),
                    'deferred_bill_flag' => substr($row, $field_lengths['deferred-bill-flag']['start'] - 1, $field_lengths['deferred-bill-flag']['length']),
                ]);
//                ];
                $deliveryChargesCnt++;
                $deliveryCharge->save();
            } else if (substr($row, $field_lengths['record-type']['start'] - 1, $field_lengths['record-type']['length']) == '19') {
                $invoiceTotal = new InvoiceTotal([
//                $invoiceTotals[] = [
                    'invoice_id' => $invoice->id,
                    'rec_type' => substr($row, $field_lengths['record-type']['start'] - 1, $field_lengths['record-type']['length']),
                    'store_nbr' => substr($row, $field_lengths['store-nbr']['start'] - 1, $field_lengths['store-nbr']['length']),
                    'invoice_nbr' => substr($row, $field_lengths['invoice-nbr']['start'] - 1, $field_lengths['store-nbr']['length']),
                    'retail_dept' => substr($row, $field_lengths['retail-dept']['start'] - 1, $field_lengths['retail-dept']['length']),
                    'delivery_date' => substr($row, $field_lengths['delivery-date']['start'] - 1, $field_lengths['delivery-date']['length']),
                    'case_qty_billed' => strtodecimal(substr($row, $field_lengths['case-qty-billed']['start'] - 1, $field_lengths['case-qty-billed']['length'])),
                    'cost_ext' => strtodecimal(substr($row, $field_lengths['cost-ext']['start'] - 1, $field_lengths['cost-ext']['length'])),
                    'deferred_bill_date' => substr($row, $field_lengths['deferred-bill-date']['start'] - 1, $field_lengths['deferred-bill-date']['length']),
                    'deferred_bill_flag' => substr($row, $field_lengths['deferred-bill-flag']['start'] - 1, $field_lengths['deferred-bill-flag']['length']),
                    'upc_code' => substr($row, $field_lengths['upc-code']['start'] - 1, $field_lengths['upc-code']['length']),
                    'facility' => substr($row, $field_lengths['facility']['start'] - 1, $field_lengths['facility']['length']),
                    'whse' => substr($row, $field_lengths['whse']['start'] - 1, $field_lengths['whse']['length']),
                    'deal_amount' => substr($row, $field_lengths['deal-amount']['start'] - 1, $field_lengths['deal-amount']['length']),
                    'mbr_ext_case_cost' => substr($row, $field_lengths['mbr-ext-case-cost']['start'] - 1, $field_lengths['mbr-ext-case-cost']['length']),
                    'total_fees' => strtodecimal(substr($row, $field_lengths['total-fees']['start'] - 1, $field_lengths['total-fees']['length'])),
                    'total_retail' => strtodecimal(substr($row, $field_lengths['total-retail']['start'] - 1, $field_lengths['total-retail']['length'])),
                ]);
//                ];
                $invoiceTotalsCnt++;
                $invoiceTotal->save();
            } else if (substr($row, $field_lengths['record-type']['start'] - 1, $field_lengths['record-type']['length']) == '99') {
                $totalCounts[] = [
                    'invoice_id' => $invoice->id,
                    'rec-type' => substr($row, $field_lengths['record-type']['start'] - 1, $field_lengths['record-type']['length']),
                    'store-nbr' => substr($row, $field_lengths['store-nbr']['start'] - 1, $field_lengths['store-nbr']['length']),
                    'invoice-nbr' => substr($row, $field_lengths['invoice-nbr']['start'] - 1, $field_lengths['store-nbr']['length']),
                    'record-count' => substr($row, $field_lengths['record-count']['start'] - 1, $field_lengths['record-count']['length']),
                    'date-created' => substr($row, $field_lengths['date-created']['start'] - 1, $field_lengths['date-created']['length']),
                    'time-created' => substr($row, $field_lengths['time-created']['start'] - 1, $field_lengths['time-created']['length']),
                ];

            }
            $bar->advance();
        }
        $bar->finish();
        Storage::disk('local')->delete($path . $this->argument('file'));

        $this->line("\n");

    }
}
