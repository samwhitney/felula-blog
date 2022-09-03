<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\Admin\UsersForm;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Pagination\CursorPaginator;
use Livewire\Livewire;
use Tests\TestCase;

class UsersFormTest extends TestCase
{	
    use RefreshDatabase;
	
    protected $user;

	/** @Before each test */
    protected function setUp(): void
    {
   		parent::setUp();

		// Build user
       	$this->user = User::factory()->create();
        $this->actingAs($this->user);
    }

    /** @test  */
    public function populated_edit_fields()
    {
		// Create user and check if fields are populated when editing
       	$user = User::factory()->create();
        Livewire::test(UsersForm::class, ['userId' => $user->id])
			->assertSet('name', $user->name)
			->assertSet('email', $user->email);
    }

    /** @test  */
    public function can_edit_self()
    {
		// Can edit existing user
        Livewire::test(UsersForm::class, ['userId' => $this->user->id])
			->set('name', 'test user')
			->call('submit');

		$this->assertTrue(User::whereName('test user')->exists());
    }

    /** @test  */
    public function name_is_required()
    { 
		// Test when name is missing
        Livewire::test(UsersForm::class)
			->set('email', 'test@example.com')
			->call('submit')
            ->assertHasErrors(['name' => 'required']);
    }

    /** @test  */
    public function email_is_required()
    {
		// Test when email is missing
        Livewire::test(UsersForm::class)
			->set('name', 'test user')
			->call('submit')
            ->assertHasErrors(['email' => 'required']);
    }

    /** @test  */
    public function email_is_email_address()
    {
		// Test when email is not an email address
        Livewire::test(UsersForm::class)
			->set('name', 'test user')
			->set('email', '123.com')
			->call('submit')
            ->assertHasErrors(['email' => 'email']);
    }

    /** @test  */
    public function email_is_unique()
    {
		// Test adding duplicate user
        Livewire::test(UsersForm::class)
			->set('name', $this->user->name)
			->set('email', $this->user->email)
			->call('submit')
            ->assertHasErrors(['email' => 'unique']);
    }

    /** @test  */
    public function close_form_has_emitted()
    {
		// Check if close form emit works
        Livewire::test(UsersForm::class)
            ->call('close')
			->assertEmitted('close');
    }
	
}
