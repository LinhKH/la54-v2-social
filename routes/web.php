<?php


Route::get('/', function () {
    return view('welcome');
});

Route::get('/hello', function () {
    return Auth::user()->hello();
});

Route::get('/add', function () {
    return \App\User::find(1)->add_friend(3);
});

Route::get('/accept', function () {
    return \App\User::find(4)->accept_friend(1);
});

Route::get('/friends', function () {
    return \App\User::find(3)->friends();
});

Route::get('/pending_friends', function () {
    return \App\User::find(2)->pending_friends_requests();
});

Route::get('/ids', function () {
    return \App\User::find(2)->friends_ids();
});

Route::get('/is', function () {
    return \App\User::find(2)->is_friends_with(1);
});

Route::get('/check', function () {
    return \App\User::find(1)->add_friend(2);
});

Route::get('/check_relationship_status/{id}',[
    // return \App\User::find($id);
    'uses' => 'FriendshipsController@check',
    'as' => 'check'
]);



Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function () {
    Route::get('profile/{slug}', [
        'uses' => 'ProfilesController@index',
        'as' =>'profile'
    ]);
    Route::get('profile/edit/profile', [
        'uses' => 'ProfilesController@edit',
        'as' =>'profile.edit'
    ]);
    Route::post('profile/update/profile', [
        'uses' => 'ProfilesController@update',
        'as' =>'profile.update'
    ]);
});
