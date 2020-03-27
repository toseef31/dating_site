<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
<meta name="csrf_token" content="{!! csrf_token() !!}">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<!--<link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="{!! url('assets/css/bootstrap.min.css') !!}">
<link rel="stylesheet" type="text/css" href="{!! url('assets/css/fontawesome.min.css') !!}">
<link rel="stylesheet" type="text/css" href="{!! url('assets/css/cropper.min.css') !!}">
<link rel="stylesheet" type="text/css" href="{!! url('assets/css/datepicker.min.css') !!}">
<link rel="stylesheet" type="text/css" href="{!! url('assets/css/jquery.fancybox.min.css') !!}">
<link rel="stylesheet" type="text/css" href="{!! url('assets/css/jquery.mcustomscrollbar.css') !!}">
<link rel="stylesheet" type="text/css" href="{!! url('assets/css/app.css') !!}">
<script src="{!! url('node_modules/socket.io-client/dist/socket.io.js') !!}"></script>
<script src="{!! url('assets/js/jquery.min.js') !!}"></script>
<script src="{!! url('assets/js/popper.min.js') !!}"></script>
<script src="{!! url('assets/js/bootstrap.min.js') !!}"></script>
<script src="{!! url('assets/js/jquery.fancybox.min.js') !!}"></script>
<script src="{!! url('assets/js/datepicker.min.js') !!}"></script>
<script src="{!! url('assets/js/jquery.form.min.js') !!}"></script>
<script src="{!! url('assets/js/jquery.mcustomscrollbar.min.js') !!}"></script>
<script src="//media.twiliocdn.com/sdk/js/video/v1/twilio-video.min.js"></script>
<script src="{!! url('assets/js/cropper.min.js') !!}"></script>-->
 <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="http://localhost/dating/assets/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="http://localhost/dating/assets/css/cropper.min.css">
<link rel="stylesheet" type="text/css" href="http://localhost/dating/assets/css/fontawesome.min.css">
<link rel="stylesheet" type="text/css" href="http://localhost/dating/assets/css/datepicker.min.css">
<link rel="stylesheet" type="text/css" href="http://localhost/dating/assets/css/jquery.fancybox.min.css">
<link rel="stylesheet" type="text/css" href="http://localhost/dating/assets/css/jquery.mcustomscrollbar.css">
<link rel="stylesheet" type="text/css" href="http://localhost/dating/assets/css/app.css">
<script src="http://localhost/dating/node_modules/socket.io-client/dist/socket.io.js"></script>
<script src="http://localhost/dating/assets/js/jquery.min.js"></script>
<script src="http://localhost/dating/assets/js/popper.min.js"></script>
<script src="http://localhost/dating/assets/js/bootstrap.min.js"></script>
<script src="http://localhost/dating/assets/js/jquery.fancybox.min.js"></script>
<script src="http://localhost/dating/assets/js/datepicker.min.js"></script>
<script src="http://localhost/dating/assets/js/jquery.form.min.js"></script>
<script src="http://localhost/dating/assets/js/jquery.mcustomscrollbar.min.js"></script>
<script src="//media.twiliocdn.com/sdk/js/video/v1/twilio-video.min.js"></script>
<script src="http://localhost/dating/assets/js/cropper.min.js"></script>
<?php
$seo_website_title = setting('website_title');
$seo_website_description = setting('website_description');
$seo_website_tagline = setting('website_tagline');
$seo_website_keywords = setting('website_keywords');
$seo_social_image = setting('social_image');
$seo_website_type = 'website';
?>
<title>{!! isset($seo_title) ? $seo_title.' - '.$seo_website_title : $seo_website_title !!}</title>
<meta name="keywords" content="{!! isset($seo_keywords) ? $seo_keywords.','.$seo_website_keywords : $seo_website_keywords !!}">
<meta name="description" content="{!! isset($seo_description) ? $seo_description.','.$seo_website_description : $seo_website_description !!}">
<meta property="og:title" content="{!! isset($seo_title) ? $seo_title.' - '.$seo_website_title : $seo_website_title !!}">
<meta property="og:type" content="{!! isset($seo_type) ? $seo_type: $seo_website_type !!}">
<meta property="og:url" content="{!! request()->url !!}">
<meta property="og:image" content="{!! isset($seo_image) ? $seo_image : url($seo_social_image) !!}">
<meta property="og:site_name" content="{!! $seo_website_tagline !!}">
<meta property="og:description" content="{!! isset($seo_description) ? $seo_description.','.$seo_website_description : $seo_website_description !!}">
<div class="hidden-md hidden-lg hidden-xs hidden-sm">

   <nav class="mean-nav">


   </nav>

</div>
