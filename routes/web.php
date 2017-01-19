<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Auth::routes();
Route::get('/sair', 'Auth\LoginController@logout');

//Error 404 página não encontrada;
Route::get('/error404', function()
{
    return view('errors.error404');
});

Route::get('/', 'InicioController@index');
Route::get('/home', 'InicioController@index');

//Rotas para gestão de usuários
Route::get('/users', 'UserController@listar');
Route::get('/users/novo', 'UserController@novo');
Route::post('/users/salvar', 'UserController@salvar');
Route::get('/users/editar/{id}', 'UserController@editar');
Route::post('/users/atualizar/{id}', 'UserController@atualizar');
Route::post('/users/removerLote', 'UserController@removerLote');
Route::post('/users/editarLote', 'UserController@editarLote');
Route::post('/users/atualizarLote', 'UserController@atualizarLote');

//Rotas para gestão de permissões
Route::get('/permissoes', 'PermissaoController@listar');
Route::get('/permissoes/novo', 'PermissaoController@novo');
Route::post('/permissoes/salvar', 'PermissaoController@salvar');
Route::get('/permissoes/editar/{id}', 'PermissaoController@editar');
Route::post('/permissoes/atualizar/{id}', 'PermissaoController@atualizar');
Route::post('/permissoes/removerLote', 'PermissaoController@removerLote');
Route::post('/permissoes/editarLote', 'PermissaoController@editarLote');
Route::post('/permissoes/atualizarLote', 'PermissaoController@atualizarLote');

//Rota para listar o consumo individual
Route::get('/perfil/{id}', 'PerfilController@listar');

//Rotas para gestão de Cardápio
Route::get('/cardapios', 'CardapioController@listar');
Route::get('/cardapios/novo', 'CardapioController@novo');
Route::post('/cardapios/salvar', 'CardapioController@salvar');
Route::get('/cardapios/editar/{id}', 'CardapioController@editar');
Route::post('/cardapios/atualizar/{id}', 'CardapioController@atualizar');
Route::post('/cardapios/removerLote', 'CardapioController@removerLote');
Route::post('/cardapios/editarLote', 'CardapioController@editarLote');
Route::post('/cardapios/atualizarLote', 'CardapioController@atualizarLote');

//Rotas para gestão de Pedidos
Route::get('/pedidos', 'PedidoController@listar');
Route::get('/pedidos/novo', 'PedidoController@novo');
Route::post('/pedidos/salvar', 'PedidoController@salvar');
Route::get('/pedidos/editar/{id}', 'PedidoController@editar');
Route::post('/pedidos/atualizar/{id}', 'PedidoController@atualizar');
Route::post('/pedidos/removerLote', 'PedidoController@removerLote');
Route::post('/pedidos/atualizarLote', 'PedidoController@atualizarLote');

//Rotas para gestão de Produtos
Route::get('/produtos', 'ProdutoController@listar');
Route::get('/produtos/novo', 'ProdutoController@novo');
Route::post('/produtos/salvar', 'ProdutoController@salvar');
Route::get('/produtos/editar/{id}', 'ProdutoController@editar');
Route::post('/produtos/atualizar/{id}', 'ProdutoController@atualizar');
Route::post('/produtos/removerLote', 'ProdutoController@removerLote');
Route::post('/produtos/editarLote', 'ProdutoController@editarLote');
Route::post('/produtos/atualizarLote', 'ProdutoController@atualizarLote');
