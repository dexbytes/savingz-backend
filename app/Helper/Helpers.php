<?php

use App\Models\Order\Order;
use App\Models\Order\OrderStatusHistory;
use App\Models\Order\Transaction;


if(!function_exists("OrderHistory")){
    function OrderHistory($id,$new_status)
    {
        $order = Transaction::find($id);
        $orderHistory =  OrderStatusHistory::create(
            [
                'user_id' => auth()->user()->id,
                'role' => auth()->user()->getRoleNames()->implode(','),
                'order_id' => $id,
                'old_status' => $order->status,
                'new_status' => $new_status,    
                'title'  => __('order/customer_message.status.:type status has been changed :old_status to :new_status',['type' => "Transaction",'old_status' => ucfirst(str_replace('_', ' ', $order->status)),'new_status' => ucfirst(str_replace('_', ' ', $new_status))]),
                ]
            );
            return $orderHistory;
        
    }

}