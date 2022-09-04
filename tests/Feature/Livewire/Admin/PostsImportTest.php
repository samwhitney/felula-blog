<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\Admin\PostsImport;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Pagination\CursorPaginator;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Tests\TestCase;

class PostsImportTest extends TestCase
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
    public function title_is_required()
    {
		// Check if title is required
        Livewire::test(PostsImport::class)
			->set('import', 
				[ 
					'data' => [
						[
							'title' => '',
							'slug' => '',
							'guid' => '',
							'content' => '',
							'enabled' => '',
							'user_id' => $this->user->id
						]
					] 
				])
			->call('fileImport')
            ->assertHasErrors(['0.title' => 'required']);
    }

    /** @test  */
    public function slug_is_required()
    {
		// Check if slug is required
        Livewire::test(PostsImport::class)
			->set('import', 
				[ 
					'data' => [
						[
							'title' => '',
							'slug' => '',
							'guid' => '',
							'content' => '',
							'enabled' => '',
							'user_id' => $this->user->id
						]
					] 
				])
			->call('fileImport')
            ->assertHasErrors(['0.slug' => 'required']);
    }

    /** @test  */
    public function slug_is_unique()
    {
		// Check if guid is unique
        Livewire::test(PostsImport::class)
			->set('import', 
				[ 
					'data' => [
						[
							'title' => '',
							'slug' => $this->post->slug,
							'guid' => '',
							'content' => '',
							'enabled' => '',
							'user_id' => $this->user->id
						]
					] 
				])
			->call('fileImport')
            ->assertHasErrors(['0.slug' => 'unique']);
    }

    /** @test  */
    public function guid_is_unique()
    {
		// Check if guid is unique
        Livewire::test(PostsImport::class)
			->set('import', 
				[ 
					'data' => [
						[
							'title' => '',
							'slug' => '',
							'guid' => $this->post->guid,
							'content' => '',
							'enabled' => '',
							'user_id' => $this->user->id
						]
					] 
				])
			->call('fileImport')
            ->assertHasErrors(['0.guid' => 'unique']);
    }

    /** @test  */
    public function content_is_required()
    {
		// Check if content is required
        Livewire::test(PostsImport::class)
			->set('import', 
				[ 
					'data' => [
						[
							'title' => '',
							'slug' => '',
							'guid' => '',
							'content' => '',
							'enabled' => '',
							'user_id' => $this->user->id
						]
					] 
				])
			->call('fileImport')
            ->assertHasErrors(['0.content' => 'required']);
    }

    /** @test  */
    public function enabled_is_boolean()
    {
		// Check if content is required
        Livewire::test(PostsImport::class)
			->set('import', 
				[ 
					'data' => [
						[
							'title' => '',
							'slug' => '',
							'guid' => '',
							'content' => '',
							'enabled' => 'test',
							'user_id' => $this->user->id
						]
					] 
				])
			->call('fileImport')
            ->assertHasErrors(['0.enabled' => 'boolean']);
    }

    /** @test  */
    public function post_imported()
    {
		$sentence = fake()->sentence();

        Livewire::test(PostsImport::class)
			->set('import', 
				[ 
					'data' => [
						[
							'title' => $sentence,
							'slug' => Str::slug($sentence),
							'guid' => Str::slug($sentence),
							'content' => fake()->paragraph(),
							'enabled' => 1,
							'user_id' => $this->user->id
						]
					] 
				])
			->call('fileImport');

		// Check if post has been imported
		$this->assertTrue(Post::where('slug',Str::slug($sentence))->exists());
    }

    /** @test  */
    public function close_form_has_emitted()
    {
		// Check if close form emit works
        Livewire::test(PostsImport::class)
            ->call('close')
			->assertEmitted('close');
    }
	
}
