<?php

use Illuminate\Support\Facades\Route;
use App\Models\Post;

/*
|--------------------------------------------------------------------------
| Guest Routes
|--------------------------------------------------------------------------
*/

Route::get('/', \App\Http\Livewire\Blog::class)->name('blog');

Route::get('/article/{post}', function (Post $post) {
    return view('article', [ 'post' => $post] );
})->name('article');


/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::group(['middleware' => ['auth']], function () {

	Route::get('/admin/posts', \App\Http\Livewire\Admin\Posts::class)->name('admin-posts');
	Route::get('/admin/comments', \App\Http\Livewire\Admin\Comments::class)->name('admin-comments');

});

require __DIR__.'/auth.php';
