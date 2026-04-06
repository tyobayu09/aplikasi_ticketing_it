<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\AuthController;

// ================= AREA PUBLIK (KLIEN) =================
Route::get('/', [TicketController::class, 'clientHome'])->name('home');
Route::get('/create-ticket', [TicketController::class, 'clientCreate'])->name('ticket.create');
Route::post('/create-ticket', [App\Http\Controllers\TicketController::class, 'clientStore'])->name('client.store');
Route::post('/submit-ticket', [TicketController::class, 'clientStore'])->name('ticket.submit');
Route::get('/track', [TicketController::class, 'trackTicket'])->name('ticket.track');
Route::post('/track', [TicketController::class, 'searchTicket'])->name('ticket.search');

// ================= AREA AUTENTIKASI =================
// Halaman Login
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ================= AREA ADMIN / IT (DILINDUNGI) =================
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [TicketController::class, 'index'])->name('tickets.index');
    Route::get('/tickets/{ticket}', [TicketController::class, 'show'])->name('tickets.show');
    Route::put('/tickets/{ticket}', [TicketController::class, 'update'])->name('tickets.update');

    // ROUTE LAPORAN 
    Route::get('/report', [TicketController::class, 'report'])->name('tickets.report');
    // Notifikasi untuk admin/IT jika ada tiket baru
    Route::get('/check-new-tickets', [TicketController::class, 'checkNewTickets'])->name('tickets.check');
});