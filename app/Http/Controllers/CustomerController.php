<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerControllerRequest;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CustomerController extends Controller
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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        return view('users.show', compact('customer'));
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        $user = User::findOrFail($customer->id);
        return view('customers.edit', compact('customer','user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CustomerControllerRequest $request, Customer $customer)
    {

        $formData = $request->validated();
        $customer = DB::transaction(function () use ($formData, $customer, $request) {
            $user = $customer->user;
            $user->name = $formData['name'];
            $user->email = $formData['email'];
            $user->save();
            $customer->nif = $formData['nif'];
            $customer->address = $formData['address'];
            $customer->save();
            if ($request->hasFile('photo_url')) {
                if ($user->url_foto) {
                    Storage::delete('public/photos/' . $user->photo_url);
                }
                $path = $request->photo_url->store('public/photos');
                $user->photo_url = basename($path);
                $user->save();
            }
            return $user;
        });
        $url = route('user.show', ['user' => $customer]);
        $htmlMessage = "Perfil alterado com sucesso!";
        return redirect()->route('user.show', ['user' => $customer])
            ->with('alert-msg', $htmlMessage)
            ->with('alert-type', 'success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        //
    }
}
