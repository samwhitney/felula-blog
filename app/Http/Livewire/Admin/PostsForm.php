<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;
use App\Models\Post;

class PostsForm extends Component
{
    use WithFileUploads;

	public $postId; // Current post ID, if editing
	public $post = [
		'title' => '',
		'slug' => '',
		'image' => '',
		'content' => '',
		'enabled' => true
	]; // Post array

	// Enforce validation rules
    protected function rules()
    {
        return [
            'post.title' => 'required|min:6',
            'post.slug' => 'required|unique:posts,slug,'.$this->postId,
            'post.image' => 'nullable|image|max:1024',
            'post.content' => 'required',
			'post.enabled' => 'boolean'
        ];
    }
	
	public function mount()
	{
		// If postId supplied, populate form with existing post details
		if(!empty($this->postId) && $post = Post::find($this->postId)){
			$this->post = [
				'title' => $post['title'],
				'slug' => $post['slug'],
				'image' => $post['image'],
				'content' => $post['content'],
				'enabled' => $post['enabled']
			];
		}
	}

    public function render()
    {
        return view('livewire.admin.posts-form');
    }

	public function close()
	{
		$this->emitUp('close');
	}

	// Submit form to edit/create post
    public function submit()
    {
		$this->validate();

		// If postId has been supplied, fetch existing post
		if(isset($this->postId)){
			$post = Post::find($this->postId);
		}

		$imageUrl = null;
		// Store image and get URL
		if(!empty($this->post['image'])){
			if( (isset($this->postId) && $post->image != $this->post['image']) || (!isset($this->postId)) ){
       			$imageUrl = str_replace("public","",$this->post['image']->storePublicly('public/images'));
			}
		}

		if(isset($this->postId)){
			// Edit existing post
			$post->title = $this->post['title'];
			$post->slug = $this->post['slug'];
			if($post->image != $imageUrl){
				$post->image = $imageUrl;
			}
			$post->content = $this->post['content'];
			$post->enabled = $this->post['enabled'];
			$post->save();
		} else {
			// Create new post
			Post::create([
				'title' => $this->post['title'],
				'slug' => $this->post['slug'],
				'image' => $imageUrl,
				'content' => $this->post['content'],
				'enabled' => $this->post['enabled'],
				'user_id' => auth()->user()->id
			]);
		}

		// Emit change to parent, to refresh component data
		$this->close();

    }

	// If title entered and slug is empty, generate a slug value for the post
	public function setSlug()
	{
		if(empty($this->post['slug'])){
			$this->post['slug'] = Str::slug($this->post['title']);
		}
	}

	// Remove image from post
	public function removeImage()
	{
		$this->post['image'] = '';
	}
}
