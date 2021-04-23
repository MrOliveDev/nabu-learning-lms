<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>EditorApp</title>
    <base href="/template_editor/">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" type="image/x-icon" href="{{asset('template_editor/favicon.ico')}}">
    <link rel="stylesheet" href="{{asset('template_editor/styles.css')}}">
    <script src="../assets/js/jquery.min.js"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
</head>

<body>
    <app-root></app-root>
    <script type="text/javascript" src="./runtime.js"></script>
    <script type="text/javascript" src="./polyfills.js"></script>
    <script type="text/javascript" src="./main.js"></script>
</body>

</html>
