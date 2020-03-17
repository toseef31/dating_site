@extends('admin.layout')
@section('title')
    <title>Pages</title>
@endsection
@section('content')
    <h3 class="clearfix">Pages<a class="btn btn-info float-right" href="{!! route('adminaddpage') !!}"><i class="fas fa-plus"></i> Add New</a></h3>
    <div class="table-responsive mt-3">
        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>Title</th>
                <th>Created At</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($pages as $page)
                <tr>
                    <td>
                        <a href="{!! route('page',['slug'=>$page->slug]) !!}">{!! $page->title !!}</a>
                    </td>
                    <td>{!! $page->created_at !!}</td>
                    <td>
                        <a class="btn btn-info btn-sm" href="{!! route('adminaddpage',['id'=>$page->id]) !!}"><i class="fas fa-edit"></i> Edit</a>
                        <a onclick="return confirm('Are you sure?')" class="btn btn-warning btn-sm" href="{!! route('admindeletepage',['id'=>$page->id]) !!}"><i class="fas fa-trash"></i> Delete</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
