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

Route::get('/', 'PortalController@index')->name('/');

Route::get('/login', 'LoginController@login')->name('login');
Route::post('/login/auth', 'LoginController@auth');
Route::get('/logout', 'LoginController@logout')->name('logout');
Route::get('/register', 'LoginController@register')->name('register');

Route::post('/guest/register', 'RegisterController@register')->name('user_register');

Route::get('/user/payment/recipe/{id}', 'UserController@userBillFish')->name('user.detail_nota_fish');
Route::get('/user/payment', 'UserController@userPaymentFish')->name('user.payment_fish');
Route::post('/user/update_picture_ikan/', 'UserController@updateFishPicture')->name('user.update_fish_picture');
Route::post('/user/update_ikan/', 'UserController@updateFish')->name('user.update_fish');
Route::get('/user/data_ikan/{id}', 'UserController@showDetailFish')->name('user.detail_fish');
Route::post('/store/register_ikan/', 'UserController@userStoreFish')->name('user.store_ikan');
Route::get('/user/register_ikan/{id}', 'UserController@userRegisterFish')->name('user.regis_ikan');
Route::post('/user/personal_data/', 'UserController@personalUpdateData')->name('user.update_personal');
Route::get('/user/personal_data/{id}', 'UserController@personalData')->name('user.personal');
Route::get('/user/fish_data/{id}', 'UserController@fishData')->name('user.fish');
Route::get('/user/dashboard', 'UserController@index')->name('user.dashboard');


Route::post('/admin/add_fish_point/store_fish_point', 'AdminController@storeFishPoint')->name('admin.store_fish_point');
Route::get('/admin/add_fish_point/get_fish_by_bio/{id}', 'AdminController@getFishByBio')->name('admin.getfishbybio');
Route::get('/admin/add_fish_point', 'AdminController@addFishPoint')->name('admin.add_fish_point');
Route::get('/admin/fish_point', 'AdminController@FishPoint')->name('admin.fish_point');
Route::post('/admin/update_pass_setup', 'AdminController@updatePass')->name('admin.update_pass');
Route::get('/admin/pass_setup', 'AdminController@setupPass')->name('admin.setup_pass');
Route::get('/admin/user_pass_setup', 'AdminController@setupUserPass')->name('admin.setup_user_pass');
Route::get('/admin/data_ikan/{id}', 'AdminController@printStickerFish')->name('admin.fish_sticker');
Route::get('/admin/data_ikan', 'AdminController@dataFish')->name('admin.fish_entry');
Route::post('/admin/store_admin', 'AdminController@storeAdmin')->name('admin.store_admin');
Route::get('/admin/add_admin', 'AdminController@addAdmin')->name('admin.add_admin');
Route::post('/admin/update_resi_ikan', 'AdminController@updateFishResiReg')->name('admin.update_user_resi_register');
Route::post('/admin/upload_resi_ikan', 'AdminController@uploadFishResiReg')->name('admin.upload_user_resi_register');
Route::post('/admin/update_picture_ikan', 'AdminController@updateFishPicture')->name('admin.update_user_picture_fish');
Route::post('/admin/fish_confirm_registrasi', 'AdminController@ConfirmRegistrasi')->name('admin.confirm_reg_fish');
Route::post('/admin/fish_peserta_detail', 'AdminController@UpdateUserFish')->name('admin.update_user_fish');
Route::get('/admin/fish_peserta_detail/{id}', 'AdminController@detailUserFish')->name('admin.detail_user_fish');
Route::get('/admin/fish_peserta/{id}', 'AdminController@listFishPeserta')->name('admin.peserta_fish');
Route::get('/admin/list_peserta', 'AdminController@listPeserta')->name('admin.list_peserta');
Route::post('/admin/store_peserta', 'AdminController@storePeserta')->name('admin.store_peserta');
Route::get('/admin/add_peserta', 'AdminController@addPeserta')->name('admin.add_peserta');
Route::get('/admin/dashboard', 'AdminController@index')->name('admin.dashboard');