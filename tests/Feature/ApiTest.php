<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class ApiTest extends TestCase
{
    use RefreshDatabase;

    protected $post;
    protected $user;

	/** @Before each test */
    protected function setUp(): void
    {
   		parent::setUp();

		// Build user and create example post
       	$this->user = User::factory()->hasPosts(20)->create();

		// Fetch first post into protected property
		$this->post = Post::first();
    }

    /** @test */
    public function can_fetch_posts()
    {
        $response = $this->get('/api/posts');
        $response->assertStatus(200);
    }

    /** @test */
    public function can_fetch_post()
    {
        $response = $this->get('/api/posts/'.$this->post->id);
        $response->assertStatus(200);
    }

    /** @test */
    public function can_create_post()
    {
		$sentence = fake()->sentence();

        $postData = [
			'title' => $sentence,
			'slug' => Str::slug($sentence),
			'guid' => Str::slug($sentence),
			'content' => fake()->paragraph(),
			'enabled' => 1,
			'user_id' => $this->user->id
		];

        $this->json('POST', 'api/posts', $postData, ['Accept' => 'application/json'])
            ->assertStatus(201);

    }

    /** @test */
    public function create_title_is_required()
    {
        $postData = [
			'title' => '',
			'slug' => '',
			'guid' => '',
			'content' => '',
			'enabled' => '',
			'user_id' => ''
		];

        $this->json('POST', 'api/posts', $postData, ['Accept' => 'application/json'])
            ->assertJson([
                "errors" => [
                    "title" => ["The title field is required."]
                ]
            ]);
    }

    /** @test */
    public function create_slug_is_required()
    {
        $postData = [
			'title' => '',
			'slug' => '',
			'guid' => '',
			'content' => '',
			'enabled' => '',
			'user_id' => ''
		];

        $this->json('POST', 'api/posts', $postData, ['Accept' => 'application/json'])
            ->assertJson([
                "errors" => [
                    "slug" => ["The slug field is required."]
                ]
            ]);
    }

    /** @test */
    public function create_slug_is_unique()
    {
        $postData = [
			'title' => '',
			'slug' => $this->post->slug,
			'guid' => '',
			'content' => '',
			'enabled' => '',
			'user_id' => ''
		];

        $this->json('POST', 'api/posts', $postData, ['Accept' => 'application/json'])
            ->assertJson([
                "errors" => [
                    "slug" => ["The slug has already been taken."]
                ]
            ]);
    }

    /** @test */
    public function create_guid_is_required()
    {
        $postData = [
			'title' => '',
			'slug' => '',
			'guid' => '',
			'content' => '',
			'enabled' => '',
			'user_id' => ''
		];

        $this->json('POST', 'api/posts', $postData, ['Accept' => 'application/json'])
            ->assertJson([
                "errors" => [
                    "guid" => ["The guid field is required."]
                ]
            ]);
    }

    /** @test */
    public function create_guid_is_unique()
    {
        $postData = [
			'title' => '',
			'slug' => '',
			'guid' => $this->post->guid,
			'content' => '',
			'enabled' => '',
			'user_id' => ''
		];

        $this->json('POST', 'api/posts', $postData, ['Accept' => 'application/json'])
            ->assertJson([
                "errors" => [
                    "guid" => ["The guid has already been taken."]
                ]
            ]);
    }

    /** @test */
    public function create_content_is_required()
    {
        $postData = [
			'title' => '',
			'slug' => '',
			'guid' => '',
			'content' => '',
			'enabled' => '',
			'user_id' => ''
		];

        $this->json('POST', 'api/posts', $postData, ['Accept' => 'application/json'])
            ->assertJson([
                "errors" => [
                    "content" => ["The content field is required."]
                ]
            ]);
    }

    /** @test */
    public function create_enabled_is_boolean()
    {
        $postData = [
			'title' => '',
			'slug' => '',
			'guid' => '',
			'content' => '',
			'enabled' => 'test',
			'user_id' => ''
		];

        $this->json('POST', 'api/posts', $postData, ['Accept' => 'application/json'])
            ->assertJson([
                "errors" => [
                    "enabled" => ["The enabled field must be true or false."]
                ]
            ]);
    }

    /** @test */
    public function create_user_id_is_required()
    {
        $postData = [
			'title' => '',
			'slug' => '',
			'guid' => '',
			'content' => '',
			'enabled' => '',
			'user_id' => ''
		];

        $this->json('POST', 'api/posts', $postData, ['Accept' => 'application/json'])
            ->assertJson([
                "errors" => [
                    "user_id" => ["The user id field is required."]
                ]
            ]);
    }

    /** @test */
    public function update_title_is_required()
    {
        $postData = [
			'title' => '',
			'slug' => '',
			'guid' => '',
			'content' => '',
			'enabled' => '',
			'user_id' => ''
		];

        $this->json('PUT', 'api/posts/'.$this->post->id, $postData, ['Accept' => 'application/json'])
            ->assertJson([
                "errors" => [
                    "title" => ["The title field is required."]
                ]
            ]);
    }

    /** @test */
    public function update_slug_is_required()
    {
        $postData = [
			'title' => '',
			'slug' => '',
			'guid' => '',
			'content' => '',
			'enabled' => '',
			'user_id' => ''
		];

        $this->json('PUT', 'api/posts/'.$this->post->id, $postData, ['Accept' => 'application/json'])
            ->assertJson([
                "errors" => [
                    "slug" => ["The slug field is required."]
                ]
            ]);
    }

    /** @test */
    public function update_slug_is_unique()
    {
		$selected = Post::where('id', '!=',$this->post->id)->first();

        $postData = [
			'title' => '',
			'slug' => $this->post->slug,
			'guid' => '',
			'content' => '',
			'enabled' => '',
			'user_id' => ''
		];

        $this->json('PUT', 'api/posts/'.$selected->id, $postData, ['Accept' => 'application/json'])
            ->assertJson([
                "errors" => [
                    "slug" => ["The slug has already been taken."]
                ]
            ]);
    }

    /** @test */
    public function update_guid_is_required()
    {
        $postData = [
			'title' => '',
			'slug' => '',
			'guid' => '',
			'content' => '',
			'enabled' => '',
			'user_id' => ''
		];

        $this->json('PUT', 'api/posts/'.$this->post->id, $postData, ['Accept' => 'application/json'])
            ->assertJson([
                "errors" => [
                    "guid" => ["The guid field is required."]
                ]
            ]);
    }

    /** @test */
    public function update_guid_is_unique()
    {
		$selected = Post::where('id', '!=',$this->post->id)->first();

        $postData = [
			'title' => '',
			'slug' => '',
			'guid' => $this->post->guid,
			'content' => '',
			'enabled' => '',
			'user_id' => ''
		];

        $this->json('PUT', 'api/posts/'.$selected->id, $postData, ['Accept' => 'application/json'])
            ->assertJson([
                "errors" => [
                    "guid" => ["The guid has already been taken."]
                ]
            ]);
    }

    /** @test */
    public function update_content_is_required()
    {
        $postData = [
			'title' => '',
			'slug' => '',
			'guid' => '',
			'content' => '',
			'enabled' => '',
			'user_id' => ''
		];

        $this->json('PUT', 'api/posts/'.$this->post->id, $postData, ['Accept' => 'application/json'])
            ->assertJson([
                "errors" => [
                    "content" => ["The content field is required."]
                ]
            ]);
    }

    /** @test */
    public function update_enabled_is_boolean()
    {
        $postData = [
			'title' => '',
			'slug' => '',
			'guid' => '',
			'content' => '',
			'enabled' => 'test',
			'user_id' => ''
		];

        $this->json('PUT', 'api/posts/'.$this->post->id, $postData, ['Accept' => 'application/json'])
            ->assertJson([
                "errors" => [
                    "enabled" => ["The enabled field must be true or false."]
                ]
            ]);
    }

    /** @test  */
    public function can_delete_post()
    {
        $this->json('DELETE', 'api/posts/'.$this->post->id, ['Accept' => 'application/json']);

		// Check comment has been deleted
		$this->assertFalse(Post::where('id',$this->post->id)->exists());
    }

}