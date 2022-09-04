<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\Admin\PostsForm;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Pagination\CursorPaginator;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Tests\TestCase;

class PostsFormTest extends TestCase
{	
    use RefreshDatabase;

    protected $user;
    protected $post;

	/** @Before each test */
    protected function setUp(): void
    {
   		parent::setUp();

		// Build user
       	$this->user = User::factory()->hasPosts(1)->create();
        $this->actingAs($this->user);

		// Build post
		$this->post = Post::first();
    }

    /** @test  */
    public function populated_edit_fields()
    {
		// Check if fields are populated when editing
        Livewire::test(PostsForm::class, ['postId' => $this->post->id])
            ->assertSet('post.title', $this->post->title)
			->assertSet('post.slug', $this->post->slug)
			->assertSet('post.image', $this->post->image)
			->assertSet('post.content', $this->post->content)
			->assertSet('post.enabled', $this->post->enabled);
    }

    /** @test  */
    public function can_create_post()
    {
		$sentence = fake()->sentence();

		// Create post
        Livewire::test(PostsForm::class)
			->set('post', [
				'title' => $sentence,
				'slug' => Str::slug($sentence),
				'guid' => Str::slug($sentence),
				'image' => '',
				'content' => fake()->paragraph(),
				'enabled' => 1,
				'user_id' => $this->user->id
			])
			->call('submit');

		$this->assertTrue(Post::whereTitle($sentence)->exists());
    }

    /** @test  */
    public function title_is_required()
    { 
		// Test when title is missing
        Livewire::test(PostsForm::class)
			->call('submit')
            ->assertHasErrors(['post.title' => 'required']);
    }

    /** @test  */
    public function slug_is_required()
    { 
		// Test when slug is missing
        Livewire::test(PostsForm::class)
			->call('submit')
            ->assertHasErrors(['post.slug' => 'required']);
    }

    /** @test  */
    public function slug_is_unique()
    { 
		// Test when slug is not unique
        Livewire::test(PostsForm::class)
			->set('post.slug', $this->post->slug)
			->call('submit')
            ->assertHasErrors(['post.slug' => 'unique']);
    }

    /** @test  */
    public function image_is_optional()
    { 
		// Test when image is not set
        Livewire::test(PostsForm::class)
			->call('submit')
            ->assertHasNoErrors(['post.image']);
    }

    /** @test  */
    public function content_is_required()
    { 
		// Test when content is missing
        Livewire::test(PostsForm::class)
			->call('submit')
            ->assertHasErrors(['post.content' => 'required']);
    }

    /** @test  */
    public function close_form_has_emitted()
    {
		// Check if close form emit works
        Livewire::test(PostsForm::class)
            ->call('close')
			->assertEmitted('close');
    }
	
}
