<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\MembershipTypeController;
use App\Http\Controllers\CommitteeRoleController;
use App\Http\Controllers\CommitteeMemberController;
use App\Http\Controllers\FamilyMemberController;
use App\Http\Controllers\RelationshipTypeController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\EventParticipantController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FeesPaymentController;
use App\Http\Controllers\MemberMembershipController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\FolderController;
use App\Http\Controllers\UsersController;

Route::resource('users', UsersController::class)->middleware('auth');


Route::middleware(['auth'])->group(function () {
    // File Management
    Route::get('/files', [FileController::class, 'index'])->name('files.index');
    Route::post('/files', [FileController::class, 'store'])->name('files.store');
    Route::delete('/files/{file}', [FileController::class, 'destroy'])->name('files.destroy');

    // Folder Management
    Route::post('/folders', [FolderController::class, 'store'])->name('folders.store');
    Route::delete('/folders/{folder}', [FolderController::class, 'destroy'])->name('folders.destroy');
});


Route::prefix('announcements')->name('announcements.')->middleware('auth')->group(function () {
    Route::get('/', [AnnouncementController::class, 'index'])->name('index');
    Route::get('/create', [AnnouncementController::class, 'create'])->name('create');
    Route::post('/', [AnnouncementController::class, 'store'])->name('store');
    Route::get('/{announcement}', [AnnouncementController::class, 'show'])->name('show');
    Route::get('/{announcement}/edit', [AnnouncementController::class, 'edit'])->name('edit');       // ← Add this
    Route::put('/{announcement}', [AnnouncementController::class, 'update'])->name('update');      // ← Add this
    Route::delete('/{announcement}', [AnnouncementController::class, 'destroy'])->name('destroy');
    Route::get('/print/pdf', [AnnouncementController::class, 'printPdf'])->name('printPdf'); // For PDF export
});

Route::delete('/announcements/{announcement}/remove-attachment', [AnnouncementController::class, 'removeAttachment'])
    ->name('announcements.removeAttachment');



Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');



Route::get('/members/export-excel', [MemberController::class, 'exportMembers'])
    ->name('members.exportExcel');

Route::middleware(['auth'])->group(function () {
    Route::get('members/pdf', [MemberController::class, 'pdf'])->name('members.pdf');
    Route::resource('members', MemberController::class);
    Route::resource('membership-types', MembershipTypeController::class);
    Route::resource('committee-roles', CommitteeRoleController::class);
    Route::resource('committee-members', CommitteeMemberController::class);
    Route::get('family-members/pdf', [FamilyMemberController::class, 'pdf'])->name('family-members.pdf');
  
    Route::get('/family-members/{id}/print2', [FamilyMemberController::class, 'print2'])->name('family-members.print2');
    
    Route::get('/family-members/print-excel-all', [FamilyMemberController::class, 'printExcelAll'])
    ->name('family-members.printExcelAll');

    Route::resource('family-members', FamilyMemberController::class);
    Route::get('family-members/create/{member_id?}', [FamilyMemberController::class, 'create'])->name('family-members.create');
    Route::resource('relationship-types',RelationshipTypeController::class);
    Route::resource('events',EventController::class);
    Route::resource('event_participants',EventParticipantController::class);
    Route::get('/event_participants/members/{event}', [EventParticipantController::class, 'getAvailableMembers']);
    
    
    // Single receipt
Route::get('fees_payments/print/{id}', [FeesPaymentController::class, 'print'])->name('fees_payments.print');

// Full report (filtered by search)
Route::get('fees_payments/print-all', [FeesPaymentController::class, 'printAll'])->name('fees_payments.printAll');


Route::resource('fees_payments',FeesPaymentController::class);




});


Route::get('/member-membership/print-excel-all', [MemberMembershipController::class, 'exportMemberMemberships'])
    ->name('member-membership.printExcelAll');


Route::get('/member-memberships/print', [MemberMembershipController::class, 'print'])
    ->name('member_memberships.print');

Route::resource('member_memberships', MemberMembershipController::class);

Route::post('/member-memberships/{member_id}/renew', [MemberMembershipController::class, 'renew'])
    ->name('member_memberships.renew');

Route::get('/member-memberships/{member}/history', [MemberMembershipController::class, 'history'])
    ->name('member_memberships.history');



Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
