<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Comment;

class Comments extends Component
{
    use WithPagination;
	
    public function render()
    {
		// Render component with paginated comments
        return view('livewire.admin.comments', [
            'comments' => Comment::orderBy('id', 'desc')->paginate(10),
        ])->layout('layouts.app');
    }

	// Delete existing comment
	public function delete(int $id)
	{
		Comment::where('id',$id)->delete();
		$this->resetPage();
	}
}