@extends('layouts.default', [
    'title' => 'Maintenance'
])

@section('content')
@if(!Auth::check())
    <div class="alert error">
        You can't win the aeo roll unless you login
    </div>
@endif
@if($won)
    <div class="alert success">
        You won the aeo roll!! Your account has been granted the Jackpot award.
    </div>
@endif
<div style="text-align:center;padding-top:50px;">
    <span style="font-weight:600;font-size:3rem;display:block;">Brick Hill is currently under maintenance.</span>
    <span style="font-weight:500;font-size:2rem;">Please try again soon.</span>
    <div style="font-size:2rem;"><a href="https://discord.gg/brick-hill">Join us on Discord at discord.gg/brick-hill</a></div>
    <div style="text-align:center;margin:20px;">
        @foreach($rands as $rand)
            <img style="width:20%;" src="{{ $rand }}">
        @endforeach
    </div>
    <form action="{{ route('maintenance.authenticate') }}" method="POST" style="margin-top:20px;">
        @csrf
        <input type="password" name="key" placeholder="Maintenance Key">
        <div style="padding:2.5px;"></div>
        <button type="submit" class="blue">SUBMIT</button>
    </form>
</div>
@endsection
