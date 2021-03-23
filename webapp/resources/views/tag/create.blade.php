@extends('layouts.app')

@section('title', 'Create post')

@section('content')


    <div class="content-wrapper">
    <div class="content-header">
        <div class="container">
            <div class="row mb-2">
                <div class="col-sm-6">
                <h1 class="m-0"> Create new post </h1>
                </div>
                <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active">Home</li>
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
              <form action="{{ route('tag.store') }}" method="post">
                  @csrf
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
                    <label>Tag name</label>
                    <input type="text" class="form-control" placeholder="Enter tag name" name="name">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Description</label>
                    <textarea type="text" class="form-control" placeholder="Description" name="description"></textarea>
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
            </div>
            </div>

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                    <h5 class="card-title m-0">Featured</h5>
                    </div>
                    <div class="card-body">
                    <h6 class="card-title">Special title treatment</h6>

                    <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                    <a href="#" class="btn btn-primary">Go somewhere</a>
                    </div>
                </div>
            </div>
            </div>
            <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection