<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\Blog;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Pagination\CursorPaginator;
use Livewire\Livewire;
use Tests\TestCase;

class BlogTest extends TestCase
{	
    use RefreshDatabase;

    /** @test  */
    public function home_page_contains_blog_component()
    {
		// Check livewire component is visible
        $this->get('/')->assertSeeLivewire('blog');
    }

    /** @test  */
    public function the_component_can_render()
    {
        $component = Livewire::test(Blog::class);
        $component->assertStatus(200);
    }

    /*
	 * @test - Removed, as test failing when running artisan test, but passing when running individually
    public function pagination_visible()
    {
		$user = User::factory()->create();
		$user->posts()->saveMany(
			Post::factory(20)->make()
		);

        Livewire::test(Blog::class)
			->call('render')
			->assertSee('Pagination Navigation');
    }
	*/
}
