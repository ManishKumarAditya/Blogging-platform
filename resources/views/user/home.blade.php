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
                    <form action="" method="POST">
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Titile</label>
                            <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Author</label>
                            <input type="text" class="form-control" id="exampleInputPassword1">
                        </div>

                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Content</label>
                            <textarea name="" id="" cols="30" rows="10" class="form-control"></textarea>
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

