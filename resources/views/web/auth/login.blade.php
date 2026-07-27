@extends('layouts.default', [
    'title' => 'Login'
])

@section('content')
<div class="col-1-3 push-1-3">
	<div class="card">
		<div class="top green">
			Login
		</div>
		<div class="content">
			<form method="POST" action="{{ route('auth.login.authenticate') }}">
				@csrf
				<input id="username" type="username" name="username" value="{{ old('username') }}" placeholder="Username" required autofocus>
				<div style="height: 5px;"></div>
				<input style="display:block;" id="password" type="password" name="password" autocomplete="password" placeholder="Password" required>
				<a href="{{ route('auth.forgot_password.index') }}" style="font-size:15px;">Forgot password?</a>
				<div style="padding-top:5px;"></div>
				<button type="submit" class="green">
					Login
				</button>
			</form>
		</div>
	</div>
</div>
@endsection
