@extends('user.layouts.app')
@section('content')
<div class="row mt-5">
    <div class="col-lg-3">
        <ul class="list-group">
            <li class="list-group-item active" aria-current="true">All Posts</li>
        </ul>
    </div>
    <div class="col-lg-8">
        @auth
        <div class="div">
            <div class="card">
                <div class="card-header bg-secondary text-white">
                    <h4>Create a blog post for user.</h4>
                </div>

                <div class="card-body">
                    <form action="{{ route('post') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Titile</label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" id="exampleInputEmail1" aria-describedby="emailHelp">
                            @error('title')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Author</label>
                            <input type="text" name="author" class="form-control @error('author') is-invalid @enderror" id="exampleInputPassword1">
                            @error('author')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        </div>

                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Content</label>
                            <textarea name="content" id="" cols="30" rows="10" class="form-control @error('content') is-invalid @enderror"></textarea>
                            @error('content')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        </div>
                        
                        <input type="submit" class="btn btn-primary" value="Submit">
                    </form>
                </div>
            </div>
        </div>
        @else

        <h3>Please Login to access this page !</h3>
       
        @endauth
        
    </div>
</div>
@endsection

@section('scripts')
@endsection

