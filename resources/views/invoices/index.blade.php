<?php
    foreach($invoices as $i => $invoice) {
        echo '<pre>';
        print_r($invoice->deliveryCharge->cost_ext);
//        print_r($invoice->deliveryCharge->store_nbr);
        echo '</pre>';
        echo '<pre>';
//        print_r($invoice->deliveryCharge->cost_ext);
        print_r($invoice->deliveryCharge->store_nbr);
        echo '</pre>';
    }
