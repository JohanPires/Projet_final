<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function getUsers() {
        $users = User::all();

        return $users;
    }
    public function getOneUser($id) {
        $user = User::find($id);

        return $user;
    }


    public function deleteUser($id) {
        $user = User::find($id);
        $user->delete();

        return response()->json(['status' => 200, 'content' => 'Utilisateur supprimé avec succées']);
    }

    public function postUser(Request $request) {
        $user = new User;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->role = 'user';
        $user->save();

        return response()->json(['status' => 200, 'content' => 'Utilisateur ajouter avec succées']);
    }

    public function editUser($id, Request $request) {
        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->save();

        return response()->json(['status' => 200, 'content' => 'Utilisateur modifier avec succées']);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json(['message' => 'User created successfully']);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Identifiant faux'],
            ]);
        }

        $token = $user->createToken('auth-token')->plainTextToken;
        $id = $user->id;

        return response()->json(['token' => $token, 'id' => $id]);
    }

    public function logout()
    {

        Auth::user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Déconnexion']);
    }
}
