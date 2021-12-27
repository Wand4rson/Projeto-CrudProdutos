<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
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


//

//Login
Route::get('/login', [UserController::class, 'showFormLogin'])->name('login');
Route::post('/login', [UserController::class, 'showFormLoginAction'])->name('login.autenticar');
Route::get('/logout', [UserController::class, 'logout'])->name('logout');

//Login Novo Usuário
Route::get('/login/usuario', [UserController::class, 'showFormNovoUsuario'])->name('login.novo.usuario');
Route::post('/login/usuario', [UserController::class, 'showFormNovoUsuarioAction'])->name('login.novo.usuario.salvar');

//Admin Editar Usuario Logado
Route::get('/login/usuario/editar', [AdminController::class,'showFormEditarUsuario'])->name('usuario.editar.form');
Route::post('/login/usuario/editar',[AdminController::class,'showFormEditarUsuarioAction'])->name('usuario.editar.salvar');

//Produto
Route::get('/painel/produto/cadastro',[AdminController::class, 'showFormNovoProduto'])->name('painel.produto.cadastro');
Route::post('/painel/produto/cadastro',[AdminController::class, 'showFormNovoProdutoAction'])->name('painel.produto.cadastroaction');
Route::get('/painel/produto/editar/{id}',[AdminController::class, 'showFormEditarProduto'])->name('painel.produto.editar');
Route::post('/painel/produto/editar/{id}',[AdminController::class, 'showFormEditarProdutoAction'])->name('painel.produto.editaraction');
Route::get('/painel/produto/remover/{id}',[AdminController::class, 'showRemoverProdutoAction'])->name('painel.produto.remover');

//Tag
Route::get('/painel/tag/cadastro',[AdminController::class, 'showFormNovoTag'])->name('painel.tag.cadastro');
Route::post('/painel/tag/cadastro',[AdminController::class, 'showFormNovoTagAction'])->name('painel.tag.cadastroaction');
Route::get('/painel/tag/editar/{id}',[AdminController::class, 'showFormEditarTag'])->name('painel.tag.editar');
Route::post('/painel/tag/editar/{id}',[AdminController::class, 'showFormEditarTagAction'])->name('painel.tag.editaraction');
Route::get('/painel/tag/remover/{id}',[AdminController::class, 'showRemoverTagAction'])->name('painel.tag.remover');

//Admin Dashboard
Route::get('/painel',  [AdminController::class, 'dashboard'])->name('painel.dashboard');
Route::get('/',  [AdminController::class, 'dashboard']);
