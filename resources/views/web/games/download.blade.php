@extends('layouts.default', [
    'title' => 'Download'
])

@section('css')
<style>
    body, html {
        background-color: #3C3C3C !important;
    }
    .download-page {
        color: #FFF;
        margin: 0 -30px;
    }
    .download-page .splash {
        width: 500px;
        height: 423px;
        position: absolute;
        right: 0;
        top: 0;
    }
    .download-page a.download {
        text-decoration: none;
    }
    .download-page a.download h5 {
        margin: 0;
    }
    .download-page a.download:hover button {
        cursor: pointer;
        box-shadow: 0px 2px 5px rgba(0,0,0,0.2);
    }
    .download-page .holder {
        position: relative;
    }
    .download-page .holder.legacy button.nh-button {
        border-color: #95B90B;
        background-color: rgba(0,0,0,0);
        padding: 0px 10px;
    }
    .download-page .holder.legacy {
        height: 423px;
    }
    .download-page .holder.experimental {
        background: linear-gradient(90deg, rgba(0,145,236,1) 0%, rgba(1,169,254,1) 50%, rgba(88,198,254,1) 100%);
        padding: 50px 30px;
        margin: 0 -30px;
    }
    .download-page .holder.experimental .grid {
        padding-top: 50px;
        position: relative;
        padding-bottom: 0;
    }
    .download-page .buy-button-holder {
        margin-top: 150px;
    }
    .download-page .holder.blogs {
        background: linear-gradient(180deg, rgba(36,36,38,1) 0%, rgba(19,19,21,1) 100%);
        padding: 50px 30px;
        margin: 0 -30px;
    }
    .download-page .holder.experimental .buy-button {
        position: relative;
        border-radius: 2px;
        border: none;
        background-color: #FFF;
        font-size: 2.3em;
        color: rgba(1,169,254,1);
        padding: 20px 40px;
    }
    .download-page .buy-button div {
        color: #A6A6AD;
        font-size: 15px;
        font-weight: 500;
        text-transform: initial;
    }
    .download-page .other-versions {
        padding: 15px;
        cursor: pointer;
        margin-bottom: 25px;
    }
    .download-page .workshop-brick {
        float: left;
        max-width: 100%;
        width: 350px;
        height: 218px;
    }
    .download-page .brick-text {
        padding-top: 50px;
    }
    .download-page .detailed-info {
        position: relative;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding-right: 0;
        margin: 0 8px;
        margin-bottom: 50px;
        width: calc(33.3% - 20px);
    }
    .download-page .detailed-info .bottom-text img {
        height: 100%;
        width: 100%;
    }
    .download-page .detailed-info .creator {
        font-style: italic;
        color: #CBCBD3;
        height: 0;
        overflow: hidden;
        transition: height 100ms;
    }
    .download-page .detailed-info:hover .creator {
        height: 20px;
    }
    .download-page .detailed-info .bottom-text {
        width: 100%;
        position: absolute;
        bottom: 0;
        left: 0;
        padding: 12px;
        padding-bottom: 9px;
        background-color: rgb(64 63 63 / 48%);
        color: #fff;
    }
    .download-page .tile2 {
        display: inline;
        position: absolute;
        width: 452px;
        height: 322px;
        border-radius: 2px;
        z-index: 4;
        right: -139px;
    }
    .download-page .tile4 {
        display: inline;
        position: absolute;
        border-radius: 2px;
    }

    @media handheld, only screen and (max-width: 1430px) {
        .download-page .tile2 {
            display: none;
        }
    }
    @media handheld, only screen and (max-width: 1200px) {
        .download-page .tile4 {
            position: relative;
        }
    }
    @media handheld, only screen and (max-width: 767px) {
        .download-page .tile4 {
            display: none;
        }
        .download-page .detailed-info {
            margin: 0 0 8px;
            width: calc(50% - 3px);
        }
    }
    @media handheld, only screen and (max-width: 512px) {
        .download-page .detailed-info {
            margin: 0 0 8px;
            width: 100%;
        }
        .download-page .holder.experimental .buy-button {
            font-size: 1em;
        }
    }
    @media handheld, only screen and (min-width: 1200px) {
        .download-page .tile4 {
            width: 550px;
            height: 322px;
            top: -40px;
            right: -23px;
        }
    }
</style>
@endsection

@section('js')
    <script src="{{ js_file('games/download') }}"></script>
@endsection

@section('content')
<div class="download-page">
    <div class="main-holder grid holder legacy">
        <div style="margin-bottom:10px;">
            <div class="large-text bold">LEGACY DOWNLOAD</div>
            <a href="{{ asset('downloads/BrickHillSetup.exe') }}" class="download" style="width:100%;">
                <button class="orange">
                    <h1 style="margin:0.6em 0.8em">Download</h1>
                </button>
                <div class="small-text dark-gray-text">V0.3, 13.58MB</div>
            </a>
        </div>
        <a href="https://brickhill.gitlab.io/open-source/node-hill/" class="download" style="margin-top:30px;">
            <div class="large-text bold">SERVER</div>
            <button class="nh-button">
                <h1 style="margin:0.6em 0.8em">NODE-HILL</h1>
            </button>
            <div class="small-text dark-gray-text">V11.0.3, 492KB</div>
        </a>
        <div class="splash shuttle"><img src="{{ asset('images/download/shuttle.png') }}" alt="Shuttle"></div>
    </div>
    <div class="holder experimental">
        <div class="main-holder grid">
            <div class="col-1-2">
                <div class="large-text bold">EXPERIMENTAL BUILD</div>
                If you want to try something new, the beta release of the next Brick Hill Workshop is now open to public testers!
                Keep scrolling to find out more about what's been packed into this build, or dive into it right now by paying for access below.
                <br><br>
                Rest assured; all of what you spend on beta access goes directly back into funding the development of the client and workshop.
                <br><br>
                If you can't afford beta access - don't worry! The finished game will be completely free to play in the future.
            </div>
            <div class="tile2"><img src="{{ asset('images/download/tile2.png') }}" alt="Tile"></div>
            <div class="mobile-col-1-2" style="float:none;">
                <div class="tile4"><img src="{{ asset('images/download/tile4.png') }}" alt="Tile"></div>
            </div>

            <div class="buy-button-holder">
                <button class="buy-button">
                    Get Beta Access – $5.99
                    <div>One-time payment</div>
                </button>
                <div class="other-versions">
                    <a href="https://brickhill.gitlab.io/open-source/node-hill/">Want to run your own server instead?</a>
                </div>
            </div>
        </div>
    </div>
    <div class="holder blogs">
        <div class="main-holder grid">
            <div style="margin-bottom: 125px;">
                <div class="workshop-brick"><img src="{{ asset('images/download/workshopbrk.png') }}" alt="Workshop Brick"></div>
                <div class="brick-text">
                    <div class="bold inline" style="font-size:1.7em">Workshop Tester Brick</div>
                    <div>To say thanks for helping us test the beta builds of the new client, you'll also receive the Workshop Beta Brick for your avatar!</div>
                </div>
            </div>
            <div>
                <div class="detailed-info">
                    <div class="performance-upgrades"><img src="{{ asset('images/download/performance-upgrades.png') }}" alt="Performance Upgrades"></div>
                    <div class="bottom-text">
                        <div class="medium-text bold mb2">Performance Upgrades</div>
                        <div class="small-text mb1">You'll no longer be limited by lag when building with thousands of bricks!</div>
                        <div class="creator smaller-text">stanfordlucy.brk</div>
                    </div>
                </div>
                <div class="detailed-info">
                    <div class="mats-surfaces"><img src="{{ asset('images/download/mats-surfaces.png') }}" alt="Materials and Surfaces"></div>
                    <div class="bottom-text">
                        <div class="medium-text bold mb2">Materials and Surfaces</div>
                        <div class="small-text mb1">Play around with diverse new mediums when creating your maps.</div>
                        <div class="creator smaller-text">
                            Arctic Research Complex by 
                            <a href="https://www.brick-hill.com/user/484" target="_blank">rowbot</a>
                        </div>
                    </div>
                </div>
                <div class="detailed-info">
                    <div class="intuitive-controls"><img src="{{ asset('images/download/intuitive-controls.png') }}" alt="Intuitive Controls"></div>
                    <div class="bottom-text">
                        <div class="medium-text bold mb2">Intuitive Controls</div>
                        <div class="small-text mb1">Work in a smooth workshop with controls tailored for the best experience.</div>
                        <div class="creator smaller-text">ufocrash.brk</div>
                    </div>
                </div>
                <div class="detailed-info">
                    <div class="new-envs"><img src="{{ asset('images/download/new-envs.png') }}" alt="New Environments"></div>
                    <div class="bottom-text">
                        <div class="medium-text bold mb2">New Environments</div>
                        <div class="small-text mb1">Tailor everything you make with revamped environment features!</div>
                        <div class="creator smaller-text">
                            spacebuilder's Keep by 
                            <a href="https://www.brick-hill.com/user/41209" target="_blank">Illusionism</a>
                        </div>
                    </div>
                </div>
                <div class="detailed-info">
                    <div class="dynamic-lighting"><img src="{{ asset('images/download/dynamic-lighting.png') }}" alt="Dynamic Lighting"></div>
                    <div class="bottom-text">
                        <div class="medium-text bold mb2">Dynamic Lighting</div>
                        <div class="small-text mb1">Control the aesthetic you desire with ambience and light sources.</div>
                        <div class="creator smaller-text">Mushroom Caves</div>
                    </div>
                </div>
                <div class="detailed-info">
                    <div class="ongoing-dev"><img src="{{ asset('images/download/ongoing-dev.png') }}" alt="Ongoing Development"></div>
                    <div class="bottom-text">
                        <div class="medium-text bold mb2">Ongoing Development</div>
                        <div class="small-text mb1">By becoming a tester, you'll influence how we shape the beta build's development.</div>
                        <div class="creator smaller-text">
                            Pirate Ship by 
                            <a href="https://www.brick-hill.com/user/2" target="_blank">spacebuilder</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center">
                <a href="https://blog.brick-hill.com/tag/new-client/">
                    <div>Want to stay updated? We've got you covered.</div>
                    <div>Find all blog posts related to the upcoming client's development here.</div>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
