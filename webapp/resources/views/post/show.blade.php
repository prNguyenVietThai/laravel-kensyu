@extends('layouts.app')

@section('title', 'Show post')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1 class="m-0"> Show post information </h1>
            </div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item">Post</li>
                <li class="breadcrumb-item active">Show</li>
            </ol>
            </div>
        </div>
        </div>
    </div>
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <form>
                            <div class="card-body">
                            <div class="form-group">
                                <label>Title</label>
                                <p>{{ $post->title }}</p>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Content</label>
                                <p>{{ $post->description }}</p>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Tags</label>
                                <select class="select2 select2-hidden-accessible" multiple="" data-placeholder="Select tags" style="width: 100%;" name="tags[]" disabled>
                                @if(isset($tags))
                                    @foreach ($tags as $tag)
                                        @if($tag['selected'])
                                        <option data-select2-id="{{ $tag['id'] }}" value="{{ $tag['id'] }}" selected >{{ $tag['name'] }}</option>
                                        @else
                                        <option data-select2-id="{{ $tag['id'] }}" value="{{ $tag['id'] }}" >{{ $tag['name'] }}</option>
                                        @endif
                                    @endforeach
                                @endif
                                </select>
                            </div>
                            </div>

                            <div class="card-footer">
                                <a href="{{ route('home') }}" class="btn btn-default">Cancel</a>
                                @if(Auth::check() && Auth::user()->id == $post->user_id)
                                <a class="btn btn-primary" href="{{ route('editPostPage', $post->id) }}">Edit post</a>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div id="images-list" class="row" style="display: flex; flex-wrap: wrap; padding-left: 30px; justify-content: space-between">
                    @foreach($post->images as $image)
                        <div class="card">
                            @if($image->is_thumbnail)
                            <div class="ribbon-wrapper">
                                <div class="ribbon bg-warning">
                                Thumb
                                </div>
                            </div>
                            @endif
                            <img src="{{ asset('storage'.$image->url) }}" style="width: 440px; height: 280px">
                        </div>
                    @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
