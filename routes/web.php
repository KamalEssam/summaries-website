<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () { return redirect('/login'); });
Route::get('/home', function () { return redirect('/matches'); });

Auth::routes();
Route::resource('/matches', 'MatchController');
Route::resource('/teams', 'TeamController');
Route::resource('/leagues', 'LeagueController');
Route::resource('/channels', 'ChannelController');
Route::resource('/commentators', 'CommentatorController');
Route::get('/countries/{id}/teams', 'CountryController@teams');
Route::resource('/countries', 'CountryController');
