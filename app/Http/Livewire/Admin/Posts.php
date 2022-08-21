<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Post;
use App\Jobs\RssReader;

class Posts extends Component
{
    use WithPagination;

	public $editId; // Edited post ID
	public $view; // Control views

	// Listen for close event, to trigger resetting the component
    protected $listeners = ['close'];

	// Monitor query string change, so back button works when editing a post
    protected $queryString = ['editId'];

	// On mount check if post ID has been provided
    public function mount()
    {
		if(!empty($this->editId)){
			$this->view = 'form';
		}
	}

    public function render()
    {
		// Render component with paginated posts
        return view('livewire.admin.posts', [
            'posts' => Post::orderBy('id', 'desc')->paginate(10),
        ])->layout('layouts.app');
    }

	// Add new post
	public function add()
	{
		// Reset editId to ensure the livewire component refreshes between add/edit
		$this->reset('editId');
		$this->view = 'form';
	}

	// Edit existing post
	public function edit(int $id)
	{
		$this->editId = $id;
		$this->view = 'form';
	}

	// Delete existing post
	public function delete(int $id)
	{
		Post::where('id',$id)->delete();
		$this->resetPage();
	}

	// Trigger reload when close event has fired
    public function close()
    {
		$this->reset('editId');
		$this->reset('view');
		$this->resetPage();
    }

	// Option to run RSS import manually from admin
	public function rss()
	{
		RssReader::dispatch();
	}

}