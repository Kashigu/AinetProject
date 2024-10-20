<?php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Http\Requests\ChangePasswordRequest;
use Illuminate\Support\Facades\Hash;

class ChangePasswordController extends Controller
{
    public function show(): View
    {
        return view('auth.passwords.change');
    }
    public function store(ChangePasswordRequest $request): RedirectResponse
    {
        $user = $request->user();
        $user->password = Hash::make($request->validated()['password']);
        $user->save();
        return back()
            ->with('alert-msg', 'A senha foi alterada com sucesso')
            ->with('alert-type', 'success');
    }
}
