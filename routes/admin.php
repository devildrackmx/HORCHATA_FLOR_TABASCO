<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\HorchataController;
use App\Http\Controllers\Admin\ProveedorController;
use App\Http\Controllers\Admin\InsumoController;
use App\Http\Controllers\Admin\CompraController;
use App\Http\Controllers\Admin\RevolturaController;
use App\Http\Controllers\Admin\EmbasadoController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\DevolucionController;

Route::get('', [AdminController::class, 'index'])->middleware('can:admin.index')->name('admin.index');

Route::resource('users', UserController::class)->names('admin.users');

Route::resource('roles', RoleController::class)->names('admin.roles');

Route::resource('horchatas', HorchataController::class)->names('admin.horchatas');
Route::resource('proveedores', ProveedorController::class)->names('admin.proveedores');
Route::resource('insumos', InsumoController::class)->names('admin.insumos');
Route::resource('compras', CompraController::class)->names('admin.compras');
Route::resource('devoluciones', DevolucionController::class)->names('admin.devoluciones');
Route::resource('revolturas', RevolturaController::class)->names('admin.revolturas');
Route::resource('embasados', EmbasadoController::class)->names('admin.embasados');
Route::get('notifications/get-insumos', [AdminController::class, 'getInsumosNotifications'])->name('notifications.get-insumos');
Route::get('compras/{compra}/orden-de-compra', [CompraController::class, 'generarOrdenCompraPDF'])->name('admin.compras.orden_de_compra');
Route::get('devoluciones/{devolucion}/devolucion', [CompraController::class, 'devolucionPDF'])->name('admin.devoluciones.devolucion');
