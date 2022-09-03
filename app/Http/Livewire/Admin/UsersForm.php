<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class UsersForm extends Component
{
	public $userId;
    public $name;
    public $email;

	// Enforce validation rules
    protected function rules()
    {
		 // Email must be unique, but add exception for current user being edited to prevent failure on updating name field
        return [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$this->userId
        ];
    }

	public function mount()
	{
		if(!empty($this->userId) && $user = User::find($this->userId)){
			$this->name = $user->name;
			$this->email = $user->email;
		}
	}

    public function render()
    {
        return view('livewire.admin.users-form');
    }

	// Emit to parent, to refresh component data
	public function close()
	{
		$this->emitUp('close');
	}

	// Submit form to edit/create user
    public function submit()
    {
        $this->validate();

		if(isset($this->userId)){
			// Edit existing user
			$user = User::find($this->userId);
			$user->name = $this->name;
			$user->email = $this->email;
			$user->save();
		} else {
			// Create new user
			User::create([
				'name' => $this->name,
				'email' => $this->email,
				'password' => Hash::make(Str::random(10))
			]);
		}

		// Emit change to parent, to refresh component data
		$this->close();

    }
}
