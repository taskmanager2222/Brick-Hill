@extends('layouts.default')

@section('css')
<style>
body {
    background-color: #222226;
}

.landing-banner {
    text-align: center;
    background-image: url('{{ asset('images/landing/banner.png') }}');
    background-size: cover;
    background-position: 80%;
    padding: 20px 0 20px 0;
    margin-bottom: 40px;
    margin-top: -20px;
    width: 100%;
}

.landing-banner .landing-image-top {
    width: 60%;
    height: 175px;
    margin-top: 10px;
}

.landing-banner .title {
    font-size: 16px;
    width: 100%;
    margin-top: 20px;
}

.landing-banner .shadow {
    text-shadow: 0px 2px 2px rgba(0, 0, 0, 0.6);
}

.landing-content-section {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 60px;
    width: 100%;
    color: #fff;
}

.section-content-image {
    height: 100%;
    width: 100%;
}

.section-content-right {
    margin-left: 60px;
}

.section-image {
    width: 100%;
    border-radius: 4px;
}

.landing-image-top {
    content: url('{{ asset('images/landing/logo.svg') }}');
}

.workshop {
    content: url('{{ asset('images/landing/workshop.png') }}');
}

.sandcastle {
    content: url('{{ asset('images/landing/sandcastle.png') }}');
}

@media screen and (max-width: 767px) {
    .landing-content-section {
        flex-direction: column-reverse;
        width: 90%;
        margin: auto;
    }

    .section-image {
        width: 80%;
        margin: auto;
    }

    .section-content-left,
    .section-content-right {
        margin: auto;
        text-align: center;
        margin-top: 20px;
    }
}
</style>
@endsection

@section('before_content')
<div class="new-theme landing-banner index-top-bar">
    <img class="landing-image-top" />
    <p class="title shadow white-text"> A growing community of {{ shorten_number($totalUsers) }} users with a focus on creativity and collaboration. </p>
    <a href="/register">
        <button class="button blue no-overflow">REGISTER NOW</button>
    </a>
    <p class="landing-subtext shadow white-text">
         OR <a class="landing-subtext" href="/login">LOG IN</a>
    </p>
</div>
@endsection

@section('content')
<div class="landing-content-section">
    <div class="section-content-left">
        <h1 class="section-content-title">BUILDING A COMMUNITY</h1>
        <p class="section-content-text">Bringing people from all over the world together to create, collaborate, and play together built on values that put the player first. Join our community and help shape its future and your place in it!</p>
    </div>
    <div class="section-content-right section-image">
        <img class="section-image sandcastle">
    </div>
</div>
<div class="landing-content-section" style="margin-bottom: 60px;">
    <div class="section-content-left section-image">
        <img class="section-image workshop">
    </div>
    <div class="section-content-right">
        <h1 class="section-content-title">A RISING PLATFORM</h1>
        <p class="section-content-text">The biggest up-and-coming platform fueled by its community and a commitment to provide the best quality for free. We're constantly pushing out new updates, new features, and growing our audience using creative and talented minds who believe in our platform.</p>
    </div>
</div>
@endsection
