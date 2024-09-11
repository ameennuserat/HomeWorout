<?php

use Illuminate\Http\Request;
//use App\Http\Middleware\checkadmin;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CatgptController;
use App\Http\Controllers\SocialController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CommerceController;
use App\Http\Controllers\TraineesController;
use App\Http\Controllers\ChallengeController;
use App\Http\Controllers\CodeCheckController;
use App\Http\Controllers\CreatePlanController;
use App\Http\Controllers\CompetitionController;
use App\Http\Controllers\BodybuildingController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\WebNotificationController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('checkcode', 'checkcode');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
    Route::get('me', 'me');


    //profile api
    Route::get('getprofile',[ProfileController::class,'getprofile']);
    Route::post('updateweight',[ProfileController::class,'updateweight']);
    Route::post('updatetargetweight',[ProfileController::class,'updatetargetweight']);
    Route::post('updateage',[ProfileController::class,'updateage']);
    Route::post('addphoto',[ProfileController::class,'addphoto']);
    //  plan

    Route::get('/displayplan', [CreatePlanController::class, 'displayplan']);
    Route::get('/showallextoadd', [CreatePlanController::class, 'showallextoadd']);
    Route::get('/showallextochange', [CreatePlanController::class, 'exercise']);
    Route::post('/addexercise', [CreatePlanController::class, 'addex']);
    Route::post('/addexerciseforchange', [CreatePlanController::class, 'addexforchange']);
    Route::post('/delete', [CreatePlanController::class, 'delete']);
    Route::post('/deleteplan', [CreatePlanController::class, 'deleteplan']);
    Route::get('/evaluation/{id}', [CreatePlanController::class, 'evaluation']);
    Route::post('/add_exe_byadmin', [CreatePlanController::class, 'add_exe_byadmin'])->middleware('checkadmin');
    Route::post('/delete_exe_byadmin', [CreatePlanController::class, 'delete_exe_byadmin'])->middleware('checkadmin');
    Route::get('/calculate_burned_calories', [CreatePlanController::class, 'calculate_burned_calories']);

    //Route::get('/compareTimeHourMinute', [TraineesController::class, 'compareTimeHourMinute']);
});

//commerce
Route::post('/insertproduct', [CommerceController::class, 'insertproduct'])->middleware('checkadmin');
Route::post('/updatename/{id}', [CommerceController::class, 'updatename'])->middleware('checkadmin');
Route::post('/updateprice/{id}', [CommerceController::class, 'updateprice'])->middleware('checkadmin');
Route::post('/updateamount/{id}', [CommerceController::class, 'updateamount'])->middleware('checkadmin');
Route::get('/isdiscount', [CommerceController::class, 'isdiscount']);
Route::post('/buyproduct/{id}', [CommerceController::class, 'buyproduct']);
Route::get('/category/{type}', [CommerceController::class, 'category']);


Route::post('/addinformation',[TraineesController::class, 'strtrainees']);
Route::get('/home',[TraineesController::class, 'home']);
Route::get('/amen',[TraineesController::class, 'amen']);
Route::post('/chat',[CatgptController::class, 'chat']);

//social
Route::post('/addpost', [SocialController::class, 'addpost']);
Route::post('/deletepost', [SocialController::class, 'deletepost']);
Route::post('/react_post', [SocialController::class, 'post_react']);
Route::post('/delete_react_post', [SocialController::class, 'delete_reaction_on_post']);
Route::post('/addcomment', [SocialController::class, 'addcomment']);
Route::post('/deletecomment', [SocialController::class, 'deletecomment']);
Route::post('/update_comment', [SocialController::class, 'updatecomment']);
Route::post('/react_comment', [SocialController::class, 'react_comment']);
Route::post('/delete_react_comment', [SocialController::class, 'delte_reaction_on_comment']);
Route::post('/add_reply', [SocialController::class, 'addreply']);
Route::post('/update_reply', [SocialController::class, 'updatereply']);
Route::post('/delete_reply', [SocialController::class, 'deletereply']);
Route::post('/react_reply', [SocialController::class, 'react_on_reply']);
Route::post('/delete_react_reply', [SocialController::class, 'delete_reaction_on_reply']);
Route::get('/display_allposts', [SocialController::class, 'display_posts']);
Route::get('/display_comments', [SocialController::class, 'display_comments']);
Route::get('/display_replies', [SocialController::class, 'display_replies']);
Route::get('/who_react_onpost', [SocialController::class, 'who_react_onpost']);
Route::get('/who_react_oncomment', [SocialController::class, 'who_react_oncomment']);
Route::get('/who_react_onreply', [SocialController::class, 'who_react_onreply']);

//competition
Route::post('addscore', [CompetitionController::class, 'addscore']);
Route::get('top3', [CompetitionController::class, 'top3']);


//callenges
Route::get('isadmin', [ChallengeController::class, 'isadmin']);
Route::get('viewbuildingexercise', [ChallengeController::class, 'viewbuildingexercise'])->middleware('checkadmin');
Route::get('viewlosingexercise', [ChallengeController::class, 'viewlosingexercise'])->middleware('checkadmin');
Route::get('viewfitnessexercise', [ChallengeController::class, 'viewfitnessexercise'])->middleware('checkadmin');
Route::post('addchallenge', [ChallengeController::class, 'addchallenge'])->middleware('checkadmin');
Route::get('deletechallenge/{id}', [ChallengeController::class, 'deletechallenge'])->middleware('checkadmin');
Route::get('deleteday/{day}', [ChallengeController::class, 'deleteday'])->middleware('checkadmin');
Route::get('viewday/{day}', [ChallengeController::class, 'viewday']);




Route::post('password/code/check', [CodeCheckController::class, '__invoke']);
Route::post('password/reset', [ResetPasswordController::class, '__invoke']);
Route::post('forgotpassword', [ForgotPasswordController::class, '__invoke']);



Route::post('/store-token', [WebNotificationController::class, 'storeToken']);
Route::get('/send-web-notification', [WebNotificationController::class, 'sendWebNotification']);
//detect_competition_time
Route::post('/detect_competition_time', [WebNotificationController::class, 'detect_competition_time'])->middleware('checkadmin');
//challenge_notification
//Route::post('/challenge_notification', [WebNotificationController::class, 'challenge_notification']);
//detect_time_byuser
Route::post('/detect_time_byuser', [WebNotificationController::class, 'detect_time_byuser']);
//get_detectedtime_byuser
Route::get('/get_detectedtime_byuser', [WebNotificationController::class, 'get_detectedtime_byuser']);

