<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Illuminate\Support\Facades\Validator;
use App\Models\Post;

class PostsImport extends Component
{
	public $error = false;
	public $import;

    public function render()
    {
        return view('livewire.admin.posts-import');
    }

	// Emit to parent, to refresh component data
	public function close()
	{
		$this->emitUp('close');
	}

	// Import array of posts
	public function fileImport()
	{
		// Ensure import has been set, contains data and no errors have been returned
		if(!empty($this->import) && !empty($this->import['data']) && empty($this->import['errors'])){

			$validator = Validator::make($this->import['data'], [
				'*.title' => 'required|min:6',
				'*.slug' => 'required|unique:posts',
				'*.guid' => 'unique:posts',
				'*.content' => 'required',
				'*.enabled' => 'boolean'
			])->validate();

			$upsert = [];
			foreach($this->import['data'] as $item){
				$upsert[] = [
					'title' => $item['title'],
					'slug' => $item['slug'],
					'content' => $item['content'],
					'enabled' => $item['enabled'],
					'user_id' => auth()->user()->id
				];
			}
			if(!empty($upsert)){
				Post::upsert(
					$upsert,
					['guid'],
					['title','slug','content','enabled','user_id']
				);
			}
			
			$this->close();

		} else {
			$this->error = true;
		}
	}
}
