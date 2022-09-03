<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\Admin\Comments;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Pagination\CursorPaginator;
use Livewire\Livewire;
use Tests\TestCase;

class AdminCommentsTest extends TestCase
{	
    use RefreshDatabase;
	
    /** @test  */
    public function admin_comments_page_requires_login()
    {
		// Check component cant be accessed without login
        $this->get(route('admin-comments'))->assertRedirect('/login');
    }

    /** @test  */
    public function admin_comments_page_contains_comments_component()
    {
        $this->actingAs(User::factory()->create());

		// Check livewire component is visible
        $this->get(route('admin-comments'))->assertSeeLivewire('admin.comments');
    }

    /** @test  */
    public function can_delete_comment()
    {
        $this->actingAs(User::factory()->hasPosts(1)->create());

		$post = Post::first();
		$post->comments()->saveMany(
			Comment::factory(5)->make()
		);
		$comment = Comment::first();

        Livewire::test(Comments::class)
			->call('delete',$comment->id);

		// Check comment has been deleted
		$this->assertFalse(Comment::where('id',$comment->id)->exists());
    }

    /** @test  */
    public function pagination_visible()
    {
        $this->actingAs(User::factory()->hasPosts(1)->create());

		$post = Post::first();
		$post->comments()->saveMany(
			Comment::factory(20)->make()
		);

		// Check if pagnation can be seen
        Livewire::test(Comments::class)
			->assertSee('Pagination Navigation');
    }

}
