<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>{{$translation->l('EditorApp')}}</title>
    <base href="/assets/editorApp/">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <app-root></app-root>
    <script type="text/javascript" src="runtime.js"></script>
    <script type="text/javascript" src="polyfills.js"></script>
    <script type="text/javascript" src="main.js"></script>
</body>

</html>
