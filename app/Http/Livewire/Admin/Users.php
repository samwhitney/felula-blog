<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;

class Users extends Component
{
    use WithPagination;

	public $editId; // Edited user ID
    public $view; // Control views

	// Listen for close event, to trigger resetting the component
    protected $listeners = ['close'];
	
	// Monitor query string change, so back button works when editing a user
    protected $queryString = ['editId'];

	// On mount check if user ID has been provided
    public function mount()
    {
		if(!empty($this->editId)){
			$this->view = 'form';
		}
	}

	// Render the view
    public function render()
    {
		// Render component with paginated posts
        return view('livewire.admin.users', [
            'users' => User::orderBy('id', 'desc')->paginate(10),
        ])->layout('layouts.app');
    }

	// Add new user
	public function add()
	{
		// Reset editId to ensure the livewire component refreshes between add/edit
		$this->reset('editId');
		$this->view = 'form';
	}

	// Edit existing user
	public function edit(int $id)
	{
		$this->editId = $id;
		$this->view = 'form';
	}

	// Delete existing user
	public function delete(int $id)
	{
		if($id != auth()->user()->id && $user = User::find($id)){
			$user->delete();
			$this->resetPage();
		}
	}

	// Trigger reload when close event has fired
    public function close()
    {
		$this->reset('editId');
		$this->reset('view');
		$this->resetPage();
    }

}
