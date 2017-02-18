<!DOCTYPE html>
<html>
<head>
    <title>{{ seo('title') }}</title>
    <meta charset=utf-8>
    <meta http-equiv=X-UA-Compatible content="IE=edge">
    <meta name=viewport content="width=device-width,initial-scale=1">
    <meta name="keywords" content="{{ seo('keywords') }}">
    <meta name="description" content="{{ seo('description') }}">
    <link href="{{ asset('assets/content/css/app.css') }}" rel="stylesheet">
</head>
<body>
<div id="app"></div>
<script>
  window.api = "{{ url('api') }}";
  window.url = "{{ url('') }}";
</script>
<script type="text/javascript" src="{{ asset('assets/content/js/manifest.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/content/js/vendor.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/content/js/app.js') }}"></script>
</body>
</html>