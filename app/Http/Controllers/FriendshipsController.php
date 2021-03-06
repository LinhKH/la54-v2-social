<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use \App\User; 

class FriendshipsController extends Controller
{
    public function check($id)
    {
        if(Auth::user()->is_friends_with($id) === 1) {
            return ['status' => 'friends'];
        }

        if(Auth::user()->has_pending_friend_request_from($id) === 1) {
            return ['status' => 'pending'];
        }

        if(Auth::user()->has_pending_friend_request_sent_to($id) === 1) {
            return ['status' => 'waiting'];
        }
        return ['status' => 0];
    }

    public function add_friend($id) {
        // sending notifications, email, broadcasting.
        $resp = Auth::user()->add_friend($id);

        User::find($id)->notify( new \App\Notifications\NewFriendRequest(Auth::user()) );

        return $resp;
    }

    public function accept_friend($id) {
        // sending notifications
        $resp = Auth::user()->accept_friend($id);
        User::find($id)->notify( new \App\Notifications\FriendRequestAccepted(Auth::user()) );

        return $resp;
    }
    // <?php
        // $currentDate = "2020-05-20";
        // $d = new \DateTime($currentDate);
        // $cond = 1;
        // if($cond == 1) {
            
        //     $d->modify('first day of +1 month');
        // } else if($cond == 0) {
        //     $d->modify('first day of -1 month');
        // } else {
        //     $finalResule =  $d->format('Y-m-d');    
        // }
        // $finalResule =  $d->format('Y-m-d');


        // var_dump ($finalResule);
}
