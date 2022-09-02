<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\Comments;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Pagination\CursorPaginator;
use Livewire\Livewire;
use Tests\TestCase;

class CommentsTest extends TestCase
{	
    use RefreshDatabase;

    protected $post;

	/** @Before each test */
    protected function setUp(): void
    {
   		parent::setUp();

		// Build user and create example post
       	$user = User::factory()->hasPosts(1)->create();

		// Fetch first post into protected property
		$this->post = Post::first();
    }

    /** @test  */
    public function article_page_contains_comments_component()
    {
		// Check livewire component is visible
        $this->get('/article/'.$this->post->slug)->assertSeeLivewire('comments');
    }

    /** @test  */
    public function the_component_can_render()
    {
		// Check livewire component renders
        $component = Livewire::test(Comments::class);
        $component->assertStatus(200);
    }

    /** @test  */
    public function can_create_comment()
    {
		// Test comment submission
        Livewire::test(Comments::class)
			->set('postId', $this->post->id)
            ->set('new', ['name' => 'Test User', 'email' => 'test@example.com', 'comment' => 'Hello World!'])
            ->call('submit');
		
		$this->assertTrue(Comment::whereComment('Hello World!')->exists());
    }

    /** @test  */
    public function can_see_created_comment()
    {
		// Test comment submission
        Livewire::test(Comments::class)
			->set('postId', $this->post->id)
            ->set('new', ['name' => 'Test User', 'email' => 'test@example.com', 'comment' => 'Hello World!'])
            ->call('submit')
			->assertSee('Hello World!');
    }

    /** @test  */
    public function name_is_required()
    { 
		// Test when name is missing
        Livewire::test(Comments::class)
			->set('postId', $this->post->id)
            ->set('new', ['email' => 'test@example.com', 'comment' => 'Hello World'])
            ->call('submit')
            ->assertHasErrors(['new.name' => 'required']);
    }

    /** @test  */
    public function email_is_required()
    {
		// Test when email is missing
        Livewire::test(Comments::class)
			->set('postId', $this->post->id)
            ->set('new', ['name' => 'Test User', 'comment' => 'Hello World'])
            ->call('submit')
            ->assertHasErrors(['new.email' => 'required']);
    }

    /** @test  */
    public function email_is_email_address()
    {
		// Test when email is not an email address
        Livewire::test(Comments::class)
			->set('postId', $this->post->id)
            ->set('new', ['name' => 'Test User', 'email' => 'example.com', 'comment' => 'Hello World'])
            ->call('submit')
            ->assertHasErrors(['new.email' => 'email']);
    }

    /** @test  */
    public function comment_is_required()
    {
		// Test when comment is missing
        Livewire::test(Comments::class)
			->set('postId', $this->post->id)
            ->set('new', ['name' => 'Test User', 'email' => 'test@example.com'])
            ->call('submit')
            ->assertHasErrors(['new.comment' => 'required']);
    }

}
