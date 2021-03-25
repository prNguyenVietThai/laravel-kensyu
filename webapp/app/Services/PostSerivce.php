<?php

namespace App\Services;
use App\Post;
use App\Image;
use App\Tag;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PostSerivce {
    public static function store(array $data){
        DB::beginTransaction();
        try {
            $post = Post::create([
                'title' => $data['title'],
                'description' => $data['description'],
                'user_id' => Auth::user()->id
            ]);

            if(isset($data['images'])){
                foreach($data['images'] as $key => $image){
                    $publicDir = "public/";
                    $path = $data['images'][$key]->store('public/images');
                    $path = substr($path, strlen($publicDir) - 1, strlen($path));
                    $img = Image::create([
                        'url' => $path,
                        'post_id' => $post->id
                    ]);
                    if($key == $data['thumbnail']){
                        $img->is_thumbnail = true;
                        $img->save();
                    }
                }
            }

            if(isset($data['tags'])){
                foreach($data['tags'] as $tag){
                    $post->tags()->attach($tag);
                }
            }

            DB::commit();
            return $post;
        } catch (\Exception $ex) {
            DB::rollback();
            return false;
        }
    }

    public static function getPostInformation(int $id){
        $post = Post::find($id);
        $postTags = $post->tags->toArray();
        $postTags = array_map(function($t){ return $t['id']; }, $postTags);

        $tags = Tag::all()->toArray();
        foreach($tags as $key => $value){
            if(is_numeric(array_search($value['id'], $postTags))){
                $tags[$key]['selected'] = true;
            }else{
                $tags[$key]['selected'] = false;
            }
        }

        return [
            'post' => $post,
            'tags' => $tags
        ];
    }

    public static function update(array $data, int $id){
        DB::beginTransaction();
        try {

            $post = Post::find($id);
            $curTags = array_map(function($tag){
                return $tag['id'];
            }, $post->tags->toArray());

            // Update post-tag relationship
            $addTags = array_diff($data['tags'], $curTags);
            foreach($addTags as $tag){
                $post->tags()->attach($tag);
            }
            $deleteTags = array_diff($curTags, $data['tags']);
            $post->tags()->detach($deleteTags);

            $post->title = $data['title'];
            $post->description = $data['description'];
            $post->save();

            // Update post images
            if(is_numeric($data['thumbnail'])){
                $thumbnail = $post->images()->where('is_thumbnail', true)->first();
                if($thumbnail->id != $data['thumbnail']){
                    $thumbnail->is_thumbnail = false;
                    $thumbnail->save();

                    $newThumbnail = $post->images()->find($data['thumbnail']);

                    $newThumbnail->is_thumbnail = true;
                    $newThumbnail->save();
                }
            }else{
                $thumbnail = $post->images()->where('is_thumbnail', true)->first();
                $thumbnail->is_thumbnail = false;
                $thumbnail->save();

                foreach($data['images'] as $key => $image){
                    $publicDir = "public/";
                    $path = $data['images'][$key]->store('public/images');
                    $path = substr($path, strlen($publicDir) - 1, strlen($path));
                    $img = Image::create([
                        'url' => $path,
                        'post_id' => $post->id
                    ]);
                    $offset = substr($data['thumbnail'], strlen("new"), strlen($data['thumbnail']));
                    if($key == $offset){
                        $img->is_thumbnail = true;
                        $img->save();
                    }
                }
            }

            DB::commit();
            return $post;
        } catch (\Exception $ex) {
            DB::rollback();
            return false;
        }
    }

    public static function destroy(int $id){
        DB::beginTransaction();
        try {
            $post = Post::find($id);
            if($post->user_id != Auth::user()->id){
                throw new \Exception('Permission denied');
            }

            $images = $post->images->toArray();
            $images = array_map(function($img){
                return 'public' . $img['url'];
            }, $images);

            // 1. Delete post - tag relationship
            $post->tags()->detach();

            // 2. Delete post and image in database
            Post::where('id', $id)->first()->delete();

            // 3. Delete images of post in storage
            Storage::delete($images);

            DB::commit();
            return true;
        } catch (\Exception $ex) {
            DB::rollback();
            return false;
        }
    }
}

