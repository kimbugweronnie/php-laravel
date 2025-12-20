<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\EnsureTokenIsValid;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MemoController;
use App\Http\Controllers\NotificationsController;
use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\TravelController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProcurementController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\ClockInAndOutController;
use App\Http\Controllers\TimeSheetController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\CostCenterController;
use App\Http\Controllers\Admin\ProjectUserController;
use App\Http\Controllers\Admin\ProjectRoleController;
use App\Http\Controllers\Admin\DepartmentRoleController;
use App\Http\Controllers\Admin\ProjectDocumentController;
use App\Http\Controllers\Admin\CurrencyController;
use App\Http\Controllers\Admin\LeaveRequestSettingController;
use App\Http\Controllers\Admin\PublicHolidayController;

use App\Http\Controllers\Auth\CustomAuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Auth::routes();

Route::get('/', [CustomAuthController::class, 'index']);
Route::get('login', [CustomAuthController::class, 'index'])->name('login');
Route::post('custom-login', [CustomAuthController::class, 'customLogin'])->name('login.custom'); 
Route::get('registration', [CustomAuthController::class, 'registration'])->name('register-user');
Route::post('custom-registration', [CustomAuthController::class, 'customRegistration'])->name('register.custom'); 

Route::middleware([EnsureTokenIsValid::class])->group(function () {
    Route::get('signout', [CustomAuthController::class, 'signOut'])->name('signout');
    Route::get('error', [CustomAuthController::class, 'error'])->name('error');
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::resource('/memos', MemoController::class);
    Route::get('/memo/{id}', [MemoController::class, 'downloadPDF'])->name('memo.pdf');
    Route::get('/edit-memo/{id}', [MemoController::class, 'editDetails'])->name('memos.editDetails');
    Route::post('/update-memo/{id}', [MemoController::class, 'updateDetails'])->name('memos.updateDetails');

    Route::resource('/approvals', ApprovalController::class);
    Route::get('/approvals/history', [ApprovalController::class, 'approvalHistory'])->name('approvals.history');
    Route::post('/approvals/delegate', [ApprovalController::class, 'approvalDelegate'])->name('approvals.delegate');


    Route::get('/travel/{id}', [TravelController::class, 'downloadPDF'])->name('travel.pdf');
    Route::resource('/travels', TravelController::class);
    Route::get('/edit-travel-details/{id}', [TravelController::class, 'editDetails'])->name('travels.editDetails');
    Route::get('/travel-expense-voucher', [TravelController::class, 'travelExpenseVoucher'])->name('expense-voucher');
    Route::get('/create-travel-matrix/{id}', [TravelController::class, 'createTravelMatrix'])->name('create-travel-matrix');
    Route::get('/travel-matrix/{week_from}/{week_to}', [TravelController::class, 'singleTravelMatrix'])->name('travelmatrix.show');
    Route::get('/trip-report', [TravelController::class, 'travelReport'])->name('travel-report');

    Route::resource('/payments', PaymentController::class);
    Route::get('/edit-payments/{id}', [PaymentController::class, 'editPayment'])->name('payments.editPayment');
    Route::get('/payments/requisition/{id}', [PaymentController::class, 'downloadPDF'])->name('payment.pdf');

    Route::resource('/procurements', ProcurementController::class);
    Route::get('/edit-procuments/{id}', [ProcurementController::class, 'editProcurement'])->name('procurements.editProcurement');
    Route::get('/procurements/requisition/{id}', [ProcurementController::class, 'downloadPDF'])->name('procurement.pdf');

    Route::resource('/documents', DocumentController::class);
    Route::get('/documents/download/{id}', [DocumentController::class, 'download'])->name('documents.download');

    Route::resource('/activities', ActivityController::class);

    Route::get('/tasks/index', [TaskController::class, 'index'])->name('tasks.index');
    Route::get('/tasks/create', [TaskController::class, 'create'])->name('tasks.create');
    Route::post('/tasks/store', [TaskController::class, 'store'])->name('tasks.store');
    Route::get('/tasks/{id}/show', [TaskController::class, 'show'])->name('tasks.show');
    Route::get('/tasks/{id}/edit', [TaskController::class, 'edit'])->name('tasks.edit');
    Route::patch('/tasks/{id}/update', [TaskController::class, 'update'])->name('tasks.update');

    Route::resource('/leave', LeaveController::class);
    Route::get('/leave/lists', [LeaveController::class,'leaveList'])->name('leave.requests');

    Route::get('/clockIns', [ClockInAndOutController::class, 'index'])->name('clockIns.index');
    Route::get('/all/notifications', [NotificationsController::class, 'index'])->name('notifications.index');
    Route::get('/read/notifications', [NotificationsController::class, 'read'])->name('notifications.read');
    Route::get('/unread/notifications', [NotificationsController::class, 'unread'])->name('notifications.unread');
    Route::get('/notifications/count', [NotificationsController::class, 'count'])->name('notifications.count');


    Route::get('/clockIns/create', [ClockInAndOutController::class, 'createClockIn'])->name('createClockIn');
    Route::post('/clockIns', [ClockInAndOutController::class, 'storeClockIn'])->name('storeClockIn');
    Route::post('/clockOuts', [ClockInAndOutController::class, 'storeClockOut'])->name('storeClockOut');

    Route::resource('/timeSheets', TimeSheetController::class);
    Route::get('/timesheet/{month}/{year}/{id}', [TimeSheetController::class, 'downloadPDF'])->name('timesheet.pdf');
    Route::post('/timesheet/{month}/{year}', [TimeSheetController::class, 'timesheetApproval'])->name('timesheet.approve');
    Route::get('/approval/timesheet/{id}', [ApprovalController::class, 'timesheetApproval'])->name('timesheet.approval');
    Route::get('/user/timesheets', [TimeSheetController::class, 'userTimesheets'])->name('user.timesheets');
    Route::get('/user/timesheet/{id}', [ApprovalController::class, 'approvedTimesheet'])->name('approved.timesheet');
    

    Route::get('/calendar/index', [CalendarController::class, 'index'])->name('calendar.index');
    Route::get('/events', [CalendarController::class, 'events'])->name('events');

    // Admin
    Route::resource('/employees', EmployeeController::class);
    Route::get('/employee/password/{employee}/edit', [EmployeeController::class, 'editPassword'])->name('employees.editPassword');
    Route::get('/employee/levelsOfEffort/{employee}/edit', [EmployeeController::class, 'editLevelsOfEffort'])->name('employees.editLevelsOfEffort');
    Route::post('/employee/delete', [EmployeeController::class, 'deleteEmployee'])->name('employees.delete');

    Route::resource('/projects', ProjectController::class);
    Route::resource('/costCenters', CostCenterController::class);
    Route::resource('/projectRoles', ProjectRoleController::class);
    Route::resource('/departmentRoles', DepartmentRoleController::class);

    Route::resource('/projectDocuments', ProjectDocumentController::class);

    Route::get('/currencies/index', [CurrencyController::class, 'index'])->name('currencies.index');
    Route::get('/currencies/create', [CurrencyController::class, 'create'])->name('currencies.create');
    Route::post('/currencies', [CurrencyController::class, 'store'])->name('currencies.store');

    Route::get('/leaveRequestSetting', [LeaveRequestSettingController::class, 'index'])->name('leaveRequestSetting.index');
    Route::post('/leaveRequestSetting', [LeaveRequestSettingController::class, 'store'])->name('leaveRequestSetting.store');
    Route::post('/leaveRequestSetting', [LeaveRequestSettingController::class, 'update'])->name('leaveRequestSetting.update');

    Route::get('/publicHolidays/index', [PublicHolidayController::class, 'index'])->name('publicHolidays.index');
    Route::get('/publicHolidays/create', [PublicHolidayController::class, 'create'])->name('publicHolidays.create');
    Route::post('/publicHolidays/store', [PublicHolidayController::class, 'store'])->name('publicHolidays.store');

    Route::post('/accessSetting', [EmployeeController::class, 'accessSetting'])->name('accessSettings.update');
});