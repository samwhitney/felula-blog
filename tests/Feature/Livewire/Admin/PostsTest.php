<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\Admin\Posts;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Pagination\CursorPaginator;
use Livewire\Livewire;
use Tests\TestCase;

class PostsTest extends TestCase
{	
    use RefreshDatabase;
	
    /** @test  */
    public function admin_posts_page_requires_login()
    {
		// Check component can be accessed without login
        $this->get(route('admin-posts'))->assertRedirect('/login');
    }

    /** @test  */
    public function admin_posts_page_contains_posts_component()
    {
        $this->actingAs(User::factory()->create());

		// Check livewire posts component is visible
        $this->get(route('admin-posts'))->assertSeeLivewire('admin.posts');
    }

    /** @test  */
    public function admin_posts_page_contains_posts_form_component()
    {
        $this->actingAs(User::factory()->create());

		// Check livewire posts form component is visible
        Livewire::test(Posts::class)
            ->call('add')
            ->assertSeeLivewire('admin.posts-form');
    }

    /** @test  */
    public function admin_posts_page_contains_posts_import_component()
    {
        $this->actingAs(User::factory()->create());

		// Check livewire posts import component is visible
        Livewire::test(Posts::class)
            ->set('view','import')
            ->assertSeeLivewire('admin.posts-import');
    }

    /** @test  */
    function can_see_add_post()
    {
        $this->actingAs(User::factory()->create());

		// Check if new post screen loads
        Livewire::test(Posts::class)
            ->call('add')
            ->assertSee('Add New Post');
    }

    /** @test  */
    public function can_delete_post()
    {
        $this->actingAs(User::factory()->hasPosts(5)->create());

		// Delete post
		$post = Post::first();
        Livewire::test(Posts::class)
            ->call('delete', $post->id );

		// Check if post still exists
		$this->assertFalse(Post::where('id',$post->id)->exists());
    }

    /** @test  */
    function can_see_edit_post()
    {
        $this->actingAs(User::factory()->hasPosts(5)->create());
		$post = Post::first();

		// Check if edit post visible
        Livewire::test(Posts::class)
            ->call('edit', $post->id )
            ->assertSee('Edit Post');
    }

    /** @test  */
    function can_detect_user_editId_querystring()
    {
        $this->actingAs(User::factory()->hasPosts(5)->create());
		$post = Post::first();

		// Check if edit post visible when post id passed at query string
        Livewire::withQueryParams(['editId' => $post->id])
            ->test(Posts::class)
            ->assertSee('Edit Post');
    }

    /** @test  */
    public function can_see_import_post()
    {
        $this->actingAs(User::factory()->create());

		// Check if import post screen loads
        Livewire::test(Posts::class)
            ->set('view','import')
            ->assertSee('Import CSV File');
    }

    /** @test  */
    public function can_rss_import_post()
    {
        $this->actingAs(User::factory()->create());

        Livewire::test(Posts::class)
            ->call('rss');

		// Check if posts have been created
		$this->assertTrue(Post::exists());
		
    }

    /** @test  */
    public function can_close_form()
    {
        $this->actingAs(User::factory()->hasPosts(5)->create());
		$post = Post::first();

		// Check if form closes
        Livewire::test(Posts::class)
            ->call('add')
            ->assertSee('Add New Post')
            ->call('close')
            ->assertSee('All Posts');
    }
	
    /** @test  */
    public function pagination_visible()
    {
        $this->actingAs(User::factory()->hasPosts(20)->create());

		// Check if pagnation can be seen
        Livewire::test(Posts::class)
			->assertSee('Pagination Navigation');
    }
	
}
