<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Comment;

class Comments extends Component
{
	public $postId; // current post ID
	public $comments; // All comments
	public $new = [
		'name' => '',
		'email' => '',
		'comment' => ''
	]; // New comment array

	// Load up comments on component mount
	public function mount()
	{
		$this->load();
	}

    public function render()
    {
        return view('livewire.comments');
    }

	public function load()
	{
		$this->comments = Comment::select('id','name','comment','likes','created_at')->where('post_id',$this->postId)->orderBy('created_at','DESC')->get();
	}

	// Create new comment
	public function submit()
	{
		Comment::create([
			'post_id' => $this->postId,
			'name' => $this->new['name'],
			'email' => $this->new['email'],
			'comment' => $this->new['comment']
		]);

		// Reload frontend
		$this->reset('new');
		$this->load();
	}
}
