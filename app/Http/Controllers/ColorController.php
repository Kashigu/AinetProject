<?php

namespace App\Http\Controllers;

use App\Models\Color;
use App\Http\Requests\ColorControllerRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class ColorController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:administrar');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filterByNome = $request->nome ?? '';
        $colorQuery = Color::query();

        if ($filterByNome !== '') {
            $colorQuery->where('name', 'like', "%$filterByNome%")
                ->orWhere('code', 'like', "%$filterByNome%");

        }
        $colors = $colorQuery->paginate(10);

        return view('colors.index', compact('colors', 'filterByNome'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view( 'colors.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ColorControllerRequest $request)
    {
        $formData = $request->validated();
        $color = DB::transaction(function () use ($formData, $request) {
            $newColor= new Color();
            $newColor->name = $formData['name'];
            $newColor->code = $formData['code'];
            $newColor->save();
            if ($request->hasFile('image_url')) {
                $image = $request->file('image_url');
                $imageName = $formData['code'] . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs('public/tshirt_base', $imageName);
            }

            return $newColor;
        });
        $url = route('color.index');
        $htmlMessage = "Cor criada com sucesso!";
        return redirect()->route('color.index')
            ->with('alert-msg', $htmlMessage)
            ->with('alert-type', 'success');
    }

    /**
     * Display the specified resource.
     */
    public function show(Color $color)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Color $color)
    {
        return view( 'colors.edit', compact('color'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ColorControllerRequest $request, Color $color)
    {

        if ($color->orderItems()->exists() && $color->orderItems()->whereHas('order', function ($query) {
                $query->where('status', 'paid')->orWhere('status', 'pending');
            })->exists()) {
            $htmlMessage = "Não pode alterar esta Cor por já estar a ser usada numa Encomenda ainda não terminada";
            return redirect()->route('color.index')
                ->with('alert-msg', $htmlMessage)
                ->with('alert-type', 'danger');
        }

        $formData = $request->validated();
        $color = DB::transaction(function () use ($formData, $color, $request) {
            $color->name = $formData['name'];
            $color->code = $formData['code'];
            $color->save();
            if ($request->hasFile('image_url')) {
                $image = $request->file('image_url');
                $imageName = $formData['code'] . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs('public/tshirt_base', $imageName);
            }
            return $color;
        });

        $url = route('color.index');
        $htmlMessage = "Cor foi alterada com sucesso!";
        return redirect()->route('color.index')
            ->with('alert-msg', $htmlMessage)
            ->with('alert-type', 'success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Color $color)
    {
        try {
            $color->delete();

            $htmlMessage = "Cor '{$color->name}' foi eliminada com sucesso!";
            return redirect()->route('color.index')
                ->with('alert-msg', $htmlMessage)
                ->with('alert-type', 'success');
        } catch (\Exception $error) {
            $htmlMessage = "Esta Color está relacionada com uma order logo não pode ser apagada.";
            return back()
                ->with('alert-msg', $htmlMessage)
                ->with('alert-type', 'danger');
        }
    }
}
