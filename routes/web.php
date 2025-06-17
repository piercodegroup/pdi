<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\ClienteAuthController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\SacolaController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\PerfilController;

use App\Models\Cliente;

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AdminProdutoController;
use App\Http\Controllers\Admin\AdminCategoriaController;
use App\Http\Controllers\Admin\AdminClienteController;
use App\Http\Controllers\Admin\AdminPedidoController;
use App\Http\Controllers\Admin\AdminUsuarioController;
use App\Http\Controllers\Admin\AdminPerfilController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/produtos', [ProdutoController::class, 'index'])->name('produtos.index');
Route::get('/produtos/{id}', [ProdutoController::class, 'show'])->name('produtos.show');

Route::view('/sobre', 'sobre')->name('sobre');
Route::view('/contato', 'contato')->name('contato');
Route::view('/termos', 'termos')->name('termos');

Route::middleware(['guest:cliente'])->group(function () {
    Route::get('/login', [ClienteAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [ClienteAuthController::class, 'login']);
    
    Route::get('/registrar', [ClienteAuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/registrar', [ClienteAuthController::class, 'register']);
});

Route::post('/logout', [ClienteAuthController::class, 'logout'])
    ->middleware('auth:cliente')
    ->name('logout');

Route::middleware(['auth:cliente'])->group(function () {

    Route::get('/pedidos/confirmar', [PedidoController::class, 'confirmar'])->name('pedidos.confirmar');
    Route::post('/pedidos/finalizar', [PedidoController::class, 'finalizar'])->name('pedidos.finalizar');
    
    Route::prefix('perfil')->controller(PerfilController::class)->group(function () {
        Route::get('/', 'index')->name('perfil');
        Route::put('/atualizar', 'atualizar')->name('perfil.atualizar');
        
        Route::get('/enderecos', 'enderecos')->name('perfil.enderecos');
        Route::post('/enderecos/adicionar', 'adicionarEndereco')->name('perfil.enderecos.adicionar');
        Route::put('/enderecos/editar/{id}', 'editarEndereco')->name('perfil.enderecos.editar');
        Route::delete('/enderecos/remover/{id}', 'removerEndereco')->name('perfil.enderecos.remover');
        
        Route::get('/cartoes', 'cartoes')->name('perfil.cartoes');
        Route::post('/cartoes/adicionar', 'adicionarCartao')->name('perfil.cartoes.adicionar');
        Route::get('/cartoes/editar/{id}', 'getCartaoParaEdicao');
        Route::put('/cartoes/editar/{id}', 'editarCartao')->name('perfil.cartoes.editar');
        Route::delete('/cartoes/remover/{id}', 'removerCartao')->name('perfil.cartoes.remover');
    });

    Route::prefix('sacola')->controller(SacolaController::class)->group(function () {
        Route::get('/', 'index')->name('sacola.index');
        Route::post('/adicionar', 'adicionar')->name('sacola.adicionar');
        Route::patch('/atualizar/{item}', 'atualizar')->name('sacola.atualizar');
        Route::delete('/remover/{item}', 'remover')->name('sacola.remover');
    });

    Route::prefix('pedidos')->controller(PedidoController::class)->group(function () {
        Route::get('/', 'index')->name('pedidos.index');
        Route::get('/{id}', 'show')->name('pedidos.show');
    });
    
});

Route::get('/admin/clientes/{cliente}/enderecos', function(Cliente $cliente) {
    return response()->json($cliente->enderecos);
});

Route::get('/admin/clientes/{cliente}/cartoes', function(Cliente $cliente) {
    return response()->json($cliente->cartoes);
});

Route::prefix('admin')->group(function () {

    Route::middleware(['guest:admin'])->group(function () {
        Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
        Route::post('/login', [AdminAuthController::class, 'login']);
    });
    
    Route::post('/logout', [AdminAuthController::class, 'logout'])
        ->middleware('auth:admin')
        ->name('admin.logout');
        
    Route::middleware(['auth:admin'])->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
        Route::get('/pedidos/relatorio', [AdminPedidoController::class, 'relatorio'])->name('admin.pedidos.relatorio');
        Route::get('/clientes/relatorio', [AdminClienteController::class, 'relatorio'])->name('admin.clientes.relatorio');
        Route::post('/pedidos/store', [AdminPedidoController::class, 'store'])->name('admin.pedidos.store');

        Route::get('/clientes/{cliente}/enderecos', [AdminClienteController::class, 'enderecos'])->name('admin.clientes.enderecos');
        Route::delete('/clientes/{cliente}/enderecos/{endereco}', [AdminClienteController::class, 'removerEndereco'])->name('admin.clientes.enderecos.remover');
        
        Route::get('/clientes/{cliente}/cartoes', [AdminClienteController::class, 'cartoes'])->name('admin.clientes.cartoes');
        Route::delete('/clientes/{cliente}/cartoes/{cartao}', [AdminClienteController::class, 'removerCartao'])->name('admin.clientes.cartoes.remover');

        Route::prefix('pedidos')->controller(AdminPedidoController::class)->group(function () {
            Route::get('/', 'index')->name('admin.pedidos.index');
            Route::get('/criar', 'create')->name('admin.pedidos.create');
            Route::get('/{id}', 'show')->name('admin.pedidos.show');
            Route::post('/{id}/status', 'atualizarStatus')->name('admin.pedidos.status');
        });

        Route::prefix('clientes')->controller(AdminClienteController::class)->group(function () {
            Route::get('/', 'index')->name('admin.clientes.index');
            Route::get('/criar', 'create')->name('admin.clientes.create');
            Route::post('/', 'store')->name('admin.clientes.store');
            Route::get('/{id}', 'show')->name('admin.clientes.show');
            Route::get('/{id}/editar', 'edit')->name('admin.clientes.edit');
            Route::put('/{id}', 'update')->name('admin.clientes.update');
            Route::delete('/{id}', 'destroy')->name('admin.clientes.destroy');
            Route::get('/{id}/pedidos', 'pedidos')->name('admin.clientes.pedidos');
        });

        Route::prefix('produtos')->controller(AdminProdutoController::class)->group(function () {
            Route::get('/', 'index')->name('admin.produtos.index');
            Route::get('/criar', 'create')->name('admin.produtos.create');
            Route::post('/', 'store')->name('admin.produtos.store');
            Route::get('/{id}/editar', 'edit')->name('admin.produtos.edit');
            Route::put('/{id}', 'update')->name('admin.produtos.update');
            Route::delete('/{id}', 'destroy')->name('admin.produtos.destroy');
            Route::get('/relatorio', 'relatorio')->name('admin.produtos.relatorio');
        });

        Route::prefix('categorias')->controller(AdminCategoriaController::class)->group(function () {
            Route::get('/', 'index')->name('admin.categorias.index');
            Route::get('/criar', 'create')->name('admin.categorias.create');
            Route::post('/', 'store')->name('admin.categorias.store');
            Route::get('/{id}/editar', 'edit')->name('admin.categorias.edit');
            Route::put('/{id}', 'update')->name('admin.categorias.update');
            Route::delete('/{id}', 'destroy')->name('admin.categorias.destroy');
            Route::get('/relatorio', 'relatorio')->name('admin.categorias.relatorio');
        });
        
        Route::prefix('usuarios')->controller(AdminUsuarioController::class)->group(function () {
            Route::get('/', 'index')->name('admin.usuarios.index');
            Route::get('/criar', 'create')->name('admin.usuarios.create');
            Route::post('/', 'store')->name('admin.usuarios.store');
            Route::get('/{id}', 'show')->name('admin.usuarios.show');
            Route::get('/{id}/editar', 'edit')->name('admin.usuarios.edit');
            Route::put('/{id}', 'update')->name('admin.usuarios.update');
            Route::delete('/{id}', 'destroy')->name('admin.usuarios.destroy');
        });
        
        Route::prefix('perfil')->controller(AdminPerfilController::class)->group(function () {
            Route::get('/', 'edit')->name('admin.perfil');
            Route::put('/', 'update')->name('admin.perfil.update');
            Route::put('/senha', 'updatePassword')->name('admin.perfil.senha');
        });
    });
});

/* Rota Fallback */
Route::fallback(function () {
    return view('errors.404');
});