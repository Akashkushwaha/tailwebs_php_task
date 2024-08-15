@extends("layouts.layout");

@section("content")
<div class="row my-5">
    <div class="col-12 col-sm-4 p-5" style="margin: 0 auto">
        @if (session()->has('error'))
            <div class="col-12 col-sm-12">
                <p class="text-danger font-weight-bolder text-decoration-underline">{{ session('error') }}</p>
            </div>
        @endif
        <h2 class="text-danger py-4">Register Now</h2>
        <form id="registration" onsubmit="check_validation(event, 1)" method="POST" action="{{route('register.post')}}">
            @csrf
            <div class="container">
                <div class="row">
                    <div class="col-12 col-sm-12 py-2">
                        <label class="font-weight-bold" for="registration_type">Register as</label>
                        <select class="input-crimson" id="registration_type" name="registration_type" style="color: #000" required>
                            <option value="" class="input-crimson" selected disabled>Select</option>
                            <option value="1">Teacher</option>
                            <option value="2" disabled>Student</option>
                        </select>
                        @if ($errors->has('registration_type'))
                            @foreach ($errors->get('registration_type') as $message)
                                <small>{{ $message }}</small><br>
                            @endforeach
                        @endif
                    </div>
                    <div class="col-12 col-sm-12">
                        <label class="font-weight-bold" for="username">Username</label>
                        <input type="text" class="input-crimson" id="username" onkeypress="return isAlphaNumeric(event)" name="username" autocomplete="off" required>
                        @if ($errors->has('username'))
                            @foreach ($errors->get('username') as $message)
                                <small>{{ $message }}</small><br>
                            @endforeach
                        @endif
                    </div>
                    <div class="col-12 col-sm-12 py-2">
                        <label class="font-weight-bold" for="email">Email</label>
                        <input type="email" class="input-crimson" id="email" name="email" autocomplete="off" required>
                        @if ($errors->has('email'))
                            @foreach ($errors->get('email') as $message)
                                <small>{{ $message }}</small><br>
                            @endforeach
                        @endif
                    </div>
                    <div class="col-12 col-sm-12">
                        <label class="font-weight-bold" for="password">Password</label>
                        <input type="password" class="input-crimson" id="password" name="password" autocomplete="off" required>
                    </div>
                    <div class="col-12 col-sm-12 py-2">
                        <button class="btn btn-crimson" type="submit" onclick="check_validation(event)">Register</button>
                    </div>
                </div>
            </div>
        </form>
        <div class="py-3">
            Already have an account? <a class="text-primary font-weight-bold" href="{{ route('login') }}">Login Here</a>
        </div>
    </div>
</div>
@endsection