<?php

namespace App\Http\Controllers;

use App\Http\Requests\PriceControllerRequest;
use App\Models\Price;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class PriceController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:administrar');
    }

    public function index()
    {
        $price = Price::all();
        return view('prices.index', compact('price'));
    }

    public function show(Price $price)
    {
        //
    }

    public function edit(Price $price)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PriceControllerRequest $request, Price $price)
    {

        $formData = $request->validated();
        $price = DB::transaction(function () use ($formData, $price, $request) {
            $price->unit_price_catalog = $formData['catalogPrice'];
            $price->unit_price_own= $formData['proprioPrice'];
            $price->unit_price_catalog_discount = $formData['discountCatalog'];
            $price->unit_price_own_discount = $formData['discountProprio'];
            $price->qty_discount = $formData['quanti'];
            $price->save();
            return $price;
        });

        $url = route('price.index');
        $htmlMessage = "Preço foi alterada com sucesso!";
        return redirect()->route('price.index')
            ->with('alert-msg', $htmlMessage)
            ->with('alert-type', 'success');
    }

}
