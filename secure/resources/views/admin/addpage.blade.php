@extends('admin.layout')
@section('title')
    <title><?php echo isset($page)?'Edit':'Add New';?> Page</title>
@endsection
@section('content')
    <h3><?php echo $page?'Edit':'Add New';?> Page</h3>
    <form action="" method="post" enctype="multipart/form-data">
        {!! csrf_field() !!}
        <div class="form-group">
            <label>Title</label>
            <input class="form-control" name="title" value="{!! $page?$page->title:'' !!}">
        </div>
        <div class="form-group">
            <label>Content</label>
            <textarea rows="10" class="form-control" id="summernote" name="content">{!! $page?$page->content:'' !!}</textarea>
        </div>
        <strong>SEO Optional</strong>
        <hr>
        <div class="form-group">
            <label>Keywords</label>
            <input class="form-control" name="keywords" value="{!! $page?$page->keywords:'' !!}">
        </div>
        <div class="form-group">
            <label>Description</label>
            <input class="form-control" name="description" value="{!! $page?$page->description:'' !!}">
        </div>
        <div class="form-group">
            <label>Picture</label>
            <input name="image" type="file" class="form-control">
        </div>
        <div class="form-group">
            <button class="btn btn-info">Save Page</button>
        </div>
    </form>
@endsection