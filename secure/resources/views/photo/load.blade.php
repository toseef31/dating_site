@foreach($photos as $photo)
    <div class="col-md-3">
        <div data-id="{!! $photo->id !!}" data-url="{!! url($photo->file) !!}" class="photo-item view-photo border shadow" style="background-image: url('{!! url($photo->thumb) !!}')">
        </div>
    </div>
@endforeach
