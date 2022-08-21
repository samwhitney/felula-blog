<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Guest Routes
|--------------------------------------------------------------------------
*/


/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::group(['middleware' => ['auth']], function () {

	Route::get('/admin/posts', \App\Http\Livewire\Admin\Posts::class)->name('admin-posts');

});

require __DIR__.'/auth.php';
