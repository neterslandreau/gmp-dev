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

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ItemsController extends Controller
{
    public function import()
    {
        app('debugbar')->disable();

        set_time_limit(1000);

        $file = Storage::disk('local')->get('ELVC0004.J');
        $rows = preg_split('/\n/', $file);
        $billedItems = [];
        $deals = [];
        $allowances = [];
        $orderExpemptions = [];
        $deliveryCharges = [];
        $invoiceTotals = [];
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
            'retail-dept' => [
                'start' => 14,
                'end' => 16,
                'length' => 3,
            ],
            'invoice-nbr' => [
                'start' => 7,
                'end' => 13,
                'length' => 7,
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
                'end' => 67,
                'length' => 1,
            ],
            'whse' => [
                'start' => 68,
                'end' => 69,
                'length' => 2,
            ],
            'item-code-ckdgt-bil' => [
                'start' => 70,
                'end' => 75,
                'length' => 6,
            ],
            'item-code-ckdgt-ord' => [
                'start' => 76,
                'end' => 81,
                'length' => 6,
            ],
            'sub-code' => [
                'start' => 82,
                'end' => 82,
                'length' => 1,
            ],
            'reject-code' => [
                'start' => 83,
                'end' => 86,
                'length' => 4,
            ],
            'item-desc' => [
                'start' => 87,
                'end' => 109,
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
                'start' => 120,
                'end' => 125,
                'length' => 6,
            ],
            'size' => [
                'start' => 126,
                'end' => 131,
                'length' => 6,
            ],
            'pack' => [
                'start' => 132,
                'end'=> 136,
                'length' => 5,
            ],
            'retail-pricing-unit' => [
                'start' => 137,
                'end' => 139,
                'length' => 3,
            ],
            'retail-price' => [
                'start' => 140,
                'end' => 146,
                'length' => 7,
            ],
            'mbr-case-cost' => [
                'start' => 154,
                'end' => 162,
                'length' => 7,
            ],
            'mbr-ext-case-cost' => [
                'start' => 154,
                'end' => 162,
                'length' => 7,
            ],
            'freight' => [
                'start' => 163,
                'end' => 167,
                'length' => 5,
            ],
            'pallet-weight' => [
                'start' => 168,
                'end' => 172,
                'length' => 5,
            ],
            'deal-seqnum' => [
                'start' => 173,
                'end' => 178,
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


        ];
//        print_r($field_lengths);
        $store_number = (int) substr($rows[0], $field_lengths['store-nbr']['start'] - 1, $field_lengths['store-nbr']['length']);
        $store = Store::where('number', $store_number)->first();
        $invoice_date = substr($rows[0], $field_lengths['delivery-date']['start'] - 1, $field_lengths['delivery-date']['length']);
        $newdate = substr($invoice_date, 0, 4).'-'.substr($invoice_date, 4, 2).'-'.substr($invoice_date, 6,2);
//        dd($newdate);
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

        foreach ($rows as $r => $row) {
            if (substr($row, $field_lengths['record-type']['start'] - 1, $field_lengths['record-type']['length']) == '01') {
                $invoiceDetail =  new InvoiceDetail([
                    'invoice_id' => $invoice->id,
                    'rec_type' => substr($row, $field_lengths['record-type']['start'] - 1, $field_lengths['record-type']['length']),
                    'store_nbr' => substr($row, $field_lengths['store-nbr']['start'] - 1, $field_lengths['store-nbr']['length']),
                    'invoice_nbr' => substr($row, $field_lengths['invoice-nbr']['start'] - 1, $field_lengths['store-nbr']['length']),
                    'retail_dept' => substr($row, $field_lengths['retail-dept']['start'] - 1, $field_lengths['retail-dept']['length']),
                    'delivery_date' => substr($row, $field_lengths['delivery-date']['start'] - 1, $field_lengths['delivery-date']['length']),
                    'case_qty_billed' => substr($row, $field_lengths['case-qty-billed']['start'] - 1, $field_lengths['case-qty-billed']['length']),
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
                    'retail_price' => substr($row, $field_lengths['retail-price']['start'] - 1, $field_lengths['retail-price']['length']),
                    'retail_pricing_unit' => substr($row, $field_lengths['retail-pricing-unit']['start'] - 1, $field_lengths['retail-pricing-unit']['length']),
                    'mbr_case_cost' => substr($row, $field_lengths['mbr-case-cost']['start'] - 1, $field_lengths['mbr-case-cost']['length']),
                    'mbr_ext_case_cost' => substr($row, $field_lengths['mbr-ext-case-cost']['start'] - 1, $field_lengths['mbr-ext-case-cost']['length']),
                    'freight' => substr($row, $field_lengths['freight']['start'] - 1, $field_lengths['freight']['length']),
                    'pallet_weight' => substr($row, $field_lengths['pallet-weight']['start'] - 1, $field_lengths['pallet-weight']['length']),
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
                    'case_qty_billed' => substr($row, $field_lengths['case-qty-billed']['start'] - 1, $field_lengths['case-qty-billed']['length']),
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
                    'retail_price' => substr($row, $field_lengths['retail-price']['start'] - 1, $field_lengths['retail-price']['length']),
                    'retail_pricing_unit' => substr($row, $field_lengths['retail-pricing-unit']['start'] - 1, $field_lengths['retail-pricing-unit']['length']),
                    'mbr_case_cost' => substr($row, $field_lengths['mbr-case-cost']['start'] - 1, $field_lengths['mbr-case-cost']['length']),
                    'mbr_ext_case_cost' => substr($row, $field_lengths['mbr-ext-case-cost']['start'] - 1, $field_lengths['mbr-ext-case-cost']['length']),
                    'freight' => substr($row, $field_lengths['freight']['start'] - 1, $field_lengths['freight']['length']),
                    'pallet_weight' => substr($row, $field_lengths['pallet-weight']['start'] - 1, $field_lengths['pallet-weight']['length']),
                    'deal_seqnum' => substr($row, $field_lengths['deal-seqnum']['start'] - 1, $field_lengths['deal-seqnum']['length']),
//                ];
                ]);
                $dealsCnt++;
                $invoiceDetailAllowance->save();

            } else if (substr($row, $field_lengths['record-type']['start'] - 1, $field_lengths['record-type']['length']) == '03') {
                $caseEligibleAlllowance = new CaseEligibleAllowance([
                    'invoice_id' => $invoice->id,
                    'rec_type' => substr($row, $field_lengths['record-type']['start'] - 1, $field_lengths['record-type']['length']),
                    'store_nbr' => substr($row, $field_lengths['store-nbr']['start'] - 1, $field_lengths['store-nbr']['length']),
                    'invoice_nbr' => substr($row, $field_lengths['invoice-nbr']['start'] - 1, $field_lengths['store-nbr']['length']),
                    'retail_dept' => substr($row, $field_lengths['retail-dept']['start'] - 1, $field_lengths['retail-dept']['length']),
                    'delivery_date' => substr($row, $field_lengths['delivery-date']['start'] - 1, $field_lengths['delivery-date']['length']),
                    'case_qty_billed' => substr($row, $field_lengths['case-qty-billed']['start'] - 1, $field_lengths['case-qty-billed']['length']),
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
                    'retail_price' => substr($row, $field_lengths['retail-price']['start'] - 1, $field_lengths['retail-price']['length']),
                    'retail_pricing_unit' => substr($row, $field_lengths['retail-pricing-unit']['start'] - 1, $field_lengths['retail-pricing-unit']['length']),
                    'mbr_case_cost' => substr($row, $field_lengths['mbr-case-cost']['start'] - 1, $field_lengths['mbr-case-cost']['length']),
                    'mbr_ext_case_cost' => substr($row, $field_lengths['mbr-ext-case-cost']['start'] - 1, $field_lengths['mbr-ext-case-cost']['length']),
                    'freight' => substr($row, $field_lengths['freight']['start'] - 1, $field_lengths['freight']['length']),
                    'pallet_weight' => substr($row, $field_lengths['pallet-weight']['start'] - 1, $field_lengths['pallet-weight']['length']),
                    'deal_seqnum' => substr($row, $field_lengths['deal-seqnum']['start'] - 1, $field_lengths['deal-seqnum']['length']),
                    'excpt_desc' => substr($row, $field_lengths['excpt-desc']['start'] - 1, $field_lengths['excpt-desc']['length']),
                ]);
                $allowancesCnt++;
                $caseEligibleAlllowance->save();
            } else if (substr($row, $field_lengths['record-type']['start'] - 1, $field_lengths['record-type']['length']) == '05') {
                $orderExemption = new OrderExemption([
                    'invoice_id' => $invoice->id,
                    'rec_type' => substr($row, $field_lengths['record-type']['start'] - 1, $field_lengths['record-type']['length']),
                    'store_nbr' => substr($row, $field_lengths['store-nbr']['start'] - 1, $field_lengths['store-nbr']['length']),
                    'invoice_nbr' => substr($row, $field_lengths['invoice-nbr']['start'] - 1, $field_lengths['store-nbr']['length']),
                    'retail_dept' => substr($row, $field_lengths['retail-dept']['start'] - 1, $field_lengths['retail-dept']['length']),
                    'delivery_date' => substr($row, $field_lengths['delivery-date']['start'] - 1, $field_lengths['delivery-date']['length']),
                    'case_qty_billed' => substr($row, $field_lengths['case-qty-billed']['start'] - 1, $field_lengths['case-qty-billed']['length']),
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
                    'retail_price' => substr($row, $field_lengths['retail-price']['start'] - 1, $field_lengths['retail-price']['length']),
                    'retail_pricing_unit' => substr($row, $field_lengths['retail-pricing-unit']['start'] - 1, $field_lengths['retail-pricing-unit']['length']),
                ]);
                $orderExemptionsCnt++;
                $orderExemption->save();
            } else if (substr($row, $field_lengths['record-type']['start'] - 1, $field_lengths['record-type']['length']) == '11') {
                $deliveryCharge = new DeliveryCharge([
                    'invoice_id' => $invoice->id,
                    'rec_type' => substr($row, $field_lengths['record-type']['start'] - 1, $field_lengths['record-type']['length']),
                    'store_nbr' => substr($row, $field_lengths['store-nbr']['start'] - 1, $field_lengths['store-nbr']['length']),
                    'invoice_nbr' => substr($row, $field_lengths['invoice-nbr']['start'] - 1, $field_lengths['store-nbr']['length']),
                    'retail_dept' => substr($row, $field_lengths['retail-dept']['start'] - 1, $field_lengths['retail-dept']['length']),
                    'delivery_date' => substr($row, $field_lengths['delivery-date']['start'] - 1, $field_lengths['delivery-date']['length']),
                    'cost_ext' => substr($row, $field_lengths['cost-ext']['start'] - 1, $field_lengths['cost-ext']['length']),
                    'deferred_bill_date' => substr($row, $field_lengths['deferred-bill-date']['start'] - 1, $field_lengths['deferred-bill-date']['length']),
                    'deferred_bill_flag' => substr($row, $field_lengths['deferred-bill-flag']['start'] - 1, $field_lengths['deferred-bill-flag']['length']),
                ]);
                $deliveryChargesCnt++;
                $deliveryCharge->save();
            } else if (substr($row, $field_lengths['record-type']['start'] - 1, $field_lengths['record-type']['length']) == '19') {
                $invoiceTotal = new InvoiceTotal([
                    'invoice_id' => $invoice->id,
                    'rec_type' => substr($row, $field_lengths['record-type']['start'] - 1, $field_lengths['record-type']['length']),
                    'store_nbr' => substr($row, $field_lengths['store-nbr']['start'] - 1, $field_lengths['store-nbr']['length']),
                    'invoice_nbr' => substr($row, $field_lengths['invoice-nbr']['start'] - 1, $field_lengths['store-nbr']['length']),
                    'retail_dept' => substr($row, $field_lengths['retail-dept']['start'] - 1, $field_lengths['retail-dept']['length']),
                    'delivery_date' => substr($row, $field_lengths['delivery-date']['start'] - 1, $field_lengths['delivery-date']['length']),
                    'case_qty_billed' => substr($row, $field_lengths['case-qty-billed']['start'] - 1, $field_lengths['case-qty-billed']['length']),
                    'cost_ext' => substr($row, $field_lengths['cost-ext']['start'] - 1, $field_lengths['cost-ext']['length']),
                    'deferred_bill_date' => substr($row, $field_lengths['deferred-bill-date']['start'] - 1, $field_lengths['deferred-bill-date']['length']),
                    'deferred_bill_flag' => substr($row, $field_lengths['deferred-bill-flag']['start'] - 1, $field_lengths['deferred-bill-flag']['length']),
                    'upc_code' => substr($row, $field_lengths['upc-code']['start'] - 1, $field_lengths['upc-code']['length']),
                    'facility' => substr($row, $field_lengths['facility']['start'] - 1, $field_lengths['facility']['length']),
                    'whse' => substr($row, $field_lengths['whse']['start'] - 1, $field_lengths['whse']['length']),
                    'deal_amount' => substr($row, $field_lengths['deal-amount']['start'] - 1, $field_lengths['deal-amount']['length']),
                    'mbr_ext_case_cost' => substr($row, $field_lengths['mbr-ext-case-cost']['start'] - 1, $field_lengths['mbr-ext-case-cost']['length']),
                    'total_fees' => substr($row, $field_lengths['total-fees']['start'] - 1, $field_lengths['total-fees']['length']),
                    'total_retail' => substr($row, $field_lengths['total-retail']['start'] - 1, $field_lengths['total-retail']['length']),
                ]);
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
//            echo substr($row, $field_lengths['record-type']['start'] - 1, $field_lengths['record-type']['length']).'<br>';


        }
        echo 'billed items: '.$billedItemsCnt.'<br>';
        echo 'deals: '.$dealsCnt.'<br>';
        echo 'allowances: '.$allowancesCnt.'<br>';
        echo 'order exemptions: '.$orderExemptionsCnt.'<br>';
        echo 'delivery charges: '.$deliveryChargesCnt.'<br>';
        echo 'invoice totals: '.$invoiceTotalsCnt.'<br>';

        echo '<pre>';
//        print_r($billedItems);
        print_r($deals);
//        print_r($allowances);
//        print_r($orderExemptions);
//        print_r($deliveryCharges);
//        print_r($invoiceTotals);
        print_r($totalCounts);
        echo '</pre>';

//        session()->flash('message', 'The items was successfully imported');
//
//        return redirect('/home');
    }

    public function download(Request $request) {

        $filename = 'LF08212019.CSV';
        $ftp_server = '3.82.218.210';
        $ftp_user_name = 'gmpftpuser';
        $ftp_user_pass = 'asdfQWER1234';

        $file = Storage::disk('ftp')->get($filename);
        Storage::disk('local')->put('file.csv', Storage::disk('ftp')->get('LF08212019.CSV'));
        dd('check it');

    }

    public function import_sales()
    {
        $file = Storage::disk('local')->get("Sales 7-1-19.CSV");
        $rows = preg_split('/\r\n/', $file);

        foreach ($rows as $r => $row) {
//            if ($r == 0) {
//                echo '<pre>';
//                print_r($row);
//                echo '</pre>';
//            }
            if($r) {
                $csv = str_getcsv($row);
//                if ($r == 6) {
//                    break;
//                }
//                echo '<pre>';
//                print_r($csv[22]);
//                echo '</pre>';
                $sales = new Sales([
                    'store_nbr' => $csv[0],
                    'upc_code' => $csv[1],
                    'quantity_sold' => $csv[2],
                    'amount_sold' => $csv[3],
                    'weight_sold' => $csv[4],
                    'sale_date' => $csv[5],
                    'department' => $csv[6],
                    'enhanced_department' => $csv[7],
                    'price_qty' => $csv[8],
                    'price' => $csv[9],
                    'coupon_type' => $csv[10],
                    'category' => $csv[11],
                    'unit_cost' => $csv[12],
                    'b_value' => $csv[13],
                    'pos_description' => $csv[14],
                    'main_link' => $csv[15],
                    'size' => $csv[16],
                    'case_cost' => $csv[17],
                    'wh_item_code' => $csv[18],
                    'vendor_item_number' => $csv[19],
                    'price_type' => $csv[20],
                    'cur_price_qty' => $csv[21],
                    'cur_base_price' => $csv[22],
                    'base_unit_cost' => $csv[23],
                    'base_case_cost' => $csv[24],
                ]);
                $sales->save();
//                echo '<pre>';
//                print_r($csv);
//                echo '</pre>';
            }
        }

        echo 'imported';

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
                    ->where("description", "like", "%".$query."%")
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
                        <tr id="item_'.$row->id.'" class="items-tr"  data-toggle="modal" data-target="#itemmodal_'.$row->id.'">
                         <td name="upc_code">'.$row->upc_code.'</td>
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
