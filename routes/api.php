<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Page d'accueil
Route::get('/', [HomeController::class, 'index'])->name('home');

// Catalogue des produits
Route::get('/produits', [ProductController::class, 'index'])->name('products.index');
Route::get('/produits/{id}', [ProductController::class, 'show'])->name('products.show');

// Authentification et gestion des utilisateurs
Auth::routes();
Route::get('/profil', [UserController::class, 'profile'])->middleware('auth')->name('user.profile');
Route::put('/profil', [UserController::class, 'updateProfile'])->middleware('auth')->name('user.updateProfile');

// Gestion du panier
Route::get('/panier', [CartController::class, 'index'])->name('cart.index');
Route::post('/panier/ajouter/{id}', [CartController::class, 'add'])->name('cart.add');
Route::put('/panier/modifier/{id}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/panier/supprimer/{id}', [CartController::class, 'remove'])->name('cart.remove');

// Commandes
Route::get('/commande', [OrderController::class, 'index'])->middleware('auth')->name('order.index');
Route::post('/commande/valider', [OrderController::class, 'store'])->middleware('auth')->name('order.store');
Route::get('/commande/{id}', [OrderController::class, 'show'])->middleware('auth')->name('order.show');

// Routes Admin - Middleware pour sécuriser l'accès
Route::middleware(['auth', 'is_admin'])->group(function () {
    // Gestion des produits
    Route::resource('admin/produits', Admin\ProductController::class);

    // Gestion des catégories
    Route::resource('admin/categories', Admin\CategoryController::class);

    // Gestion des utilisateurs
    Route::resource('admin/utilisateurs', Admin\UserController::class);
});

// Route pour la recherche de produits
Route::get('/recherche', [SearchController::class, 'search'])->name('search');

// Contact
Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');