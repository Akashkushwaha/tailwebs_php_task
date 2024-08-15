@extends("layouts.layout");

@section("content")
<div class="row my-5">
    <div class="col-12 col-sm-4 p-5" style="margin: 0 auto">
        @if (session()->has('success'))
            <div class="col-12 col-sm-12">
                <p class="text-success font-weight-bolder text-decoration-underline">{{ session('success') }}</p>
            </div>
        @endif
        @if (session()->has('error'))
            <div class="col-12 col-sm-12">
                <p class="text-danger font-weight-bolder text-decoration-underline">{{ session('error') }}</p>
            </div>
        @endif
        <h2 class="text-danger py-4">Teacher's Login</h2>
        <form id="registration" onsubmit="check_validation(event, 2)" method="POST" action="{{route('login.post')}}">
            @csrf
            <div class="container">
                <div class="row">
                    <div class="col-12 col-sm-12 py-2">
                        <label class="font-weight-bold" for="email">Email</label>
                        <input class="input-crimson" type="email" id="email" name="email" autocomplete="off" required>
                        @if ($errors->has('email'))
                            @foreach ($errors->get('email') as $message)
                                <small>{{ $message }}</small><br>
                            @endforeach
                        @endif
                    </div>
                    <div class="col-12 col-sm-12">
                        <label class="font-weight-bold" for="password">Password</label>
                        <input class="input-crimson" type="password" id="password" name="password" autocomplete="off" required>
                    </div>
                    <div class="col-12 col-sm-12 py-2">
                        <button class="btn btn-crimson" type="submit" onclick="check_validation(event)">Login</button>
                    </div>
                </div>
            </div>
        </form>
        <div class="py-3">
            Need an account? <a class="text-primary font-weight-bold" href="{{ route('register') }}">Register Now</a>
        </div>
    </div>
</div>
@endsection