<?php

namespace App\Http\Controllers;

//use App\Models\Cart;
use App\Models\Color;
use App\Models\Customer;
use App\Models\Price;
use App\Models\TshirtImage;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function __construct()
    {
        // Apply the middlware 'can:access-cart' to all methods of the controlelr
        $this->middleware('can:access-cart');
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $cart = session('cart', []);
        return view('cart.show', compact('cart'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TshirtImage $tshirtImage, $color, $tamanho): View
    {
        $cart = session('cart', []);
        $price = Price::all()[0]->unit_price_catalog;
        $pricePersona = Price::all()[0]->unit_price_own;
        $colors = Color::all();
        $customer_id = $tshirtImage->customer_id ?? null;
        return view('cart.edit', compact('cart', 'tshirtImage', 'price', 'colors', 'customer_id', 'pricePersona', 'color', 'tamanho'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TshirtImage $tshirtImage, $color, $tamanho)
    {
        try {
            $cart = session('cart', []);
            if ($request->color !== null) {
                $newColor = $request->color;
            }
            else{
                $newColor = $color;
            }
            $oldID = $tshirtImage->id . '-' . $color . '-' . $tamanho;
            $newID = $tshirtImage->id . '-' . $newColor . '-' . $request->tamanho;

            if ($newID !== $oldID) {
                $cart[$newID] = $cart[$oldID];
                unset($cart[$oldID]);
            }

            $cart[$newID]['quantidade'] = $request->quantidade;
            $cart[$newID]['subtotal'] = $cart[$newID]['precoComDesconto'] * $request->quantidade;
            $cart[$newID]['tamanho'] = $request->tamanho;
            $cart[$newID]['color'] = $newColor;

            $request->session()->put('cart', $cart);
            $alertType = 'success';
            $url = route('tshirtImage.show', ['tshirtImage' => $tshirtImage]);
            $htmlMessage = "Carrinho alterado com sucesso";
        } catch (\Exception $error) {
            $url = route('tshirtImage.show', ['tshirtImage' => $tshirtImage]);
            $htmlMessage = "Não foi possível alterar o carrinho, porque ocorreu um erro!";
            $alertType = 'danger';
        }
        return redirect()->route('cart.show')
            ->with('alert-msg', $htmlMessage)
            ->with('alert-type', $alertType);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->session()->forget('cart');
        $htmlMessage = "Carrinho está limpo!";
        return back()
            ->with('alert-msg', $htmlMessage)
            ->with('alert-type', 'success');
    }

    public function addToCart(Request $request, TshirtImage $tshirtImage): RedirectResponse
    {
        try {
            $userType = $request->user()->tipo ?? 'G'; //se for null fica G = Guest
            if ($userType != 'G' && $userType != 'C') {
                $alertType = 'warning';
                $htmlMessage = "O utilizador não é cliente nem anónimo, logo não pode aceder ao carrinho";
            } else {
                $color = $request->color ?? 'white';
                $id = $tshirtImage->id . '-' . $color . '-' . $request->tamanho;
                $cart = session('cart', []);
                if (array_key_exists($id, $cart)) {
                    $alertType = 'warning';
                    $url = route('tshirtImage.show', ['tshirtImage' => $tshirtImage]);
                    $htmlMessage = "Tshirt não foi adicionada ao carrinho porque já está presente no mesmo";
                } else {
                    $cartItem = [
                        'tshirtImage' => $tshirtImage,
                        'tamanho' => $request->tamanho,
                        'color' => $color,
                        'quantidade' => $request->quantidade,
                        'price' => $request->price,
                        'precoComDesconto' => $request->price,
                        'subtotal' => 0,
                    ];
                    //verificacoes do preco com desconto
                    if ($cartItem['quantidade'] >= 5) {
                        if ($tshirtImage->customer_id != null) {
                            $cartItem['precoComDesconto'] = 12;
                        } else {
                            $cartItem['precoComDesconto'] = 8.5;
                        }
                    }
                    //
                    $cartItem['subtotal'] = $cartItem['precoComDesconto'] * $cartItem['quantidade'];

                    $cart[$id] = $cartItem;
                    $request->session()->put('cart', $cart);
                    $alertType = 'success';
                    $url = route('tshirtImage.show', ['tshirtImage' => $tshirtImage]);
                    $htmlMessage = "Tshirt foi adicionada ao carrinho";
                }
            }
        } catch (\Exception $error) {
            $url = route('tshirtImage.show', ['tshirtImage' => $tshirtImage]);
            $htmlMessage = "Não é possível adicionar a Tshirt <a href='$url'>#{$tshirtImage->id}</a>
                        <strong>\"{$tshirtImage->name}\"</strong> ao carrinho, porque ocorreu um erro!";
            $alertType = 'danger';
        }
        return back()
            ->with('alert-msg', $htmlMessage)
            ->with('alert-type', $alertType);
    }

    public function removeFromCart(Request $request, TshirtImage $tshirtImage, $color, $tamanho): RedirectResponse
    {
        $cart = session('cart', []);
        $color = $request->color ?? 'white';
        $id = $tshirtImage->id . '-' . $color . '-' . $tamanho;

        if (array_key_exists($id, $cart)) {
            unset($cart[$id]);
        }
        $request->session()->put('cart', $cart);
        $url = route('tshirtImage.show', ['tshirtImage' => $tshirtImage]);
        $htmlMessage = "Tshirt <a href='$url'>#{$tshirtImage->id}</a>
                        <strong>\"{$tshirtImage->name}\"</strong> foi removida do carrinho!";
        return back()
            ->with('alert-msg', $htmlMessage)
            ->with('alert-type', 'success');
    }

}
