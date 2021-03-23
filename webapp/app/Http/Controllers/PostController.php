<?php

namespace App\Http\Controllers;

use App\Post;
use App\Image;
use App\Tag;
use App\Http\Requests\PostRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tags = Tag::all();
        return view('post.create', ['tags' => $tags]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        DB::beginTransaction();
        try {
            $post = Post::create([
                'title' => $request->title,
                'description' => $request->description,
                'user_id' => Auth::user()->id
            ]);

            foreach($request->file('images') as $key => $image){
                $publicDir = "public/";
                $path = $request->file('images')[$key]->store('public/images');
                $path = substr($path, strlen($publicDir) - 1, strlen($path));
                $img = Image::create([
                    'url' => $path,
                    'post_id' => $post->id
                ]);
                if($key == $request->thumbnail){
                    $img->is_thumbnail = true;
                    $img->save();
                }
            }

            foreach($request->tags as $tag){
                $post->tags()->attach($tag);
            }

            DB::commit();
            return redirect()->route('home');
        } catch (\Exception $ex) {
            DB::rollback();
            return view('post.create', ['error' => $ex->getMessage()]);
        }
    }

    private function getPostInformation($id){
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

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = $this->getPostInformation($id);

        return view('post.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = $this->getPostInformation($id);

        return view('post.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request, $id)
    {
        DB::beginTransaction();
        try {

            $post = Post::find($id);
            $curTags = array_map(function($tag){
                return $tag['id'];
            }, $post->tags->toArray());

            // Update post-tag relationship
            $addTags = array_diff($request->tags, $curTags);
            foreach($addTags as $tag){
                $post->tags()->attach($tag);
            }
            $deleteTags = array_diff($curTags, $request->tags);
            $post->tags()->detach($deleteTags);

            $post->title = $request->title;
            $post->description = $request->description;
            $post->save();

            // Update post images
            if(is_numeric($request->thumbnail)){
                $thumbnail = $post->images()->where('is_thumbnail', true)->first();
                if($thumbnail->id != $request->thumbnail){
                    $thumbnail->is_thumbnail = false;
                    $thumbnail->save();
    
                    $newThumbnail = $post->images()->find($request->thumbnail);
                    $newThumbnail->is_thumbnail = true;
                    $newThumbnail->save();
                }
            }else{
                $thumbnail = $post->images()->where('is_thumbnail', true)->first();
                $thumbnail->is_thumbnail = false;
                $thumbnail->save();

                foreach($request->file('images') as $key => $image){
                    $publicDir = "public/";
                    $path = $request->file('images')[$key]->store('public/images');
                    $path = substr($path, strlen($publicDir) - 1, strlen($path));
                    $img = Image::create([
                        'url' => $path,
                        'post_id' => $post->id
                    ]);
                    $offset = substr($request->thumbnail, strlen("new"), strlen($request->thumbnail));
                    if($key == $offset){
                        $img->is_thumbnail = true;
                        $img->save();
                    }
                }
            }

            DB::commit();
            return redirect()->route('editPostPage', $id)->with('statusSuccess', 'Update post successfully');
        } catch (\Exception $ex) {
            DB::rollback();
            dd($ex);
            return redirect()->route('editPostPage', $id)->with('statusFaile', 'Update post faile');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $post = Post::find($id);
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
            return redirect()->route('home')->with('statusSuccess', 'Delete post successfully');
        } catch (\Exception $ex) {
            DB::rollback();
            return redirect()->route('home')->with('statusFaile', 'Delete post failed');
        }
    }
}
