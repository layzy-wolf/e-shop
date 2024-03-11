<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{env('APP_NAME')}}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
            crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
            integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
</head>
<body>
<div class="wrapper d-flex">
    <aside class="d-flex flex-column flex-shrink-0 p-3 bg-body-tertiary vh-100" style="width: 280px;">
        <div
            class="d-flex align-items-center mb-3 mb-md-0 link-body-emphasis text-decoration-none">
            <span class="fs-4">Admin</span>
        </div>
        <hr>
        <ul class="nav nav-pills flex-column mb-auto">
            <li class="nav-item">
                <a href="{{route("admin.users")}}" class="nav-link
                    @if (\Illuminate\Support\Facades\Request::url() == route("admin.users")) active @endif"
                   aria-current="page">
                    Пользователи
                </a>
            </li>
            <li class="nav-item">
                <a href="{{route("admin.categories")}}"
                   class="nav-link @if (\Illuminate\Support\Facades\Request::url() == route("admin.categories")) active @endif">
                    Категории
                </a>
            </li>
            <li>
                <a href="{{route("admin.products")}}"
                   class="nav-link @if (\Illuminate\Support\Facades\Request::url() == route("admin.products")) active @endif">
                    Продукты
                </a>
            </li>
            <li>
                <a href="{{route("admin.orders")}}"
                   class="nav-link @if (\Illuminate\Support\Facades\Request::url() == route("admin.orders")) active @endif">
                    Заказы
                </a>
            </li>
        </ul>
        <hr>
        <div class="d-flex justify-content-between">
            <strong>{{\Illuminate\Support\Facades\Auth::user()->name ?? ""}}</strong>
            <a href="/logout" class="text-decoration-none">выйти</a>
        </div>
    </aside>
    @yield("content")
</div>
@yield("script")
</body>
</html>
