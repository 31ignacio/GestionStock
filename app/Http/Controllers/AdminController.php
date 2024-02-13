<?php

namespace App\Http\Controllers;

use App\Http\Requests\createUsersRequest;
use App\Models\User;
use App\Models\Role;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Exception;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session as FacadesSession;

class AdminController extends Controller
{
    //

    public function index(){
      // dd(Auth::id());

        $admins = User::all();

        //dd($admins);

        return view('Admin.index',compact('admins'));
    }

    public function create(){

        $roles = Role::all();
        return view('Admin.create',compact('roles'));
    }


    public function store(User $user,createUsersRequest $request)
    {

        try {
            $confirm= $request->confirm_password;

            $user->name = $request->name;
            $user->email = $request->email;
            $user->password =Hash::make($request->password);
            $user->role_id= $request->role;

            //dd($user);
            $user->save();

            
            return redirect()->route('admin')->with('success_message', 'Utilisateur ajouté avec succès');
            
        } catch (Exception $e) {
            //dd($e);
            throw new Exception('Une erreur est survenue lors de la création de cet administrateur');
        }
    }

    public function delete(User $admin)
    {
        //dd($admin);
        //Enregistrer un nouveau département
        try {
            $admin->delete();

            return redirect()->route('admin')->with('success_message', 'Utilisateur supprimé avec succès');
        } catch (Exception $e) {
            dd($e);
        }
    }

    public function logout(){

        FacadesSession::flush();
        Auth::logout();

        return redirect()->route('login');
    }

    public function edit(User $admin)
    {
        
        return view('Admin.edit', compact('admin'));
    }

    public function update(User $admin, Request $request)
    {
        //Enregistrer un nouveau département
        try {
            $admin->name = $request->nom;
            $admin->email = $request->email;
            $admin->role_id = $request->role;

            $admin->update();
            //return back()->with('success_message', 'Utilisateur mis à jour avec succès');

            return redirect()->route('admin')->with('success_message', 'Utilisateur mis à jour avec succès');
        } catch (Exception $e) {
            dd($e);
        }
    }


}
