@extends('layouts.app')

@section('title', 'Edit post information')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1 class="m-0"> Edit post information</h1>
            </div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item">Post</li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
            </div>
        </div>
        </div>
    </div>
    <div class="content">
        <div class="container">
            <div class="row">
                <form action="{{ route('post.update', $post->id) }}" method="post" enctype="multipart/form-data">
                @method('PATCH')
                @csrf
                <div class="col-lg-6">
                    @if (session('statusFaile'))
                        <script>
                            Swal.fire({
                            icon: 'error',
                            title: '{{ session('statusFaile') }}',
                            showConfirmButton: false,
                            timer: 1500
                            })
                        </script>
                    @elseif(session('statusSuccess'))
                        <script>
                            Swal.fire({
                            icon: 'success',
                            title: '{{ session('statusSuccess') }}',
                            showConfirmButton: false,
                            timer: 1500
                            })
                        </script>
                    @endif
                    <div class="card">
                            <div class="card-body">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <div class="form-group">
                                <label>Title</label>
                                <input type="text" class="form-control" placeholder="Enter post title" name="title" value="{{ $post->title }}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Content</label>
                                <textarea type="text" class="form-control" placeholder="Description" name="description" >{{ $post->description }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputFile">File input</label>
                                <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="exampleInputFile" name="images[]" multiple onchange="loadFile(event)">
                                    <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Tags</label>
                                <select class="select2 select2-hidden-accessible" multiple="" data-placeholder="Select tags" style="width: 100%;" name="tags[]">
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
                                <a href="{{ route('home') }}" class="btn btn-danger">Cancel</a>
                                <button type="submit" class="btn btn-primary">Edit post</button>
                            </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div id="images-list" class="row" style="display: flex; flex-wrap: wrap; padding-left: 30px; justify-content: space-between">
                    @foreach($post->images as $key => $image)
                        <div class="custom-control custom-radio">
                            @if($image->is_thumbnail)
                            <input class="custom-control-input" type="radio" id="customRadio{{ $image->id }}" name="thumbnail" value="{{ $image->id }}" checked=true>
                            @else
                            <input class="custom-control-input" type="radio" id="customRadio{{ $image->id }}" name="thumbnail" value="{{ $image->id }}">
                            @endif
                            <label for="customRadio{{ $image->id }}" class="custom-control-label">
                                <img src="{{ asset('storage'.$image->url) }}" style="width: 440px; height: 280px" class="card">
                            </label>
                        </div>
                    @endforeach
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    let loadFile = function(event) {
        let image_list = document.getElementById("images-list");
        for (let i=0; i < event.target.files.length; i++ ){
            let src = URL.createObjectURL(event.target.files[i]);
            let div = document.createElement("div");
            div.classList.add("custom-control", "custom-radio");

            let input = document.createElement("input");
            input.classList.add("custom-control-input");
            input.setAttribute("type", "radio");
            input.setAttribute("id", `customRadio${i}`);
            input.setAttribute("name", "thumbnail");
            input.value = `new${i}`;

            div.appendChild(input);

            let label = document.createElement("label");
            label.classList.add("custom-control-label");
            label.setAttribute("for", `customRadio${i}`);

            let img = document.createElement("img");
            img.src = src;
            img.style.width = "440px";
            img.style.height = "280px";
            img.classList.add("card");

            label.appendChild(img);
        
            div.appendChild(label);
            image_list.appendChild(div);
        }
    };
</script>
@endsection
