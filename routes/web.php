<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PanelController;

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

// Welcome
Route::get('/', function () {
    if(Auth::check())
        return redirect(route('panel'));
    return view('welcome.index');
});

// Panel
Route::get('/panel', [PanelController::class, 'index'])->middleware(['auth', 'verified'])->name('panel');
Route::get('/panel/{node}', [PanelController::class, 'node_index'])->middleware(['auth', 'verified'])->name('node.panel');

// Add a New Node
Route::post('/node', [PanelController::class, 'add_node'])->middleware(['auth', 'verified'])->name('node.make');

// Delete a Node
Route::get('/node/{node}/del', [PanelController::class, 'del_node'])->middleware(['auth', 'verified'])->name('node.del');

// Edit a Node
Route::post('/node/{node}', [PanelController::class, 'edit_node'])->middleware(['auth', 'verified'])->name('node.edit');

// Load Node
Route::get('/node/{node}', [PanelController::class, 'node'])->middleware(['auth', 'verified'])->name('node');
Route::get('/node/{node}/content', [PanelController::class, 'node_content'])->middleware(['auth', 'verified'])->name('node.content');


Route::get('/info', [PanelController::class, 'info'])->middleware(['auth', 'verified'])->name('info');


// Auth Pages
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// 

require __DIR__.'/auth.php';
