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

// basic route login,register,reset-password
Auth::routes();
Route::view('/after_register', 'auth.after_register')->name('afterRegister');

//pakai middleware auth untuk guard
Route::middleware('auth')->group(function () {

    //route home
    Route::get('/', 'HomeController@index')->name('home');
    // group untuk anggota aktif
    Route::middleware('CheckStatus')->group(function () {
        Route::get('anggota', 'Anggota\AnggotaController@index')->name('anggotaIndex');
        

        //route musyawarah
        Route::get('musyawarah', 'Musyawarah\MusyawarahController@index')->name('musyawarahIndex');
        Route::get('musyawarah/add', 'Musyawarah\MusyawarahController@addNotulensi')->name('musyawarahAdd');
        Route::get('musyawarah/cari', 'Musyawarah\MusyawarahController@cariNotulensi')->name('musyawarahCari');
        Route::post('musyawarah/cariquery', 'Musyawarah\MusyawarahController@cariqueryNotulensi')->name('musyawarahCariQuery');
        Route::get('musyawarah/edit/{id}', 'Musyawarah\MusyawarahController@editNotulensi')->name('musyawarahEdit');
        Route::get('musyawarah/get/{id}', 'Musyawarah\MusyawarahController@getNotulensi')->name('musyawarahGetNotulensi');
        Route::get('musyawarah/approve/{id}', 'Musyawarah\MusyawarahController@approveNotulensi')->name('musyawarahApproveNotulensi');
        Route::get('musyawarah/getkomentar/{id}', 'Musyawarah\MusyawarahController@getKomentarNotulensi')->name('musyawarahGetKomentarNotulensi');
        Route::post('musyawarah/komentarstore', 'Musyawarah\MusyawarahController@storeKomentarNotulensi')->name('musyawarahStoreKomentarNotulensi');
        
        Route::post('musyawarah/store', 'Musyawarah\MusyawarahController@storeNotulensi')->name('musyawarahStoreNotulensi');
        Route::get('musyawarah/pekerjaan', 'Musyawarah\MusyawarahController@pekerjaan')->name('musyawarahPekerjaan');
        Route::post('musyawarah/pekerjaan/store', 'Musyawarah\MusyawarahController@storePekerjaan')->name('musyawarahStorePekerjaan');
        Route::post('musyawarah/pekerjaan/add', 'Musyawarah\MusyawarahController@addPekerjaan')->name('musyawarahAddPekerjaan');
        Route::get('musyawarah/pekerjaan/detail/{id}', 'Musyawarah\MusyawarahController@getDetailPekerjaan')->name('musyawarahgetDetailPekerjaan');
        Route::post('musyawarah/pekerjaan/add/progress', 'Musyawarah\MusyawarahController@addProgressPekerjaan')->name('musyawarahAddProgressPekerjaan');

        //route keanggotaan
        Route::get('anggota', 'Anggota\AnggotaController@index')->name('anggotaIndex');
        Route::get('anggota/detail/{id}', 'Anggota\AnggotaController@getDetail')->name('anggotaDetail');
        //edit, delete anggota
        Route::post('anggota/delete', 'Anggota\AnggotaController@delete')->name('anggotaDelete');
        Route::post('anggota/update', 'Anggota\AnggotaController@update')->name('anggotaUpdate');

        //verifikasi anggota
        Route::get('anggota/verifikasi', 'Anggota\VerifikasiController@index')->name('anggotaIndexVerifikasi');
        Route::post('anggota/verifikasi/tolak', 'Anggota\VerifikasiController@tolak')->name('anggotaTolakVerif');
        Route::post('anggota/verifikasi/terima', 'Anggota\VerifikasiController@terima')->name('anggotaTerimaVerif');

        //anggota pengelola aset
        Route::get('aset/pengelola-aset', 'Aset\PengelolaAsetController@index')->name('asetPengelolaAset');
        Route::post('aset/pengelola-aset/delete', 'Aset\PengelolaAsetController@delete')->name('asetPengelolaAsetDelete');
        Route::post('aset/pengelola-aset/add', 'Aset\PengelolaAsetController@create')->name('asetPengelolaAsetCreate');

        //route aset
        Route::get('aset', 'Aset\AsetController@index')->name('asetIndex');
        Route::get('aset/status/{status}', 'Aset\AsetController@indexByStatus')->name('asetIndexByStatus');
        Route::get('aset/katalog/{id}', 'Aset\AsetController@getByKatalog')->name('asetGetByKatalog');
        Route::get('aset/detail/{id}', 'Aset\AsetController@detail')->name('asetDetail');
        Route::post('aset/update', 'Aset\AsetController@update')->name('asetUpdate');
        Route::post('aset/updateStatus', 'Aset\AsetController@updateStatus')->name('asetUpdateStatus');
        Route::post('aset/delete', 'Aset\AsetController@delete')->name('asetDelete');
        Route::post('aset/updateFoto', 'Aset\AsetController@updateFoto')->name('asetUpdateFoto');
        Route::get('aset/laporan', 'Aset\AsetController@laporan')->name('asetLaporan');
        // Route::get('aset/testing', 'Aset\AsetController@testing')->name('asetTesting');

        //route aset tracking
        Route::get('aset/tracking', 'Aset\TrackingController@trackingForm')->name('asetTracking');
        Route::get('aset/tracking_hasil', 'Aset\TrackingController@tracking')->name('asetTrackingHasil');

        //route aset pencatatan
        Route::get('aset/create', 'Aset\PendaftaranController@createForm')->name('asetCreate');
        Route::post('aset/create', 'Aset\PendaftaranController@create')->name('asetCreateHasil');

        //return JSON list
        Route::get('aset/get_json/{id}', 'Aset\AsetController@getById')->name('asetJSON');
        Route::post('read_notif_json', 'NotifikasiController@read')->name('notifReadJSON');

        //route data metadata
        // Route::get('aset/metadata', 'Aset\MetadataController@indexKategori')->name('metadataIndexKategori');
        Route::get('aset/metadata/{jenis_metadata}', 'Aset\MetadataController@index')->name('metadataIndex');
        Route::post('aset/metadata/kategori/create', 'Aset\MetadataController@create')->name('metadataCreate');
        Route::post('aset/metadata/kategori/update', 'Aset\MetadataController@update')->name('metadataUpdate');
        Route::post('aset/metadata/kategori/delete', 'Aset\MetadataController@delete')->name('metadataDelete');
        // Route::get('aset/metadata/lokasi', 'Aset\MetadataController@indexLokasi')->name('metadataIndexLokasi');
        Route::post('aset/metadata/lokasi/create', 'Aset\MetadataController@createLokasi')->name('metadataLokasiCreate');
        Route::post('aset/metadata/lokasi/update', 'Aset\MetadataController@updateLokasi')->name('metadataLokasiUpdate');
        Route::post('aset/metadata/lokasi/delete', 'Aset\MetadataController@deleteLokasi')->name('metadataLokasiDelete');
        // Route::get('aset/metadata/katalog', 'Aset\MetadataController@indexKatalog')->name('metadataIndexKatalog');
        Route::post('aset/metadata/katalog/create', 'Aset\MetadataController@createKatalog')->name('metadataKatalogCreate');
        Route::post('aset/metadata/katalog/update', 'Aset\MetadataController@updateKatalog')->name('metadataKatalogUpdate');
        Route::post('aset/metadata/katalog/delete', 'Aset\MetadataController@deleteKatalog')->name('metadataKatalogDelete');
        
        //get route usulan
        Route::get('aset/usulan/', 'Aset\UsulanController@index')->name('asetUsulanIndex');
        Route::get('aset/usulan/status/{status}', 'Aset\UsulanController@indexByStatus')->name('asetUsulanByStatus');
        //post route usulan
        Route::post('aset/usulan/create', 'Aset\UsulanController@create')->name('asetUsulanCreate');
        Route::post('aset/usulan/proses', 'Aset\UsulanController@proses')->name('asetUsulanProses');
        Route::post('aset/usulan/selesai', 'Aset\UsulanController@selesai')->name('asetUsulanSelesai');
        Route::post('aset/usulan/tolak', 'Aset\UsulanController@tolak')->name('asetUsulanTolak'); 
        Route::post('aset/usulan/batal', 'Aset\UsulanController@batal')->name('asetUsulanBatal'); 
  
        //route profil
        Route::get('/profile', 'Profile\ProfileController@index')->name('profile');
        Route::post('/profile', 'Profile\ProfileController@uploadFoto')->name('uploadFotoProfile');

        //route pengaturan_akun
        Route::get('/pengaturan_akun', 'Pengaturan_Akun\PengaturanAkunController@index')->name('pengaturanAkun');
        Route::post('/pengaturan_akun/update', 'Pengaturan_Akun\PengaturanAkunController@update')->name('pengaturanAkunUpdate');
    });
});
