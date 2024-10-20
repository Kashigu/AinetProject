<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use App\Models\Color;
use Illuminate\Http\Request;

class OrderItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
       
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store($id, $cartData)
    {
        foreach ($cartData as $cartDataItem) 
        {
            $newOrderItem = new OrderItem;

            $newOrderItem->order_id = $id;
            $newOrderItem->tshirt_image_id = $cartDataItem['tshirtImage']['id'];
            $newOrderItem->size = $cartDataItem['tamanho'];
            
            $colorsQuery = Color::query();
            $colorID = $colorsQuery->where('name', $cartDataItem['color'])
                                   ->value('code');
            $newOrderItem->color_code = $colorID;

            $newOrderItem->qty = $cartDataItem['quantidade'];
            $newOrderItem->unit_price = $cartDataItem['precoComDesconto'];
            $newOrderItem->sub_total = $cartDataItem['subtotal'];

            $newOrderItem->save();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $orderItems = OrderItem::where('order_id', $id)->get();

        foreach ($orderItems as $orderItem) 
        {
            $colorID = Color::query()->where('code', $orderItem->color_code)
                                     ->value('name');
            $orderItem->color_code = $colorID;
        }

        return $orderItems;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OrderItem $orderItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OrderItem $orderItem)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OrderItem $orderItem)
    {
        //
    }
}
