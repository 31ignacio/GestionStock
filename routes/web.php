<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\EtatController;
use App\Http\Controllers\FactureController;
use App\Http\Controllers\ModeController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\AccueilController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', [AuthController::class, 'login'])->name('login');
Route::post('/', [AuthController::class, 'handleLogin'])->name('handleLogin');

Route::prefix('admin')->group(function () {
    Route::get('/logout', [AdminController::class, 'logout'])->name('logout');

    Route::get('/admin', [AdminController::class, 'index'])->name('admin');
    Route::post('/create', [AdminController::class, 'store'])->name('admin.store');
    Route::delete('/{admin}', [AdminController::class, 'delete'])->name('admin.delete');
    Route::put('/update/{admin}', [AdminController::class, 'update'])->name('admin.update');
    Route::PATCH('/toggleStatus/{admin}', [AdminController::class, 'toggleStatus'])->name('admin.toggleStatus');

});

Route::middleware(['auth'])->group(function(){

    Route::get('/accueil', [AccueilController::class, 'index'])->name('accueil.index');

    Route::prefix('client')->group(function () {
        Route::get('/', [ClientController::class, 'index'])->name('client.index');
        Route::get('/detteClient', [ClientController::class, 'dette'])->name('client.dette');
    
        Route::get('/detail{client}', [ClientController::class, 'detail'])->name('client.detail');
        Route::post('/remboursement', [ClientController::class, 'rembourssement'])->name('client.rembourssement');
        Route::post('/create', [ClientController::class, 'store'])->name('client.store');
        Route::put('/update/{client}', [ClientController::class, 'update'])->name('client.update');
         Route::post('/detailRemb', [ClientController::class, 'detailRembourssement'])->name('detailRembourssement');
        // Route::post('/detailRembs', [ClientController::class, 'detailRembourssements'])->name('detailRembourssements');

        Route::get('/pdf/{remboursement}/{code}/{clientId}', [ClientController::class, "pdf"])->name('rembourssement.pdf');
    
        Route::delete('/{client}', [ClientController::class, 'delete'])->name('client.delete');
    });
    
    Route::prefix('etat')->group(function () {
        Route::get('/', [EtatController::class, 'search'])->name('etat.index');
    });
    
    
    Route::prefix('produit')->group(function () {
        Route::get('/', [ProduitController::class, 'index'])->name('produit.index');
        Route::post('/create', [ProduitController::class, 'store'])->name('produit.store');
        Route::put('/update/{produit}', [ProduitController::class, 'update'])->name('produit.update');
        Route::delete('/{produit}', [ProduitController::class, 'delete'])->name('produit.delete');
    });
    
    
    Route::prefix('facture')->group(function () {
        Route::get('/', [FactureController::class, 'index'])->name('facture.index');
        Route::get('/create', [FactureController::class, 'create'])->name('facture.create');
        Route::post('/create', [FactureController::class, 'store'])->name('facture.store');
        Route::get('/edit/{facture}', [FactureController::class, 'edit'])->name('facture.edit');
        Route::put('/update/{facture}', [FactureController::class, 'update'])->name('facture.update');
        Route::get('/details/{code}/{date}',[FactureController::class, 'details'])->name('facture.details');
        Route::get('/annuler',[FactureController::class, 'annuler'])->name('facture.annuler');
        Route::get('/pdf/{facture}', [FactureController::class, "pdf"])->name('facture.pdf');
        Route::get('/{facture}', [FactureController::class, 'delete'])->name('facture.delete');
    });
    
    
    Route::prefix('stock')->group(function () {
        Route::get('/', [StockController::class, 'index'])->name('stock.index');
        Route::get('/entrer', [StockController::class, 'entrer'])->name('stock.entrer');
        Route::get('/sortie', [StockController::class, 'sortie'])->name('stock.sortie');
        Route::get('/actuel', [StockController::class, 'actuel'])->name('stock.actuel');
        Route::post('/create', [StockController::class, 'store'])->name('stock.store');
        Route::get('/recherche/detail', [StockController::class, 'rechercheDetail'])->name('stock.rechercheDetail');

        Route::post('/stock/{id}', [StockController::class, 'update'])->name('stock.update');

    });

    Route::get('/inventaires/details', [StockController::class, 'indexinventaire'])->name('inventaires.index');

    
    

});
