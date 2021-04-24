<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>EditorApp</title>
    <base href="{{asset('template_editor')}}">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <link rel="stylesheet" href="template_editor/styles.css">
    <script src="template_editor/assets/js/jquery.min.js"></script>
    <script>
    // console.log
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
</head>

<body>
    <app-root></app-root>
    <script type="text/javascript" src="template_editor/runtime.js"></script>
    <script type="text/javascript" src="template_editor/polyfills.js"></script>
    <script type="text/javascript" src="template_editor/main.js"></script>
</body>

</html>
