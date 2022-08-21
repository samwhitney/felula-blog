<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Post;

class Blog extends Component
{
    public function render()
    {
		// Render component with paginated posts
        return view('livewire.blog', [
            'posts' => Post::orderBy('id', 'desc')->paginate(10),
        ])->layout('layouts.blog');
    }
}
