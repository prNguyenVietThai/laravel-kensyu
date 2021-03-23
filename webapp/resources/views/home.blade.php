@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <div class="content-wrapper">
    <div class="content-header">
        <div class="container">
            <div class="row mb-2">
                <div class="col-sm-6">
                    @if(Auth::check())
                        <h1>Hello, {{ Auth::user()->name }}</h1>
                    @endif
                </div>
                <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active">Home</li>
                </ol>
                </div>
            </div>
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
        </div>
    </div>
    <div class="content">
        <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <a class="btn btn-default btn-block" href="{{ route('createPostPage') }}"><i class="fa fa-plus-circle"></i> Create new post </a>
                <br>
                @foreach ($posts as $post)
                <div class="card card-widget">
                    <div class="card-header">
                        <div class="user-block">
                            <img class="img-circle" src="/template/dist/img/user1-128x128.jpg" alt="User Image">
                            <span class="username"><a href="#">{{ $post->user->name }}</a></span>
                            <span class="description">{{ $post->created_at }}</span>
                        </div>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <p>{{ $post['title'] }}</p>
                        <i>{{ $post['description'] }}</i>
                        @foreach($post->images as $image)
                            @if($image->is_thumbnail)
                            <img class="img-fluid pad" src="{{ asset('storage'.$image->url) }}" alt="Photo">
                            @endif
                        @endforeach
                        <hr>
                        <a class="btn btn-primary btn-sm"><i class="far fa-thumbs-up"></i> Like</a>
                        <a type="button" class="btn btn-outline-secondary btn-sm" href="{{ route('showPostPage', $post['id']) }}">Read more ...</a>
                        @if(Auth::check() && $post->user_id == Auth::user()->id)
                        <a type="button" class="btn btn-outline-success btn-sm" href="{{ route('editPostPage', $post['id']) }}">Edit</a>
                        <button type="button" class="btn btn-outline-danger btn-sm" onClick="deletePost({{ $post['id'] }})">Delete</button>
                        @endif
                        <span class="float-right text-muted">127 likes - 3 comments</span>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                    <h5 class="card-title m-0">Tags</h5>
                    </div>
                    <div class="card-body">
                    @foreach ($tags as $tag)
                        <p>{{ $tag['name'] }}</p>
                    @endforeach
                    @if(Auth::check())
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-primary">
                        Create new tag
                    </button>
                    @endif
                    </div>
                </div>
            </div>
            </div>
        </div>
        </div>
    </div>
    </div>
    @if(Auth::check())
    <div class="modal fade" id="modal-primary">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('tag.store') }}" method="post">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title">Create new tag</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Tag name</label>
                            <input type="text" class="form-control" placeholder="Enter tag name" name="name">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Description</label>
                            <textarea type="text" class="form-control" placeholder="Description" name="description"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
    <script>
        function deletePost(id){
            Swal.fire({
                title: 'Do you want to delete this post?',
                icon: 'warning',
                html: `
                    <form action="/post/delete/${id}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-primary" onClick="Swal.closeModal()">No</button>
                        <button type="submit" class="btn btn-danger">Yes, delete it!</button>
                    </form>
                `,                
                showCancelButton: false,
                showConfirmButton: false
            });
        }
    </script>
@endsection
