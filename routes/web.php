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

//================================================================================================================//
//                                 Routing Bagian Frontend Website                                                //
//================================================================================================================//

// Halaman landing page
Route::get('/', 'Frontend\LandingPageController@index')->name('show_landing_page');
// Halaman about
Route::get('about', 'Frontend\AboutController@index')->name('show_about_page');
// Halaman berita
Route::get('news', 'Frontend\NewsController@index')->name('show_news_page');
// Halaman detail berita
Route::get('news/{slug}', 'Frontend\NewsController@newsDetail')->name('show_news_detail');
// Halaman infografis
Route::get('infographics', 'Frontend\InfographicController@index')->name('show_infographic_page');
// Halaman Data
Route::get('data', 'Frontend\DataController@showListData')->name('show_data_page');
// Halaman Data Menurut Instansi
Route::get('data/{institution_id}', 'Frontend\DataController@showDataByInstitution')->name('show_data_by_institution');
// Halaman Detail Data
Route::get('data/{id}/{year}', 'Frontend\DataController@showDataDetail')->name('show_data_detail');

//================================================================================================================//
//                                 Routing Bagian Backend Website                                                 //
//================================================================================================================//

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();

    // Routing untuk halaman data
    Route::get('data', [
        'uses' => 'DataController@index',
        'as'   => 'voyager.data.index'
    ])->middleware('admin.user');

    Route::post('data/{id}/{tahun?}', [
        'uses' => 'DataController@show',
        'as'   => 'voyager.data.show'
    ])->middleware('admin.user');

    Route::get('data/create/{id}/{tahun}', [
        'uses' => 'DataController@create',
        'as'   => 'voyager.data.create'
    ])->middleware('admin.user');

    Route::post('data/create/{id}/{tahun}', [
        'uses' => 'DataController@save',
        'as'   => 'voyager.data.save'
    ])->middleware('admin.user');

    Route::get('data/view/{id}/{tahun}', [
        'uses' => 'DataController@view',
        'as'   => 'voyager.data.view'
    ])->middleware('admin.user');

    Route::get('data/edit/{id}/{tahun}', [
        'uses' => 'DataController@edit',
        'as' => 'voyager.data.edit'
    ])->middleware('admin.user');

    Route::patch('data/edit/{id}/{tahun}', [
        'uses' => 'DataController@update',
        'as'   => 'voyager.data.update'
    ])->middleware('admin.user');

    Route::delete('data/destroy/{id}/{tahun}', [
        'uses' => 'DataController@destroy',
        'as'   => 'voyager.data.destroy'
    ])->middleware('admin.user');

    // Routing untuk halaman pemeriksaan
    Route::get('verifications', [
        'uses' => 'VerificationController@index',
        'as'   => 'voyager.verifications.index'
    ])->middleware('admin.user');

    Route::post('verifications', [
        'uses' => 'VerificationController@fetchIndikator',
        'as'   => 'voyager.verifications.fetchindikator'
    ])->middleware('admin.user');

    Route::post('verifications/{id}', [
        'uses' => 'VerificationController@fetchData',
        'as'   => 'voyager.verifications.fetchdata'
    ])->middleware('admin.user');

    Route::get('verifications/{id}/{year}', [
        'uses' => 'VerificationController@view',
        'as'   => 'voyager.verifications.view'
    ])->middleware('admin.user');

    Route::patch('verifications/{id}/{year}', [
        'uses' => 'VerificationController@store',
        'as'   => 'voyager.verifications.check'
    ])->middleware('admin.user');

    Route::get('verifications/state/{check}/{status}', [
        'uses' => 'VerificationController@getDataByStatus',
        'as'   => 'voyager.verifications.getByStatus'
    ])->middleware('admin.user');
});