<?php
$quoteprice_step = "undone";
$order_step = "undone";
$contract_step = "undone";
$delivery_step = "undone";

switch ($sale_step) {
    case'0':
        $quoteprice_step = "active";
        break;
    case'1':
        $quoteprice_step = "done";
        $order_step = "active";
        break;
    case'2':
        $quoteprice_step = "done";
        $order_step = "done";
        $contract_step = "active";
        break;
    case'3':
        $quoteprice_step = "done";
        $order_step = "done";
        $contract_step = "done";
        $delivery_step = "active";
        break;
    case'4':
        $quoteprice_step = "done";
        $order_step = "done";
        $contract_step = "done";
        $delivery_step = "done";
        break;
}
?>
<input type="hidden" name="sale_step" value="{{ $sale_step }}">
<ul class="nav nav-wizard">
    <li class="{{ $quoteprice_step }}"><a name="quoteprice_step" href="#">{{ __('QP') }}</a></li>
    <li class="{{ $order_step }}"><a name="order_step" href="#">{{ __('Order') }}</a></li>
    <li class="{{ $contract_step }}"><a name="contract_step" href="#">{{ __('Contract') }}</a></li>
    <li class="{{ $delivery_step }}"><a name="delivery_step" href="#">{{ __('Delivery') }}</a></li>
</ul>