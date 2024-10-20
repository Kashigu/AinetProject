<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryControllerRequest;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CategoryController extends Controller
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
        $categorias = Category::all();
        $filterByNome = $request->nome ?? '';
        $CategoryQuery = Category::query();

        if ($filterByNome !== '') {
            $CategoryId = Category::where('name', 'like', "%$filterByNome%")->pluck('id');
            $CategoryQuery->whereIntegerInRaw('id', $CategoryId);
        }
        $categories = $CategoryQuery->paginate(10);


        return view('categories.index', compact('categories', 'filterByNome'));
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
    public function store(CategoryControllerRequest $request)
    {

        $formData = $request->validated();
        $category = DB::transaction(function () use ($formData, $request) {
            $newCategory = new Category();
            $newCategory->name = $formData['name'];
            $newCategory->save();
            return $newCategory;
        });
        $url = route('category.index');
        $htmlMessage = "Categoria criada com sucesso!";
        return redirect()->route('category.index')
            ->with('alert-msg', $htmlMessage)
            ->with('alert-type', 'success');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryControllerRequest $request, Category $category)
    {
        $formData = $request->validated();
        $category->name = $formData['name'];
        $category->save();

        $url = route('category.index');
        $htmlMessage = "Categoria foi alterada com sucesso!";
        return redirect()->route('category.index')
            ->with('alert-msg', $htmlMessage)
            ->with('alert-type', 'success');

    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        try {
            $category->delete();

            $htmlMessage = "Categoria'{$category->name}' foi eliminado com sucesso!";
            return redirect()->route('category.index')
                ->with('alert-msg', $htmlMessage)
                ->with('alert-type', 'success');
        } catch (\Exception $error) {
            $htmlMessage = "Esta Categoria está relacionada com uma tshirt logo não pode ser apagada.";
            return back()
                ->with('alert-msg', $htmlMessage)
                ->with('alert-type', 'danger');
        }
    }
}
