<?php

namespace Tests\Unit;

use App\Post;
use App\Services\PostSerivce;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class PostTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /**
     * @var PostSerivce
     */
    private $postServices;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->postServices = PostSerivce::class;
    }

    private function fakeAuth(){
        $number = $this->faker->numberBetween(10000000, 99999999);
        $user = factory(User::class)->create([
            'password' => Hash::make($number)
        ]);
        $this->actingAs($user);
        return $user;
    }

    public function testCreateNewPostSuccess(){
        $this->fakeAuth();
        $file1 = UploadedFile::fake()->image($this->faker->text.'.png');
        $file2 = UploadedFile::fake()->image($this->faker->text.'.png');
        $images = [$file1, $file2];

        $post = $this->postServices::store([
            'title' => $this->faker->text,
            'description' => $this->faker->text,
            'tags' => [1, 2, 3],
            'thumbnail' => 0,
            'images' => $images
        ]);

        $this->assertTrue((boolean)$post);
        return $post;
    }

    public function testCreateNewPostFaileWhenUserNotAuthenticated(){
        $post = $this->postServices::store([
            'title' => $this->faker->text,
            'description' => $this->faker->text,
            'tags' => [1, 2, 3]
        ]);
        $this->assertFalse($post);
    }

    public function testShowPostSuccess(){
        // Create post to test show post function
        $this->fakeAuth();

        $post = $this->testCreateNewPostSuccess();

        // Call show post function
        $postShow = $this->postServices::getPostInformation($post->id);
        $this->assertTrue((boolean)$postShow);
    }

    public function testUpdatePostSuccess(){
        $this->fakeAuth();
        $images = [];
        $file = UploadedFile::fake()->image($this->faker->text.'.png');
        array_push($images, $file);
        $post = $this->testCreateNewPostSuccess();
        $postUpdate = $this->postServices::update([
            'title' => $this->faker->text,
            'description' => $this->faker->text,
            'tags' => [2, 3],
            'thumbnail' => 1,
            'images' => $images
        ], $post->id);
        $this->assertTrue((boolean)$postUpdate);
    }

    public function testDeletePostSuccess(){
        $this->fakeAuth();
        $post = $this->testCreateNewPostSuccess();
        $this->postServices::destroy($post->id);
        $this->assertDeleted($post);
    }

    public function testDeletePostFaileWhenUserNotCreator(){
        // User1 login success and create 1 post.
        $this->fakeAuth();
        $post = $this->testCreateNewPostSuccess();

        // User2 login success and he want to delete post of user 1
        $this->fakeAuth();
        $this->postServices::destroy($post->id);

        // User2 cannot delete post of user1, so that post have still saved in database.
        $this->assertDatabaseHas('posts', [
            'id' => $post->id
        ]);
    }
}
