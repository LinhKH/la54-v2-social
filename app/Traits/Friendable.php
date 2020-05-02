<?php

namespace App\Traits;

use App\Friendship;

trait Friendable {
    public function hello() {
        return 'Hello world';
    }

    public function add_friend($user_requested_id) {
        if($this->id === $user_requested_id) {
            return 0;
        }

        if($this->is_friends_with($user_requested_id) == 1) {
            return 'already friends';
        }

        if($this->has_pending_friend_request_sent_to($user_requested_id) === 1) {
            return 'already sent a friend request';
        }
        if($this->has_pending_friend_request_from($user_requested_id) === 1) {
            $this->accept_friend($user_requested_id);
        }

        $friendship = Friendship::create([
            'requester' => $this->id,
            'user_requested' => $user_requested_id
        ]);
        
        if($friendship) {
            // return response()->json($friendship, 200);
            return 1;
        }
        // return response()->json('fail',501);
        return 0;
    }

    public function accept_friend($requester) {
        if($this->has_pending_friend_request_from($requester) === 0) {
            return 0;
        }

        $friendship = Friendship::where('requester',$requester)
                                ->where('user_requested', $this->id)
                                ->first();
        if($friendship) {
            $friendship->update([
                'status' => 1
            ]);
            return 1;
        }
        return 0;
    }

    public function friends() {
        $friends = [];
        $f1 = Friendship::where('status',1)
                        ->where('requester', $this->id)
                        ->get();
        foreach ($f1 as $friendship) {
            $friends[] = \App\User::find($friendship->user_requested);
        }
        $friends2 = [];
        $f2 = Friendship::where('status',1)
                        ->where('user_requested', $this->id)
                        ->get();
        foreach ($f2 as $friendship) {
            $friends2[] = \App\User::find($friendship->requester);
        }

        return array_merge($friends,$friends2);
    }

    public function pending_friends_requests() { // list user pending to $this->id
        $users = [];

        $pendings = Friendship::where('status',0)
                            ->where('user_requested', $this->id)
                            ->get();

        foreach ($pendings as $key => $pending) {
            $users[] = \App\User::find($pending->requester);
        }

        return $users;
    }

    public function pending_friends_requests_ids() {
        return collect($this->pending_friends_requests())->pluck('id')->toArray();
    }

    public function has_pending_friend_request_from($user_id) {
        if(in_array($user_id, $this->pending_friends_requests_ids())) {
            return 1;
        } else {
            return 0;
        }
    }

    public function pending_friends_requests_sent() {
        $users = [];
        $friendships = Friendship::where('status',0)
                        ->where('requester', $this->id)
                        ->get();
        foreach ($friendships as $friendship) {
            $users[] = \App\User::find($friendship->user_requested);
        }
        return $users;
    }

    public function pending_friends_requests_sent_ids() {
        return collect($this->pending_friends_requests_sent())->pluck('id')->toArray();
    }

    public function has_pending_friend_request_sent_to($user_id) {
        if(in_array($user_id, $this->pending_friends_requests_sent_ids())) {
            return 1;
        } else {
            return 0;
        }
    }

    public function friends_ids() {
        return collect($this->friends())->pluck('id');
    }

    public function is_friends_with($user_id) {
        if(in_array($user_id, $this->friends_ids()->toArray())) {
            return 1;
        } else {
            return 0;
        }
    }
}