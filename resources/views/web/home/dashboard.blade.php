@extends('layouts.default', [
    'title' => 'Dashboard'
])

@section('css')
<style>
.dashboard .col-3-10 {
    float: left;
    min-height: 1px;
    padding-right: 20px;
    width: 30%;
}

.dashboard .col-8-12 {
    float: left;
    min-height: 1px;
    padding-right: 0;
    width: 70%;
}

.dashboard .flex {
    display: flex;
}

.dashboard .flex-column {
    flex-direction: column;
}

.dashboard .flex-items-center {
    align-items: center;
}

.dashboard .flex-horiz-center {
    justify-content: center;
}

.dashboard .status {
    position: relative;
    min-height: 80px;
}

.dashboard .status img {
    width: 64px;
    height: 64px;
    float: left;
    margin-right: 10px;
    object-fit: cover;
}

.dashboard .dashboard-info {
    width: 100%;
    justify-content: center;
    margin-bottom: 10px;
}

.dashboard .dashboard-info .streak-info p {
    margin: 0;
    margin-right: 10px;
}

.dashboard .dashboard-info .administrator {
    margin-top: 5px;
}

.dashboard .status-dashboard {
    margin: auto;
    margin-left: 5px;
    width: 9px;
    height: 9px;
}

.dashboard .avatar-thumbnail {
    width: 50px;
}

.dashboard .post-button {
    width: 150px;
}

.dashboard .post-input {
    height: 92px;
    width: 100%;
    resize: vertical;
}

.dashboard .no-shadow {
    box-shadow: none;
}

.dashboard .no-rounded {
    border-radius: 0;
}

.dashboard .no-margin {
    margin: 0;
}

.dashboard .vmargin-6 {
    margin-top: 6px;
    margin-bottom: 6px;
}

.dashboard .space-between {
    justify-content: space-between;
}

.dashboard .dash-info {
    width: auto;
}

.dashboard .value-svg {
    margin-top: 5px;
}

.dashboard .blogcard {
    margin-bottom: 10px;
}

.dashboard .blogcard .content {
    padding: 10px;
}

.dashboard .ml-5 {
    margin-left: 5px;
}

.dashboard .ml-20 {
    margin-left: 20px;
}

.dashboard .mr-5 {
    margin-right: 5px;
}

.dashboard .mr-10 {
    margin-right: 10px;
}

.dashboard .mr-20 {
    margin-right: 20px;
}

.dashboard .mb-10 {
    margin-bottom: 10px;
}

.dashboard .mb-12 {
    margin-bottom: 12px;
}

.dashboard .mb-16 {
    margin-bottom: 16px;
}

.dashboard .svg-black {
    color: #111;
}

@media handheld, only screen and (max-width: 767px) {
    .dashboard .col-3-10,
    .dashboard .col-8-12 {
        width: auto;
        float: none;
        padding-right: 0;
    }
}
</style>
@endsection

@section('content')
@if(request()->has('paymentCompleted'))
<div class="alert success">Thank you for your purchase! Please allow 24 hours for the purchase to process.</div>
@endif
@if(request()->has('clientCompleted'))
<div class="alert success">Thank you for purchasing client access! You can now download the installer on the downloads page.</div>
@endif

<div class="new-theme dashboard">
    <div class="col-3-10">
        <div class="card border-bottom no-rounded no-shadow">
            <div class="content rounded center-text">
                <img class="avatar-thumbnail" src="{{ auth()->user()->thumbnail() }}" style="width:100%;">
                @if(auth()->user()->hasPrimaryClan())
                    <a href="/clans/{{ auth()->user()->primary_clan_id }}"><span class="bold medium-text light-text">[{{ auth()->user()->primaryClan->tag }}]</span></a>
                @endif
                <span style="margin: 5px;" class="bold medium-text">{{ auth()->user()->username }}</span>
                <div class="dashboard-info flex flex-column flex-items-center">
                    <div class="flex dash-info vmargin-6">
                        <div class="flex streak-info dash-info ml-20 mr-10 flex-items-center">
                            <span class="very-bold mr-10">VALUE</span>
                            @if($value)
                                <p class="smedium-text mr-20" title="{{ $value->value }}">{{ shorten_number($value->value) }}</p>
                            @else
                                <p class="smedium-text mr-20">{{ 0 }}</p>
                            @endif
                        </div>
                    </div>

                    @if(auth()->user()->isStaff())
                    <span class="very-bold red-text administrator small-text mb-10">ADMINISTRATOR</span>
                    @endif
                </div>
            </div>
        </div>

        <div>
            <div class="flex flex-items-center flex-horiz-center">
                <p class="very-bold smedium-text mr-10">{{ $friend_count }}</p>
                <p class="bold small-text gray-text">{{ \Illuminate\Support\Str::plural('FRIEND', $friend_count) }}</p>
            </div>
        </div>
        
        <div class="card no-rounded no-shadow">
            <div class="content">
                @foreach($friends as $friend)
                <div class="status">
                    <a href="/user/{{ $friend->id }}">
                        <img src="{{ $friend->thumbnail() }}">
                    </a>
                    <div class="ellipsis ml-5">
                        <div class="mb-12 smedium-text relative ellipsis flex">
                            <span href="/user/{{ $friend->id }}" class="ellipsis">{{ $friend->username }} </span>
                            <span class="status-dot status-dashboard @if($friend->online())online @endif"></span>
                        </div>
                        <a class="mb-12 bold small-text very-bold" href="/message/{{ $friend->id }}/send">MESSAGE</a>
                    </div>
                </div>
                @endforeach
                @if($friend_count > 0)
                <a class="small-text bold" href="/user/{{ auth()->user()->id }}/friends">VIEW ALL</a>
                @endif
            </div>
        </div>
    </div>
    <div class="col-8-12">
        <div class="card blogcard no-shadow no-rounded">
            <div class="content">
                <div class="smedium-text mb-16 bold">
                    News
                </div>
                @forelse($updates as $update)
                <div class="border-bottom mb-12">
                    <a href="{{ route('forum.thread', $update->id) }}" class="very-bold dark-gray-text block ellipsis">{{ $update->title }}</a>
                    <div class="gray-text small-text">by <b>{{ $update->creator->username }}</b></div>
                    <span class="bold light-gray-text status-time" title="{{ $update->created_at->diffForHumans() }}">{{ $update->created_at->format('d/m/Y h:i A') }}</span>
                </div>
                @empty
                <p class="gray-text">No news found.</p>
                @endforelse
            </div>
        </div>
        <div class="card border-bottom no-shadow no-rounded">
            <div class="content">
                <div class="smedium-text mb-16 bold">
                    What's New?
                </div>
                <div>
                    <form style="width:100%;" class="pb3" method="POST" action="{{ route('home.status') }}">
                        @csrf
                        <div class="flex flex-column">
                            <textarea class="post-input border mb-16" name="message" placeholder="Right now I'm..." type="text"></textarea>
                            <button class="post-button button small smaller-text blue">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="card no-shadow">
            <div class="content">
                <div class="smedium-text mb-16 bold">
                    Your Feed
                </div>
                <div>
                    @if(count($feed) == 0)
                        <p class="gray-text">Your feed is empty! Follow some users to fill this area.</p>
                    @endif

                    @foreach($feed as $status)
                    @if(!empty($status->body))
                    <div class="status border-bottom mb-12 flex">
                        <a href="/user/{{ $status->owner_id }}">
                            <img src="{{ $status->user->thumbnail() }}">
                        </a>
                        <div class="ml-5 mb-10">
                            <div class="flex">
                                <a href="/user/{{ $status->owner_id }}" class="very-bold mr-5">{{ $status->user->username }} </a>
                                <span class="mr-5">&middot;</span>
                                <span class="dark-gray-text mb-12 small-text" title="{{ Carbon\Carbon::parse($status->date)->format('d/m/Y h:i A') }}">{{ Carbon\Carbon::parse($status->date)->diffForHumans() }}</span>
                            </div>
                            <div>{{ $status->body }}</div>
                        </div>
                    </div>
                    @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
