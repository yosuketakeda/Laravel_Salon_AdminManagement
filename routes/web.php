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
/*
Route::get('/', function () {
    return view('home');
});
*/
Auth::routes();
Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');

Route::get('/common-answers/{step}', 'HomeController@common_index')->name('common.index');
Route::get('/last-template-view', 'HomeController@last_template_view_index')->name('last_template_view.index');
///////////////////////////////////////////////////////////////
// admin
/*
Route::get('/admin', function() {
    return view('admin');
});
*/
Route::group(['middleware' => 'auth'], function () {
    Route::get('/admin-dashboard', 'AdminController@admin_dashboard')->name('admin_dashboard.index'); 
    Route::get('/admin-add-new/{step}', 'AdminController@admin_add_new_index')->name('admin_add_new.index');    
    Route::get('/admin-multiple/{step}', 'AdminController@admin_multiple_index')->name('admin_multiple.index'); 
    Route::get('/admin-choice/{step}', 'AdminController@admin_choice_index')->name('admin_choice.index');
    Route::get('/admin-last-template/{step}', 'AdminController@admin_last_template_index')->name('admin_last_template.index');
    Route::get('/admin-info/{step}', 'AdminController@admin_info_index')->name('admin_info.index');
    Route::get('/admin-account-list/{step}', 'AdminController@admin_account_list_index')->name('admin_account_list.index');
    Route::get('/admin-query-overall', 'AdminController@admin_query_overall')->name('admin_query_overall.index'); 
    Route::get('/admin-rate', 'AdminController@admin_rate_view')->name('admin_rate.index'); 

    Route::get('/question-menu/{step}', 'UserController@user_index')->name('user_question.index');
    Route::get('/user-part/{step}', 'UserController@index')->name('user.index');
    Route::get('/user-answer/{step}', 'UserController@user_answer_index')->name('user_answer.index');
});
Route::get('/logout', 'Auth\LoginController@logout');

// Home
Route::post('answers', 'HomeController@common_answers')->name('common.answers');
Route::post('final', 'HomeController@common_final')->name('common.final');

// admin top question register
Route::post('/admin-top-add-first', 'AdminController@admin_top_add_first')->name('admin_top_add.first');
Route::post('/admin-multiple-add-new', 'AdminController@admin_multiple_add_new')->name('admin_multiple.add');
Route::post('/admin-choice-register', 'AdminController@admin_choice_register')->name('admin_choice.register');
Route::post('/admin-choice-edition', 'AdminController@admin_choice_edition')->name('admin_choice.edition');
Route::post('/admin-last-template-add', 'AdminController@admin_last_template_add')->name('admin_last_template.add');
Route::post('/admin-info-change', 'AdminController@admin_info_change')->name('admin_info.change');
Route::post('/admin-info-confirm', 'AdminController@admin_info_confirm')->name('admin_info.confirm');
Route::post('/admin-account-add', 'AdminController@admin_account_add')->name('admin_account.add');
Route::post('/admin-account-update', 'AdminController@admin_account_update')->name('admin_account.update');

Route::post('/user-add', 'UserController@user_add')->name('user.add');
Route::post('/user-update', 'UserController@user_update')->name('user.update');

//ajax
Route::post('admin-top-edition', 'AdminController@admin_top_edition')->name('admin_top.edition');   // add new edition page
Route::post('admin-multiple-edition', 'AdminController@admin_multiple_edition')->name('admin_multiple.edition');   // add new edition page
Route::post('admin-multiple-delete', 'AdminController@admin_multiple_delete')->name('admin_multiple.delete');
Route::post('delete-query', 'AdminController@admin_top_query_delete')->name('admin_top_query.delete');
Route::post('admin-choice-delete', 'AdminController@admin_choice_delete')->name('admin_choice.delete');
Route::post('admin-last-template-delete', 'AdminController@admin_last_template_delete')->name('admin_last_template.delete');
Route::post('admin-account-delete', 'AdminController@admin_account_delete')->name('admin_account.delete');
Route::post('admin-query-overall-change', 'AdminController@admin_query_overall_change')->name('admin_query_overall.change');
Route::post('admin-query-overall-delete', 'AdminController@admin_overall_delete')->name('admin_overall.delete');
Route::post('admin-query-check', 'AdminController@admin_query_check')->name('admin_query.check');
