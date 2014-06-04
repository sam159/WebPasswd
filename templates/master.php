<?php if(!defined("DIR_TEMPLATES")) {echo "This file cannot be accessed directly";exit();} ?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>{{$title}} | WebPasswd</title>
  <base href="{{base_href()}}"/>
  {{t GetSection('head') }}
  <link rel="stylesheet" href="assets/css/foundation.css" />
  <link rel="stylesheet" href="assets/css/main.css" />
  <script src="assets/js/vendor/modernizr.js"></script>
</head>
<body>
  <div class="row">
    <div class="small-11 large-centered columns">
      <h1>WebPasswd</h1>
      {{t Render('breadcrumb') }}
      {{t GetSection('content') }}
    </div>
  </div>

  <script src="assets/js/jquery-2.1.1.min.js"></script>
  <script src="assets/js/main.js"></script>
  <script src="assets/js/foundation.min.js"></script>
  <script>
    $(document).foundation();
  </script>
</body>
</html>