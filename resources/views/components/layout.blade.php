<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
    <meta name="robots" content="nofollow">

    <title>{{ config('app.name', 'EduHub') }}</title>

    <link rel="manifest" href="/site.webmanifest" />

    <link href="/css/font.css" rel="stylesheet" />
    <link href="/bootstrap/bootstrap.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="/jquery/jquery-3.7.1.min.js"></script>
    <script src="/bootstrap/masonry.pkgd.min.js"></script>
    <script src="/bootstrap/bootstrap.bundle.js"></script>

    <link href="/css/app.css" rel="stylesheet" />
    <script src="/js/app.js"></script>
</head>
<body>
    <div
        id="alert-container"
        class="toast-container position-absolute top-0 end-0 pt-5 p-4 d-flex justify-content-center align-items-center w-100"
        aria-live="polite"
        aria-atomic="true"
    ></div>
    <main class=" overflow-auto">
        {{ $slot }}
    </main>
</body>
<script>
    $(document).ready(function () {
        $(".toast").toast("show");
    });
</script>
</html>
