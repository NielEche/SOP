@extends('layouts.app')

@section('title')
Profile Page
@endsection

@section('custom-style')
<link href="{{ asset('frontend/css/splash.css') }}" rel="stylesheet">
<link href="{{ asset('frontend/css/custom.css') }}" rel="stylesheet">
<script src="{{ asset('frontend/jquery/tabToggle.js')}}"></script>

@endsection

@section('web-content')
<h1 class="text-center">Please use a mobile device</h1>
@endsection

@section('mobile-content')
<section class="splash profile_cover" style="background-image: url({{ $user->header }})">
    @include('partials.mobile.header.header')

    <div class="container text-center text-white py-4">
        <div>
            <img src="{{ $user->avatar }}" class="avatar avatar-xl border-5" alt="{{ $user->username }}">
        </div>
        <div class="py-2">
            <h6 class="bold m-0 f-18">{{ $user->name }}</h6>
            <p class="bold">{{ $user->username }}</p>
        </div>
        <div>
            <div class="d-flex justify-content-around">
                <span class="px-2">
                    <span class="">{{ count($user->tags) }}</span>
                    <p class="m-0">Connections</p>
                </span>
                <span class="px-2 bold">
                    <span class="">{{ count($user->activities) }}</span>
                    <p class="m-0">Location</p>
                </span>
                <span class="px-2">
                    <span class="">{{ $user->followings()->count() }}</span>
                    <p class="m-0">Followers</p>
                </span>
                <span class="px-2">
                    <span class="tl-follower">{{ $user->followers()->count() }}</span>
                    <p class="m-0">Following</p>
                </span>
            </div>
            @if ($user->id != auth()->user()->id)
            <button class="text-center mt-3 btn f-12 rounded blue-btn text-white action-follow"
                data-id="{{ $user->id }}">
                <input type="hidden" class="hidden F-status" value="{{ auth()->user()->isFollowing($user) ? 1 : 0 }}">
                <strong>
                    @if(auth()->user()->isFollowing($user))
                    Following
                    @else
                    Follow
                    @endif
                </strong>
            </button>
            @endif
        </div>
    </div>
</section>

<section class="">
    <div class="container px-3 py-5">
        <p class="f-14">ROUTE HISTORY</p>
        @if ($user->activities->count())
        <div id="activityView">
            <div class="align-items-end mb-0 mt-3 f-12">
                <span class="bold text-primary" id="tab1Label">People</span>
                <span class="">|</span>
                <span class="light text-primary" id="tab2Label">Places</span>
            </div>
            <div class="py-3">
                <div class="" id="tab1">
                    <div id="activityTaggedControls" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner" role="listbox">
                           @foreach ($user->tags->chunk(12) as $tags)
                           <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                               @foreach ($tags->chunk(6) as $persons)
                               <div class="row px-2">
                                   @foreach ($persons as $person)
                                   <div class="col-2 text-center p-0 mx-0">
                                       <div class="m-1">
                                           @if ($person->person_id == null )
                                           <img src="{{ $person->avatar }}" class="avatar avatar-sm"
                                               alt="Activity Tag">
                                           <p class="f-10 mb-0 bold text-capitalize">{{ $person->name }}</p>
                                           @else
                                           <a href="{{ route('dashboard.show', $person->tagged->id) }}"
                                               class="text-primary">
                                               <img src="{{ $person->tagged->avatar }}" class="avatar avatar-sm"
                                                   alt="Activity Tag">
                                               <p class="f-10 mb-0 bold text-capitalize">
                                                   {{ $person->tagged->username }}</p>
                                           </a>
                                           @endif
                                       </div>
                                   </div>
                                   @endforeach
                               </div>
                               @endforeach
                           </div>
                           @endforeach
                        </div>

                        <ol class="carousel-indicators" style="top: 100%">
                            @foreach ($user->tags->chunk(12) as $tags)
                            <li data-target="#activityTaggedIndicators" data-slide-to="{{ $loop->index }}"
                                class="bg-blue {{ $loop->first ? 'active' : '' }}">
                            </li>
                            @endforeach
                        </ol>
                    </div>
                </div>
                <div class="hide" id="tab2">
                    <div class="row px-2">
                        @foreach($user->activities as $activity)
                        <div class="col-6 p-1">
                            <div class="bg-blue p-1 text-white text-center">
                                <a href="" class="text-white" data-toggle="modal"
                                    data-target="#tagModal-{{ $activity->id }}">
                                    <div class="d-flex">
                                        <div class="d-flex p-2">
                                            <div class="">
                                                <h1 class="date f-46 m-0">{{ $activity['start_date']->format('d') }}</h1>
                                            </div>
                                            <div class="">
                                                <h4 class="month bold f-10 m-0">{{ $activity['start_date']->format('M, Y') }}</h4>
                                                <h3 class="time light f-10 m-0 mb-2">{{ $activity['start_date']->format('H:i A') }}</h3>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="align-items-end">
                                        <p class="f-12 text-right m-0 px-2">
                                            {{ \Illuminate\Support\Str::limit($activity->to_location, 30) }}
                                        </p>
                                    </div>
                                    <img class="" src="https://maps.googleapis.com/maps/api/staticmap?size=150x100&zoom=16&center={{ $activity->to_location }}&format=png&style=feature:road.highway%7Celement:geometry%7Cvisibility:simplified%7Ccolor:0xffffff&style=feature:transit.line%7Cvisibility:simplified%7Ccolor:dfd2ae&style=feature:road.highway%7Celement:labels.text.stroke%7Cvisibility:on%7Ccolor:db8555&style=feature:road.highway%7Celement:labels.text.fill%7Cvisibility:on%7Ccolor:806b63&key={{env('GOOGLE_API_KEY')}}" alt="">
                                </a>
                            </div>
                        </div>
                        @include('activity.modals.activitySelection')
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        @else
        @if ($user->id === auth()->user()->id)
        <div class="text-center">
            <a href="{{ route('activity.create') }}" class="text-center mt-3 btn f-14 rounded blue-btn text-white">Add
                an Activity </a>
        </div>
        @endif
        @endif
    </div>
</section>

@endsection

@section('footer')
@include('partials.mobile.footer.footer')
@endsection

@section('script')

@include('activity.partials.mapScript')

<script>
    jQuery(document).ready(function ($) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('.action-follow').click(function () {
            var userID = $(this).data('id');
            var status = $('.F-status').val();
            var cObj = $(this);
            var c = $(this).parent("div").find(".tl-follower").text();

            $.ajax({
                type: 'POST',
                url: '/follow',
                data: {
                    userID: userID,
                    status: status
                },
                success: function (data) {
                    // console.log(data);
                    if (data.status == 0) {
                        cObj.find("strong").text("Follow");
                        cObj.parent("div").find(".tl-follower").text(parseInt(c) - 1);
                        $('.F-status').val(0);
                    } else {
                        cObj.find("strong").text("Following");
                        cObj.parent("div").find(".tl-follower").text(parseInt(c) + 1);
                        $('.F-status').val(1);
                    }
                }
            });
        });
    });

</script>
@endsection
