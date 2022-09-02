<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Comment;
use App\Models\Post;

class Comments extends Component
{
	public $postId; // current post ID
	public $comments; // All comments
	public $new = [
		'name' => '',
		'email' => '',
		'comment' => ''
	]; // New comment array

	// Enforce validation rules
    protected function rules()
    {
        return [
            'new.name' => 'required|min:3',
            'new.email' => 'required|email',
            'new.comment' => 'required|min:10'
        ];
    }

	// Set user friendly names for attributes
    protected $validationAttributes = [
        'new.name' => 'name',
        'new.email' => 'email',
        'new.comment' => 'comment',
    ];

	// Load up comments on component mount
	public function mount()
	{
		$this->load();
	}

    public function render()
    {
        return view('livewire.comments');
    }

	// Load comments from db
	public function load()
	{
		$this->comments = Comment::select('id','name','comment','likes','created_at')->where('post_id',$this->postId)->orderBy('created_at','DESC')->get();
	}

	// Create new comment
	public function submit()
	{
        $this->validate();

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
