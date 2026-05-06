<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MediaFormatController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InterestController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RelatorioController;
use App\Http\Controllers\CommunityController;
use App\Http\Controllers\ReviewController;

// --- AUTENTICAÇÃO ---
Auth::routes();

// --- ÁREA PÚBLICA (Vitrine) ---
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/home', [HomeController::class, 'index']);

// ========== ROTAS PÚBLICAS ==========

Route::get('/itens', [ItemController::class, 'index'])->name('items.index');
Route::get('/itens/{item}', [ItemController::class, 'show'])->name('items.show');

Route::get('/categorias', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categorias/{category}', [CategoryController::class, 'show'])->name('categories.show');

Route::get('/formatos', [MediaFormatController::class, 'index'])->name('formats.index');
Route::get('/formatos/{mediaFormat}', [MediaFormatController::class, 'show'])->name('formats.show');

Route::get('/comunidades', [CommunityController::class, 'index'])->name('communities.index');
Route::get('/comunidades/perfil/{user}', [CommunityController::class, 'profile'])->name('communities.profile');
Route::get('/comunidades/review/{review}', [CommunityController::class, 'showReview'])->name('communities.review');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/relatorio/geral', [RelatorioController::class, 'gerarRelatorioItens'])->name('relatorio.itens');

// Lista e detalhes de reviews (Geral)
Route::get('/avaliacoes', [ReviewController::class, 'index'])->name('reviews.index');
Route::get('/avaliacoes/{review}', [ReviewController::class, 'show'])->name('reviews.show');


// ========== ÁREA RESTRITA (REQUER LOGIN) ==========
Route::middleware(['auth'])->group(function () {
    // --- NOVA ROTA PARA ATUALIZAR O PERFIL (UPLOAD DE FOTO) ---
    Route::post('/perfil/atualizar', [CommunityController::class, 'updateProfile'])->name('profile.update');

    // ---- GESTÃO DE INTERESSES ----
    Route::get('/items/{item}/interest', [InterestController::class, 'create'])->name('interests.create');
    Route::post('/items/{item}/interest', [InterestController::class, 'store'])->name('interests.store');
    Route::get('/meus-interesses', [InterestController::class, 'index'])->name('interests.index');
    
    // Rotas específicas: PDF primeiro para evitar conflito com {interest}
    Route::get('/interesses/exportar-pdf', [InterestController::class, 'generatePDF'])->name('interests.pdf');
    
    // Rotas com parâmetro {interest} (precisa vir depois das fixas)
    Route::get('/interesses/{interest}', [InterestController::class, 'show'])->name('interests.show');
    Route::get('/interesses/{interest}/edit', [InterestController::class, 'edit'])->name('interests.edit');
    Route::put('/interesses/{interest}', [InterestController::class, 'update'])->name('interests.update');
    Route::delete('/interesses/{interest}', [InterestController::class, 'destroy'])->name('interests.destroy');


    // ---- REVIEWS (AVALIAÇÕES VINCULADAS AO ITEM) ----
    // 1. Abre o formulário passando o ID do item
    Route::get('/itens/{item}/avaliar', [ReviewController::class, 'create'])->name('reviews.create');
    
    // 2. Salva a avaliação (O método store do seu controller recebe Item $item)
    Route::post('/itens/{item}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    
    // 3. Edição e Exclusão (Baseado na Review existente)
    // Nota: a rota create repetida foi removida (já existe acima) e a store também.
    // Mantenha apenas:
    Route::get('/reviews/{review}/edit', [ReviewController::class, 'edit'])->name('reviews.edit');
    Route::put('/reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
    
    // ---- GERENCIAMENTO DO ACERVO ----
    Route::get('/items/create', [ItemController::class, 'create'])->name('items.create');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::get('/formats/create', [MediaFormatController::class, 'create'])->name('formats.create');

    Route::post('/items', [ItemController::class, 'store'])->name('items.store');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::post('/formats', [MediaFormatController::class, 'store'])->name('formats.store');

    Route::get('/items/{item}/edit', [ItemController::class, 'edit'])->name('items.edit');
    Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::get('/formats/{mediaFormat}/edit', [MediaFormatController::class, 'edit'])->name('formats.edit');

    Route::put('/items/{item}', [ItemController::class, 'update'])->name('items.update');
    Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::put('/formats/{mediaFormat}', [MediaFormatController::class, 'update'])->name('formats.update');

    Route::delete('/items/{item}', [ItemController::class, 'destroy'])->name('items.destroy');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    Route::delete('/formats/{mediaFormat}', [MediaFormatController::class, 'destroy'])->name('formats.destroy');

    Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
});