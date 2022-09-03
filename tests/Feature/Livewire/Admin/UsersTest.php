<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\Admin\Users;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Pagination\CursorPaginator;
use Livewire\Livewire;
use Tests\TestCase;

class UsersTest extends TestCase
{	
    use RefreshDatabase;
	
    /** @test  */
    public function admin_users_page_requires_login()
    {
		// Check component can be accessed without login
        $this->get('/admin/users')->assertRedirect('/login');
    }

    /** @test  */
    public function admin_users_page_contains_users_component()
    {
        $this->actingAs(User::factory()->create());

		// Check livewire component is visible
        $this->get('/admin/users')->assertSeeLivewire('admin.users');
    }

    /** @test  */
    public function admin_users_page_contains_users_form_component()
    {
        $this->actingAs(User::factory()->create());

		// Check if new user screen loads
        Livewire::test(Users::class)
            ->call('add')
            ->assertSeeLivewire('admin.users-form');
    }

    /** @test  */
    function can_add_user()
    {
        $this->actingAs(User::factory()->create());

		// Check if new user screen loads
        Livewire::test(Users::class)
            ->call('add')
            ->assertSee('Add New User');
    }

    /** @test  */
    public function can_delete_user()
    {
        $this->actingAs(User::factory()->create());

		// Create and delete user
       	$user = User::factory()->create();
        Livewire::test(Users::class)
            ->call('delete', $user->id );

		// Check if user still exists
		$this->assertFalse(User::where('id',$user->id)->exists());
    }

    /** @test  */
    public function cant_delete_own_user()
    {
       	$user = User::factory()->create();
        $this->actingAs($user);
		
        Livewire::test(Users::class)
            ->call('delete', $user->id );

		// Check current user still exists
		$this->assertTrue(User::where('id',$user->id)->exists());
    }

    /** @test  */
    function can_edit_user()
    {
        $this->actingAs(User::factory()->create());

       	$user = User::factory()->create();

		// Check if edit user visible when user id passed at query string
        Livewire::test(Users::class)
            ->call('edit', $user->id )
            ->assertSee('Edit User');
    }

    /** @test  */
    function can_detect_user_editId_querystring()
    {
        $this->actingAs(User::factory()->create());

       	$user = User::factory()->create();

		// Check if edit user visible when user id passed at query string
        Livewire::withQueryParams(['editId' => $user->id])
            ->test(Users::class)
            ->assertSee('Edit User');
    }

    /** @test  */
    public function can_close_form()
    {
        $this->actingAs(User::factory()->create());

		// Check if new user screen loads
        Livewire::test(Users::class)
            ->call('add')
            ->assertSee('Add New User')
            ->call('close')
            ->assertSee('All Users');
    }
	
    /** @test  */
    public function pagination_visible()
    {
        $this->actingAs(User::factory()->create());
		
       	User::factory()->count(20)->create();

		// Check if pagnation can be seen
        Livewire::test(Users::class)
			->assertSee('Pagination Navigation');
    }
	
}
