@extends('layouts.default', [
    'title' => 'Register'
])

@section('css')
<style>
    h3 {
        margin: 2px 0;
    }
    h6 {
        margin: 2px 0;
        font-size: 12px;
    }
    input:not([type="radio"]) {
        display: block;
        margin-bottom: 5px;
    }
    .genders {
        margin-bottom: 5px;
    }
    input[type="radio" i] {
        margin: 3px 3px 0 0;
    }
    label {
        margin-right: 5px;
    }
</style>
@endsection

@section('js')
@if (config('app.env') === 'production' && site_setting('registration_enabled'))
    {!! NoCaptcha::renderJs() !!}
@endif
<script>
    var password = $('#password');
    var passconf = $('#password_confirmation');
    var username = $('#username');

    password.on('change', confPassword);
    passconf.on('keyup', confPassword);
    username.on('change', trimUsername);

    function confPassword() {
        if(password.val() !== passconf.val()) {
            passconf[0].setCustomValidity('Passwords do not match.');
        } else {
            passconf[0].setCustomValidity('');
        }
    }

    function trimUsername() {
        if(username.val() !== username.val().trim()) {
            username[0].setCustomValidity('Username cannot have spaces at the beginning or end.');
        } else {
            username[0].setCustomValidity('');
        }
    }
</script>
@endsection

@section('content')
<div class="col-10-12 push-1-12">
    <div class="card">
        <div class="top blue">
            Register
        </div>
        <div class="content">
            @if (!site_setting('registration_enabled'))
                <span>Account creation is currently disabled.</span>
            @else
                <div class="col-8-12">
                    <form method="POST" action="{{ route('auth.register.authenticate') }}">
                        @csrf
                        <h3 class="dark-gray-text">Username</h3>
                        <h6 class="light-gray-text">How will people recognize you?</h6>
                        <input id="username" type="username" name="username" value="{{ old('username') }}" placeholder="Username" required autofocus>
                        <h3 class="dark-gray-text">Password</h3>
                        <h6 class="light-gray-text">Only you will know this!</h6>
                        <input id="password" minlength="6" type="password" name="password" placeholder="Password" value="{{ old('password') }}" required>
                        <input id="password_confirmation" type="password" name="password_confirmation" placeholder="Confirm Password" value="{{ old('password_confirmation') }}" required>
                        <h3 class="dark-gray-text">Email</h3>
                        <h6 class="light-gray-text">This must be valid so we can contact you!</h6>
                        <input id="email" type="email" name="email" placeholder="Email (optional)" value="{{ old('email') }}">
                        @if (config('app.env') === 'production')
                            <div class="col-1-1" style="margin-top:5px;">
                                {!! NoCaptcha::display() !!}
                            </div>
                        @endif
                        <div class="col-1-1">
                            <div style="padding-top:5px;"></div>
                            <button type="submit" class="blue">
                                Register
                            </button>
                        </div>
                        <div class="col-1-1">
                            <span class="gray-text" style="font-size:14px;">By signing up to {{ config('site.name') }}, you confirm that you have read and agree to the <a class="dark-gray-text bold" href="{{ route('info.terms') }}" target="_blank">Terms of Service</a>, as well as our <a class="dark-gray-text bold" href="{{ route('info.privacy') }}" target="_blank">Privacy Policy</a>.</span>
                        </div>
                    </form>
                </div>
                <div class="col-4-12" style="position:relative;min-height:310px;">
                    <div class="col-12-12" style="position:absolute;top:5px;right:5px;">
                        <div style="border-radius:5px;border:1px solid #D9D9D9;padding:5px;">
                            <h3 class="dark-gray-text">Already have an account?</h3>
                            <span class="light-gray-text" style="font-size:15px;">If you've forgotten your password go to <a class="dark-gray-text bold" href="{{ route('auth.forgot_password.index') }}">forgot password</a>.<br><br>To login, go to <a class="dark-gray-text bold" href="{{ route('auth.login.index') }}">login</a>.<br><br>Can't play? Go to <a class="dark-gray-text bold" href="{{ route('games.download') }}">download</a> and install the client!</span>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
