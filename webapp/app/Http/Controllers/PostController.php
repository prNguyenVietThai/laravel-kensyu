<?php

namespace App\Http\Controllers;

use App\Services\PostSerivce;
use App\Services\TagService;

use App\Http\Requests\PostRequest;

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
        $tags = TagService::getAll();
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
        $post = PostSerivce::store($request->toArray());
        if($post) {
            return redirect()->route('home');
        }
        return view('post.create', ['error' => 'Create post faile']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = PostSerivce::getPostInformation($id);

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
        $data = PostSerivce::getPostInformation($id);

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
        $updated = PostSerivce::update($request->toArray(), $id);
        if($updated){
            return redirect()->route('editPostPage', $id)->with('statusSuccess', 'Update post successfully');
        }
        return redirect()->route('editPostPage', $id)->with('statusFaile', 'Update post faile');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deletePost = PostSerivce::destroy($id);
        if($deletePost){
            return redirect()->route('home')->with('statusSuccess', 'Delete post successfully');
        }
        return redirect()->route('home')->with('statusFaile', 'Delete post failed');
    }
}
