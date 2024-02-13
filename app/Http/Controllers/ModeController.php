<?php

namespace App\Http\Controllers;
use App\Http\Requests\saveModeRequest;
use Exception;
use App\Models\ModePaiement;


use Illuminate\Http\Request;

class ModeController extends Controller
{
    //

    public function index()
    {
        $modes = ModePaiement::paginate(10);

        return view('Modes.index',compact('modes'));
    }

    public function create()
    {
        return view('Modes.create');
    }

    public function store(ModePaiement $mode, Request $request)
    {
        //Enregistrer un nouveau client
        try {
            $mode->modePaiement = $request->mode;

            $mode->save();

            return redirect()->route('mode.index')->with('success_message', 'Mode de paiement enregistré avec succès');
        } catch (Exception $e) {
            dd($e);
        }
    }

    public function delete(ModePaiement $mode)
    {
        //Enregistrer un nouveau département
        try {
            $mode->delete();

            return redirect()->route('mode.index')->with('success_message', 'Mode de paiement supprimé avec succès');
        } catch (Exception $e) {
            dd($e);
        }
    }



}
