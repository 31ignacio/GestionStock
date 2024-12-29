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
    /**
     * Afficher la liste des utilisateurs
     */
    public function index(){
      
        $admins = User::
        orderBy('created_at', 'desc')
        ->get();
      $roles = Role::all();
      
        return view('Admin.index',compact('admins','roles'));
    }


    /**
     * Enregistrer un utilsateur
    */
    public function store(User $user,createUsersRequest $request)
    {

        try {
            
            $user->name = $request->name;
            $user->email = $request->email;
            $user->role_id= $request->role;
            $user->password =Hash::make($request->password);
            $user->save();

            return redirect()->route('admin')->with('success_message', 'Utilisateur ajouté avec succès');
            
        } catch (Exception $e) {
           
            return back()->with('error_message', "Une erreur est survenue : " . $e->getMessage());
        }
    }

   /**
    * Déconnecté un utilisateur
    */
    public function logout(){

        FacadesSession::flush();
        Auth::logout();

        return redirect()->route('login');
    }

    /**
     * Modifier un utilisateur
     */
    public function update(User $admin, Request $request)
    {
        //Enregistrer un nouveau département
        try {
            $admin->name = $request->nom;
            $admin->email = $request->email;
            $admin->role_id = $request->role;

            $admin->update();

            return redirect()->route('admin')->with('success_message', 'Utilisateur mis à jour avec succès');
        } catch (Exception $e) {
            return back()->with('error_message', "Une erreur est survenue : " . $e->getMessage());

        }
    }


    /**
     * Supprimer un utilisateur
     */
    public function delete(User $admin)
    {
        //Enregistrer un nouveau département
        try {
            $admin->delete();

            return redirect()->route('admin')->with('success_message', 'Utilisateur supprimé avec succès');
        } catch (Exception $e) {
            return back()->with('error_message', "Une erreur est survenue : " . $e->getMessage());

        }
    }

    /**
     *  Activer/desactiver un utilisateur
     * */ 
    public function toggleStatus(User $admin)
    {
        $admin->estActif = !$admin->estActif; // Bascule entre 0 et 1
        $admin->save();

        return redirect()->back()->with('success_message', 'Statut mis à jour avec succès.');
    }

}
