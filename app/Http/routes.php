<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::group([], function() {
    Route::match(['get', 'post'], '/', ['uses' => 'IndexController@execute', 'as' => 'home']);
    Route::get('/page/{alias}', ['uses' => 'PageController@execute', 'as' => 'page']);

    Route::auth();
});

Route::group(['prefix'=>'admin', 'middleware'=>'auth'], function() {
    Route::get('/', function(){
        if(view()->exists('admin.index')){
            $data = ['title'=>'Administrator Panel'];
            return view('admin.index', $data);
        }
    });

    Route::group(['prefix'=>'pages'], function() {
        Route::get('/',['uses' => 'AdminPages\PagesController@execute', 'as' => 'pages']);
        Route::match(['get','post'], '/add', ['uses' => 'AdminPages\PagesAddController@execute', 'as' => 'pagesAdd']);
        Route::match(['get','post','delete'], '/edit/{page}', ['uses' => 'AdminPages\PagesEditController@execute', 'as' => 'pagesEdit']);
    });

    Route::group(['prefix'=>'portfolios'], function() {
        Route::get('/',['uses' => 'AdminPortfolio\PortfolioController@execute', 'as' => 'portfolios']);
        Route::match(['get','post'], '/add', ['uses' => 'AdminPortfolio\PortfolioAddController@execute', 'as' => 'portfolioAdd']);
        Route::match(['get','post','delete'], '/edit/{portfolio}', ['uses' => 'AdminPortfolio\PortfolioEditController@execute', 'as' => 'portfolioEdit']);
    });

    Route::group(['prefix'=>'services'], function() {
        Route::get('/',['uses' => 'AdminServices\ServicesController@execute', 'as' => 'services']);
        Route::match(['get','post'], '/add', ['uses' => 'AdminServices\ServicesAddController@execute', 'as' => 'servicesAdd']);
        Route::match(['get','post','delete'], '/edit/{service}', ['uses' => 'AdminServices\ServicesEditController@execute', 'as' => 'servicesEdit']);
    });
});



