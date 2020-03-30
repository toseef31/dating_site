@extends('admin.layout')
@section('title')
    <title> Edit Page</title>
@endsection
@section('content')
<div  class="d-flex justify-content-between">
    <h3> Edit Page</h3>
   <a href="{{route('adminpages')}}" class="btn btn-primary">Back</a>
   </div>
<form action="{{route('updatepage', $edit->id)}}" method="post" enctype="multipart/form-data">
        {!! csrf_field() !!}
        <div class="form-group">
            <label>Title</label>
        <input class="form-control" name="title" placeholder="write your page title" value="{{ $edit->title }}">
        </div>
        <div class="form-group">
            <label>Content</label>
            <textarea rows="10" class="form-control" id="summernote" name="content">{!! $edit->content !!}</textarea>
        </div>
        <strong>SEO Optional</strong>
        <hr>
        <div class="form-group">
            <label>Keywords</label>
            <input class="form-control" name="keywords"  placeholder="keywords"  value="{{ $edit->keywords }}">
        </div>
        <div class="form-group">
            <label>Description</label>
            <input class="form-control" name="description" placeholder="write a short description"  value="{{ $edit->description }}">
        </div>
        <div class="form-group">
            <label>Picture</label>
            <input name="image" type="file" class="form-control">
        </div>
        <div class="form-group">
            <img src="{{ asset('uploads/'.$edit->image) }}" width="200" alt="avatar">
         </div>
        <div class="form-group">
            <button type="submit" class="btn btn-info">Update Page</button>
        </div>
    </form>
@endsection