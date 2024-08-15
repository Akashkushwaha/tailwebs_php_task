<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Assessment Portal</title>
    <link rel="stylesheet" href={{ asset('css/style.css') }}>
</head>
<body>
    <header class="shadow mb-5">
        <div class="container">
            <div class="row">
                <div class="col col-4 col-sm-2 text-left">
                    <a href="{{ url("/") }}"><img src="https://tailwebs.com/wp-content/uploads/2023/03/Group-222-300x50.png" alt="Tailwebs logo" class="img-fluid"></a>
                </div>
                @auth
                <div class="col col-8 col-sm-10 text-right">
                    <form method="POST" id="logout-form" action="{{ route('logout') }}">
                        @csrf
                    </form>
                    <img src="{{ asset("images/logout-icon.png") }}" onclick="logout()" alt="Tailwebs logo" style="width: 30px;height:30px">
                </div>
                @endauth
            </div>
        </div>
    </header>
    <section class="py-5 bg-light min-h100">
        <div class="container bg-white">
            @yield("content")
        </div>
    </section>
    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
