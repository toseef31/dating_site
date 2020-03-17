<form action="" method="post" enctype="multipart/form-data">
    {!! csrf_field() !!}
    <input type="text" name="title">
    <input type="file" name="file">
    <input type="submit" value="submit">
</form>