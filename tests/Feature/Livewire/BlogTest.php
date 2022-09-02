<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\Blog;
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

    /** @test  */
    public function pagination_visible()
    {
		// Build user and create example posts
       	User::factory()->hasPosts(20)->create();

		// Check if pagnation can be seen
        Livewire::test(Blog::class)
			->assertSee('Pagination Navigation');
    }
}
