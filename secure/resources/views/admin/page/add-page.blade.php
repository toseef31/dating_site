@extends('admin.layout')
@section('title')
    <title> Add New Page</title>
@endsection
@section('content')
   <div  class="d-flex justify-content-between">
    <h3> Add New Page</h3>
   <a href="{{route('adminpages')}}" class="btn btn-primary">Back</a>
   </div>
<form action="{{route('adminaddpage')}}" method="post" enctype="multipart/form-data">
        {!! csrf_field() !!}
        <div class="form-group">
            <label>Title</label>
            <input class="form-control" name="title" placeholder="write your page title">
        </div>
        <div class="form-group">
            <label>Content</label>
            <textarea rows="10" class="form-control" id="summernote" name="content"></textarea>
        </div>
        <strong>SEO Optional</strong>
        <hr>
        <div class="form-group">
            <label>Keywords</label>
            <input class="form-control" name="keywords"  placeholder="keywords">
        </div>
        <div class="form-group">
            <label>Description</label>
            <input class="form-control" name="description" placeholder="write a short description">
        </div>
        <div class="form-group">
            <label>Picture</label>
            <input name="image" type="file" class="form-control">
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-info">Save Page</button>
        </div>
    </form>
@endsection