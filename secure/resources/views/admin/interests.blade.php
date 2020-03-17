@extends('admin.layout')
@section('title')
    <title>Interests</title>
@endsection
@section('content')
    <h3 class="clearfix">Interests<button class="btn btn-info float-right" data-toggle="modal" data-target="#modal-add-interest"><i class="fas fa-plus"></i> Add New</button></h3>
    <div class="table-responsive mt-3">
        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>Icon</th>
                <th>Name</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($interests as $interest)
                <tr id="interest-{!! $interest->id !!}">
                    <td class="icon">
                        <i class="{!! $interest->icon !!}"></i>
                    </td>
                    <td class="name">{!! $interest->text !!}</td>
                    <td>
                        <button class="btn btn-info btn-sm edit-interest" data-toggle="modal" data-target="#modal-interest-{!! $interest->id !!}" data-id="{!! $interest->id !!}"><i class="fas fa-edit"></i> Edit</button>
                        <button class="btn btn-danger delete-interest" data-id="{!! $interest->id !!}"><i class="fas fa-trash"></i> Delete</button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    @foreach($interests as $interest)
        <div class="modal fade" id="modal-interest-{!! $interest->id !!}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Interest</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="" class="editInterest">
                            {!! csrf_field() !!}
                            <div class="form-group">
                                <label>Name</label>
                                <input name="id" value="{!! $interest->id !!}" type="hidden">
                                <input name="action" value="update_interest" type="hidden">
                                <input class="form-control" name="text" value="{!! $interest->text !!}">
                            </div>
                            <div class="form-group">
                                <label>Icon</label>
                                <input class="form-control" name="icon" value="{!! $interest->icon !!}">
                            </div>
                            <div class="form-group">
                                <button class="btn btn-success btn-block" type="submit">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    <div class="modal fade" id="modal-add-interest" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Interest</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" class="addInterest">
                        {!! csrf_field() !!}
                        <div class="form-group">
                            <label>Name</label>
                            <input name="action" value="add_interest" type="hidden">
                            <input class="form-control" name="text" value="">
                        </div>
                        <div class="form-group">
                            <label>Icon</label>
                            <input class="form-control" name="icon" value="">
                        </div>
                        <div class="form-group">
                            <button class="btn btn-success btn-block" type="submit">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
