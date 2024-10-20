<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserControllerRequest;
use App\Models\Aluno;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\TshirtImage;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use mysql_xdevapi\Collection;

class UserController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(User::class, 'user');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $users = User::all();
        $filterByUser = $request->user_type ?? 'C';
        $usersQuery = User::query();
        $usersQuery->where('user_type', $filterByUser);

        if ($filterByUser == 'A') {
            $user_type_nome = 'Administradores';
        } elseif ($filterByUser == 'E') {
            $user_type_nome = 'Funcionários';
        } else {
            $user_type_nome = 'Customers';
        }

        // Retrieve the paginated users based on the conditions
        $users = $usersQuery->paginate(9);

        return view('users/index', compact('users', 'filterByUser', 'user_type_nome'));
    }

    public function block(User $user)
    {
        if (Gate::denies('administrar')) {
            abort(403, 'Unauthorized');
        }
        $user->blocked = !$user->blocked;
        $user->save();

        return redirect()
            ->route('users.index', ['user' => $user])
            ->with('alert-msg', 'Utilizador"' . $user->name . '" ' .  ($user->blocked ? 'bloqueado' : 'desbloqueado') . ' com sucesso!')
            ->with('alert-type', 'success');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserControllerRequest $request)
    {


        $formData = $request->validated();
        $user = DB::transaction(function () use ($formData, $request) {
            $newUser = new User();
            $newUser->name = $formData['name'];
            $newUser->email = $formData['email'];
            $newUser->user_type = $formData['tipo'];
            $newUser->password = $formData['password'];
            $newUser->blocked = 0;
            $newUser->save();
            if ($request->hasFile('photo_url')) {
                if ($newUser->url_foto) {
                    Storage::delete('public/photos/' . $newUser->photo_url);
                }
                $path = $request->photo_url->store('public/photos');
                $newUser->photo_url = basename($path);
                $newUser->save();
            }
            return $newUser;
        });
        $url = route('user.index');
        $htmlMessage = "Utilizador criado com sucesso!";
        return redirect()->route('user.index')
            ->with('alert-msg', $htmlMessage)
            ->with('alert-type', 'success');

    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $authenticatedUser = auth()->user();
        $type = $user->user_type;
        $id = $user->id;

        if ($authenticatedUser->user_type == 'C') {
            $name = $authenticatedUser->name;
            $email = $authenticatedUser->email;
            $result = $authenticatedUser->fullPhotoUrl();
            $idCustomer = Customer::where('id', $authenticatedUser->id)->first();
            $TshirtImages = TshirtImage::where('customer_id', $idCustomer->id)->get();
            return view('users.show', compact('user', 'name', 'email', 'result', 'id', 'TshirtImages', 'idCustomer'));
        } else {
            $name = $user->name;
            $email = $user->email;
            $result = $user->fullPhotoUrl();
            $TshirtImages = collect();
            return view('users.show', compact('user', 'name', 'email', 'result', 'id', 'TshirtImages'));
        }

        return null;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {

        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserControllerRequest $request, User $user)
    {

        $formData = $request->validated();
        $user = DB::transaction(function () use ($formData, $user, $request) {
            $user->name = $formData['name'];
            $user->email = $formData['email'];
            $user->user_type = $formData['tipo'];
            $user->save();
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
        $url = route('user.show', ['user' => $user]);
        $htmlMessage = "Perfil alterado com sucesso!";
        return redirect()->route('user.show', ['user' => $user])
            ->with('alert-msg', $htmlMessage)
            ->with('alert-type', 'success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): RedirectResponse
    {
        try {

            DB::transaction(function () use ($user) {
                $user->delete();
            });
            if ($user->photo_url) {
                Storage::delete('public/photos/' . $user->photo_url);
            }
            $htmlMessage = "User #{$user->id}
                        <strong>\"{$user->name}\"</strong> foi apagado com sucesso!";
            return redirect()->route('users.index')
                ->with('alert-msg', $htmlMessage)
                ->with('alert-type', 'success');
        } catch (\Exception $error) {
            $url = route('users.index', ['user' => $user]);
            $htmlMessage = "Não foi possível apagar o User <a href='$url'>#{$user->id}</a>
                        <strong>\"{$user->name}\"</strong> porque ocorreu um erro!";
            $alertType = 'danger';
        }
        return back()
            ->with('alert-msg', $htmlMessage)
            ->with('alert-type', $alertType);
    }
}
