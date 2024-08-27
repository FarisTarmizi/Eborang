<?php

use App\Http\Controllers\BorrowerController;
use App\Http\Controllers\DetailController;
use App\Http\Controllers\KBController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StaffController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return redirect(route('login'));
});
Route::get('test', [StaffController::class, 'test'])->name('test');

Route::get('details_form', [DetailController::class, 'details_form'])
    ->name('details_form');
Route::put('process', [DetailController::class, 'process'])->name('process');
Route::get('department', [DetailController::class, 'department'])->name('department');
Route::post('department_p', [DetailController::class, 'department_p'])->name('department_p');
Route::get('back', [DetailController::class, 'back'])->name('back');

Route::group(['prefix' => 'kb', 'as' => 'kb.', 'middleware' => ['auth', 'verified', 'role:KB_BTM']], function () {
    Route::get('dashboard_kb', [KBController::class, 'index'])->name('kb_home');
    Route::get('butiran_pinjaman/{id}', [KBController::class, 'detail'])->name('view');
    Route::get('butiran_permohonan/{id}', [KBController::class, 'detail_c'])->name('view2');
    Route::put('proses_sah/{id}', [KBController::class, 'sah'])->name('sah');
    Route::put('proses_tolak/{id}', [KBController::class, 'tolak'])->name('tolak');
    Route::put('proses_sah_capaian/{id}', [KBController::class, 'sah_c'])->name('sah_c');
    Route::put('proses_tolak_capaian/{id}', [KBController::class, 'tolak_c'])->name('tolak_c');
});

Route::group(['prefix' => 'kb_l', 'as' => 'kb_l.', 'middleware' => ['auth', 'verified', 'role:KB']], function () {
    Route::get('dashboard_kb', [KBController::class, 'index2'])->name('kbl_home');
    Route::get('butiran_pinjaman/{id}', [KBController::class, 'detail2'])->name('view');
    Route::get('butiran_permohonan/{id}', [KBController::class, 'detail2_c'])->name('view2');
    Route::put('proses_sah/{id}', [KBController::class, 'sah2'])->name('sah');
    Route::put('proses_tolak/{id}', [KBController::class, 'tolak2'])->name('tolak');
    Route::put('proses_sah_capaian/{id}', [KBController::class, 'sah2_c'])->name('sah_c');
    Route::put('proses_tolak_capaian/{id}', [KBController::class, 'tolak2_c'])->name('tolak_c');
});

Route::group(['prefix' => 'staff', 'as' => 'staff.', 'middleware' => ['auth', 'verified', 'role:STAFF_BTM']], function () {
    Route::get('dashboard_staff', [StaffController::class, 'index'])->name('staff_home');
    Route::get('senarai_permohonan', [StaffController::class, 'application'])->name('application');
    Route::get('ict_gear_list', [StaffController::class, 'list_g'])->name('list_g');
    Route::get('gear_form', [StaffController::class, 'g_form'])->name('g_form');
    Route::post('gear_process', [StaffController::class, 'g_form_p'])->name('g_form_p');
    Route::put('proses_urus/{id}', [StaffController::class, 'pic'])->name('pic');
    Route::get('detail/{id}', [StaffController::class, 'detail'])->name('detail');
    Route::get('set_gear/{id}', [StaffController::class, 'set_gear'])->name('set_gear');
    Route::get('category_gear', [StaffController::class, 'category'])->name('category');
    Route::post('category_process', [StaffController::class, 'category_p'])->name('category_p');
    Route::put('proses_pemilihan/{id}', [StaffController::class, 'pp'])->name('pp');
    Route::put('pinjaman_proses/{id}', [StaffController::class, 'borrow'])->name('pinjam');
    Route::put('pulangan_proses/{id}', [StaffController::class, 'pulangan'])->name('pulangan');
    Route::delete('proses_padam/{id}', [StaffController::class, 'remove_gear'])->name('padam_g');
    Route::put('proses_edit/{id}', [StaffController::class, 'edit_gear'])->name('edit_g');
    Route::put('tolak_permohonan/{id}', [StaffController::class, 'tolak'])->name('reject');
    Route::delete('padam_kategori/{id}', [StaffController::class, 'remove_ctgry'])->name('padam_c');
    Route::get('resit/{id}', [StaffController::class, 'resit'])->name('resit');
    Route::get('borang_permohonan', [StaffController::class, 'borang'])->name('borang');
    Route::post('proses_permohonan', [StaffController::class, 'brrw'])->name('brrw');
});

Route::group(['prefix' => 'borrower', 'as' => 'borrower.', 'middleware' => ['auth', 'verified', 'role:PEMOHON']], function () {
    Route::get('dashboard', [BorrowerController::class, 'index'])->name('index');
    Route::get('pinjaman_peralatan', [BorrowerController::class, 'home'])->name('borrower_home'); //e-borang
    Route::post('e-borang_process', [BorrowerController::class, 'pilih_modul'])->name('e_borang_p');
    Route::get('history_list', [BorrowerController::class, 'list_h'])->name('l_history');
    Route::get('history_details/{id}/{modul}', [BorrowerController::class, 'detail_history'])->name('d_history');
    Route::get('borrower_status', [BorrowerController::class, 'status'])->name('status');
    Route::get('capaian_status', [BorrowerController::class, 'status2'])->name('status2');
    Route::get('modul_hak_capaian', [BorrowerController::class, 'e_capaian'])->name('e_capaian');
    Route::post('proses_capaian', [BorrowerController::class, 'access'])->name('p_capaian');
    Route::get('modul_pinjaman', [BorrowerController::class, 'e_brrw'])->name('e_brrw');
    Route::post('borrow', [BorrowerController::class, 'borrow'])->name('borrow');
    Route::delete('penolakan_peralatan/{id}', [BorrowerController::class, 'remove'])->name('remove');
    Route::delete('penolakan_permohonan/{id}', [BorrowerController::class, 'remove2'])->name('remove2');

    Route::delete('delete-history/{id}', [BorrowerController::class, 'deleteHistory'])->name('delete_history');


});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



require __DIR__ . '/auth.php';
