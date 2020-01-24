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

Route::get('/', function () {
    return view('welcome');
});
Route::group(['middleware'=>'auth'],function (){

    Route::get('posts','PageController@posts');
    Route::get('post/{id}','PageController@singlePost');
    Route::post('post/store','PageController@storePost');
    Route::post('post/{id}/store','PageController@storeComment');
    Route::get('category/{id}','PageController@category');
    Route::get('categories','PageController@allCategory');
    Route::post('categories','PageController@postCategory');
    Route::get('logout','SessionController@logout');
});
Route::get('login','SessionController@loginUser')->name('login');
Route::post('login','SessionController@postUser');
Route::get('register','RegisterController@registerUser');
Route::post('register','RegisterController@postUser');
Route::get('statistics','PageController@statistics');




//admin
Route::get('admin',[
        'uses'=>'PageController@admin',
        'as'=>'content.admin',
        'middleware'=>'check-role',
        'roles'=>['admin'],
]);
Route::post('setting',[
    'uses'=>'PageController@setting',
    'as'=>'content.admin',
    'middleware'=>'check-role',
    'roles'=>['admin'],
]);
Route::post('like',[
    'uses'=>'PageController@like',
    'middleware'=>'check-role',
    'roles'=>['admin','user','editor'],
])->name('like');
Route::post('dislike',[
    'uses'=>'PageController@dislike',
    'middleware'=>'check-role',
    'roles'=>['admin','user','editor'],
])->name('dislike');
Route::post('add-role',[
    'uses'=>'PageController@addRole',
    'as'=>'content.admin',
    'middleware'=>'check-role',
    'roles'=>['admin'],
]);
Route::get('editor',[
    'uses'=>'PageController@editor',
    'as'=>'content.editor',
    'middleware'=>'check-role',
    'roles'=>['admin','editor'],
]);

Route::get('test',function (){
    if(auth()->check()){
        $post=\App\Post::find(7);
        return $post->user;
        return auth()->user()->name;

    }else{
        return 'not login';
    }
});
