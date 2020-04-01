<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="{!! url('assets/css/bootstrap.min.css') !!}">
    <link rel="stylesheet" type="text/css" href="{!! url('assets/css/admin.css') !!}">
    <!-- <link rel="stylesheet" type="text/css" href="http://localhost/dating/assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="http://localhost/dating/assets/css/admin.css"> -->
    <title>Login</title>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-5 mx-auto">
            <div class="card mt-5">
                <div class="card-header">Login</div>
                <div class="card-body">
                    <form action="" method="post">
                        {!! csrf_field() !!}
                        <div class="form-group">
                            <label>Email</label>
                            <input class="form-control" name="email" type="email">
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input class="form-control" name="password" type="password">
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary btn-block" type="submit">Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
