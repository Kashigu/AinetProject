<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\TshirtImage;
use http\Client\Curl\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\TshirtImageRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use App\Models\Price;
use App\Models\Color;
use App\Models\Customer;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

use function PHPUnit\Framework\throwException;

class TshirtImageController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(TshirtImage::class, 'tshirtImage');
    }

    private function tshirts(Request $request)
    {
        $categories = Category::all();
        $filterByCategoria = $request->id ?? '';
        $filterByNome = $request->nome ?? '';
        $tshirtImagesQuery = TshirtImage::query();

        if ($filterByCategoria !== '') {
            $tshirtImagesQuery->where('category_id', $filterByCategoria);
        }
        if ($filterByCategoria === '') {
            $filterByCategoria = null;
        }
        if ($filterByNome !== '') {
            $tshirtImagesId = TshirtImage::where('name', 'like', "%$filterByNome%")->pluck('id');
            $tshirtImagesQuery->whereIntegerInRaw('id', $tshirtImagesId);
        }
        $tshirtImages = $tshirtImagesQuery->with('category')->whereNull('customer_id')->paginate(9);

        $price = Price::all()[0]->unit_price_catalog;

        return compact('tshirtImages', 'price', 'filterByCategoria', 'categories', 'filterByNome');
    }

    public function index(Request $request)
    {
        $data = $this->tshirts($request);

        $tshirtImages = $data['tshirtImages'];
        $price = $data['price'];
        $filterByCategoria = $data['filterByCategoria'];
        $categories = $data['categories'];
        $filterByNome = $data['filterByNome'];

        return view('tshirt.index', compact('tshirtImages', 'price', 'filterByCategoria', 'categories', 'filterByNome'));
    }

    public function indexAdmin(Request $request)
    {
        if (Gate::denies('administrar')) {
            abort(403, 'Unauthorized');
        }

        $data = $this->tshirts($request);

        $tshirtImages = $data['tshirtImages'];
        $price = $data['price'];
        $filterByCategoria = $data['filterByCategoria'];
        $categories = $data['categories'];
        $filterByNome = $data['filterByNome'];

        return view('tshirt.indexAdmin', compact('tshirtImages', 'price', 'filterByCategoria', 'categories', 'filterByNome'));
    }

    public function show(TshirtImage $tshirtImage)
    {
        $price = Price::all()[0]->unit_price_catalog;
        $pricePersona = Price::all()[0]->unit_price_own;
        $color = Color::all();
        $customer_id = $tshirtImage->customer_id ?? null;
        return view('tshirt.show', compact('tshirtImage', 'price', 'color', 'customer_id', 'pricePersona'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $idUser = auth()->user()->id;

        return view('tshirt.create', compact('idUser'));
    }

    public function createAdmin()
    {
        $this->authorize('createAdmin', TshirtImage::class);
        $categorias = Category::all();
        return view('tshirt.createAdmin', compact('categorias'));
    }


    public function storeAdmin(TshirtImageRequest $request)
    {
        $this->authorize('createAdmin', TshirtImage::class);
        $formData = $request->validated();
        $imagem = DB::transaction(function () use ($formData, $request) {
            $newImage = new TshirtImage();
            $newImage->name = $formData['name'];
            $newImage->description = $formData['description'];
            $newImage->category_id = $formData['idCategory'];
            if ($request->hasFile('image_url')) {
                $path = $request->image_url->store('public/tshirt_images/');
                $newImage->image_url = basename($path);
                $newImage->save();
            }
            return $newImage;
        });
        $url = route('tshirt.indexAdmin');
        $htmlMessage = "Imagem foi criada com sucesso!";
        return redirect()->route('tshirt.indexAdmin')
            ->with('alert-msg', $htmlMessage)
            ->with('alert-type', 'success');
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(TshirtImageRequest $request)
    {

        $formData = $request->validated();
        $imagem = DB::transaction(function () use ($formData, $request) {
            $newImage = new TshirtImage();
            $newImage->name = $formData['name'];
            $newImage->description = $formData['description'];
            $newImage->customer_id = $formData['idUser'];
            if ($request->hasFile('image_url')) {
                $path = $request->image_url->store('tshirt_images_private');
                $newImage->image_url = basename($path);
                $newImage->save();
            }
            return $newImage;
        });
        $url = route('user.show', ['user' => $request->idUser]);
        $htmlMessage = "Imagem foi criada com sucesso!";
        return redirect()->route('user.show', ['user' => $request->idUser])
            ->with('alert-msg', $htmlMessage)
            ->with('alert-type', 'success');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TshirtImage $tshirtImage)
    {
        return view('tshirt.edit', compact('tshirtImage'));
    }

    public function editAdmin(TshirtImage $tshirtImage)
    {
        $this->authorize('updateAdmin', $tshirtImage);
        $categorias = Category::all();
        return view('tshirt.editAdmin', compact('tshirtImage', 'categorias'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TshirtImageRequest $request, TshirtImage $tshirtImage)
    {
        if ($tshirtImage->orderItems()->exists() && $tshirtImage->orderItems()->whereHas('order', function ($query) {
            $query->where('status', 'paid')->orWhere('status', 'pending');
        })->exists()) {
            $idCustomer = $tshirtImage->customer_id;
            $htmlMessage = "Não pode alterar esta Imagem por já estar a ser usada numa Encomenda ainda não terminada";
            return redirect()->route('user.show', ['user' => $idCustomer])
                ->with('alert-msg', $htmlMessage)
                ->with('alert-type', 'danger');
        }


        $idCustomer = $tshirtImage->customer_id;
        $formData = $request->validated();
        $tshirtImage = DB::transaction(function () use ($formData, $tshirtImage, $request) {
            $tshirtImage->name = $formData['name'];
            $tshirtImage->description = $formData['description'];
            $tshirtImage->save();
            if ($request->hasFile('image_url')) {
                if ($tshirtImage->image_url) {
                    Storage::delete('tshirt_images_private/' . $tshirtImage->image_url);
                }
                $path = $request->image_url->store('tshirt_images_private/');
                $tshirtImage->image_url = basename($path);
                $tshirtImage->save();
            }
            return $tshirtImage;
        });

        $url = route('user.show', ['user' => $idCustomer]);
        $htmlMessage = "Imagem foi alterada com sucesso!";
        return redirect()->route('user.show', ['user' => $idCustomer])
            ->with('alert-msg', $htmlMessage)
            ->with('alert-type', 'success');
    }


    public function updateAdmin(TshirtImageRequest $request, TshirtImage $tshirtImage)
    {
        $this->authorize('updateAdmin', $tshirtImage);
        if ($tshirtImage->orderItems()->exists() && $tshirtImage->orderItems()->whereHas('order', function ($query) {
            $query->where('status', 'paid')->orWhere('status', 'pending');
        })->exists()) {
            $htmlMessage = "Não pode alterar esta Imagem por já estar a ser usada numa Encomenda ainda não terminada";
            return redirect()->route('tshirt.indexAdmin')
                ->with('alert-msg', $htmlMessage)
                ->with('alert-type', 'danger');
        }
        $formData = $request->validated();
        $tshirtImage = DB::transaction(function () use ($formData, $tshirtImage, $request) {
            $tshirtImage->name = $formData['name'];
            $tshirtImage->description = $formData['description'];
            $tshirtImage->category_id = $formData['idCategory'];
            $tshirtImage->save();
            if ($request->hasFile('image_url')) {
                if ($tshirtImage->image_url) {
                    Storage::delete('public/tshirt_images/' . $tshirtImage->image_url);
                }
                $path = $request->image_url->store('public/tshirt_images/');
                $tshirtImage->image_url = basename($path);
                $tshirtImage->save();
            }
            return $tshirtImage;
        });

        $url = route('tshirt.indexAdmin');
        $htmlMessage = "Imagem foi alterada com sucesso!";
        return redirect()->route('tshirt.indexAdmin')
            ->with('alert-msg', $htmlMessage)
            ->with('alert-type', 'success');
    }


    /**
     * Remove the specified resource from storage.
     */

    public function destroyAdmin(TshirtImage $tshirtImage)
    {
        $this->authorize('deleteAdmin', $tshirtImage);
        try {

            $tshirtImage->category_id = null;
            $tshirtImage->orderItems()->delete();
            $tshirtImage->save();
            $tshirtImage->delete();

            if ($tshirtImage->image_url) {
                Storage::delete('public/tshirt_images/' . $tshirtImage->image_url);
            }
            $htmlMessage = "Imagem
                        <strong>\"{$tshirtImage->name}\"</strong> foi apagado com sucesso!";
            return redirect()->route('tshirt.indexAdmin')
                ->with('alert-msg', $htmlMessage)
                ->with('alert-type', 'success');
        } catch (\Exception $error) {
            $url = route('tshirt.indexAdmin');
            $htmlMessage = "Esta Imagem está relaciona com uma encomenda não acabada logo não pode ser apagada";
            $alertType = 'danger';
        }
        return back()
            ->with('alert-msg', $htmlMessage)
            ->with('alert-type', $alertType);
    }

    public function destroy(TshirtImage $tshirtImage): RedirectResponse
    {

        $idCustomer = $tshirtImage->customer_id;
        try {

            $tshirtImage->delete();

            if ($tshirtImage->image_url) {
                Storage::delete('tshirt_images_private/' . $tshirtImage->image_url);
            }
            $htmlMessage = "Imagem
                        <strong>\"{$tshirtImage->name}\"</strong> foi apagado com sucesso!";
            return redirect()->route('user.show', ['user' => $idCustomer])
                ->with('alert-msg', $htmlMessage)
                ->with('alert-type', 'success');
        } catch (\Exception $error) {
            $url = route('user.show', ['user' => $idCustomer]);
            $htmlMessage = "Esta Imagem está relaciona com uma encomenda não acabada logo não pode ser apagada";
            $alertType = 'danger';
        }
        return back()
            ->with('alert-msg', $htmlMessage)
            ->with('alert-type', $alertType);
    }



    public function getPrivateImg(TshirtImage $tshirtImage)
    {
        $this->authorize('view', $tshirtImage);
        return Storage::get('tshirt_images_private/' . $tshirtImage->image_url);
    }
}
