<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>EditorApp</title>
    <base href="/template_editor/">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" type="image/x-icon" href="public/template_editor/favicon.ico">
    <link rel="stylesheet" href="public/template_editor/styles.css">
</head>

<body>
    <app-root></app-root>
    <script type="text/javascript" src="public/template_editor/runtime.js"></script>
    <script type="text/javascript" src="public/template_editor/polyfills.js"></script>
    <script type="text/javascript" src="public/template_editor/main.js"></script>
</body>

</html>
