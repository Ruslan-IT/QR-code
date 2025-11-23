<?php

use App\Http\Controllers\LinkPdfController;
use Illuminate\Support\Facades\Route;


Route::get('/{link}/', [LinkPdfController::class, 'show'])
    ->name('links.pdf.view');

Route::get('/', function () {
    return view('welcome');
});
