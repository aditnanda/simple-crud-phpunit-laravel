<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_index()
    {
        $user = User::factory()->create(['email' => 'adit@nanda.com']);

        $response = $this->actingAs($user)->get('/posts');

        $response->assertStatus(200);
    }

    public function test_create_post()
    {
        $user = User::factory()->create(['email' => 'adit@nanda.com']);

        $response = $this->actingAs($user)->get('/posts/create');

        $response->assertStatus(200);
    }

    public function test_store_post()
    {

        $response = $this->create_data_post();


        $this->assertEquals(1, count(Post::all()));

        $response->assertRedirect('/posts');
        $response->assertStatus(302);
        $this->followRedirects($response)->assertSee('Post created successfully')->assertSee('Aditya Nanda');


    }

    public function test_visit_post()
    {

        $response = $this->create_data_post();


        $response = $this->get('/posts/1')->assertSee("Aditya Nanda")->assertSee("Buku");

        $response->assertStatus(200);


    }

    public function test_edit_post()
    {

        $this->withoutExceptionHandling();
        $response = $this->create_data_post();


        $post = Post::find(1);

        $response = $this->get('/posts/'.$post->id);

        $response->assertStatus(200);
        $response->assertSee("Aditya Nanda");


    }

    public function create_data_post(){
        $user = User::factory()->create(['email' => 'adit@nanda.com']);

        $response = $this
        ->actingAs($user)->post('/posts',[
            'title' => 'Aditya Nanda',
            'content' => 'Buku',
            'user_id' => $user->id
        ]);

        return $response;
    }

    public function test_update_post()
    {
        
        $response = $this->create_data_post();
        $post = Post::find(1);

        $response = $this->put('/posts/'.$post->id,[
            'title' => 'Aditya Nanda U',
            'content' => 'Meja'
        ]);

        $response->assertRedirect('/posts');
        $response->assertStatus(302);

        $this->followRedirects($response)->assertSee('Post updated successfully')->assertSee('Aditya Nanda U');

    }


    public function test_delete_post()
    {
        
        $response = $this->create_data_post();
        $post = Post::find(1);

        $response = $this->delete('/posts/'.$post->id);

        // $post = Post::count();
        // $this->assertEquals(0,$post);

        $this->assertModelMissing($post);

        $response->assertRedirect('/posts');
        $response->assertStatus(302);

        $this->followRedirects($response)->assertSee('Post deleted successfully');

    }
}
