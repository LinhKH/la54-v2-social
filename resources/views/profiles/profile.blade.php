@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-lg-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <p class="text-center">{{ $user->name }}`s Profile.</p>
                </div>
                <div class="panel-body">
                    <center>
                        <img src="{{ Storage::url($user->avatar) }}" width="70px" height="70px" style="border-radius:50%" alt="">
                    </center>
                    <br>
                    <p class="text-center">
                        {{ ($user->profile) ? $user->profile->location : null }}
                    </p>
                    <div class="text-center">
                        @if (Auth::id() == $user->id)
                            <a href="{{ route('profile.edit') }}" class="btn btn-lg btn-info">Edit your profile</a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <p class="text-center">Friends</p>
                </div>
                <div class="panel-body">
                    <friend :profile_user_id="{{ $user->id }}"></friend>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <p class="text-center">About me.</p>
                </div>
                <div class="panel-body">
                    {{ ($user->profile) ? $user->profile->about : null }}
                </div>
            </div>
        </div>
    </div>
@endsection