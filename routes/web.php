<?php

use App\AcademicYear;
use App\Helper\Helper;
use App\PromoteStudent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaxController;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\Department_Controller;
use App\Http\Controllers\StudentExamController;
use App\Http\Controllers\StudentInfoController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\Accounting\FeeController;
use App\Http\Controllers\Report\CourseReportController;
use App\OutlineCourse;
use App\OutlineYear;

if (version_compare(PHP_VERSION, '7.2.0', '>=')) {
    // Ignores notices and reports all other kinds... and warnings
    error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
    // error_reporting(E_ALL ^ E_WARNING); // Maybe this is enough
}
/**
 * Public routes with no Middleware
 */
Route::get('/', function () {
    return view('auth.studentLogin');
})->name('base');

Route::get('clear', function () {
    Artisan::call('optimize:clear');
    Artisan::call('storage:link');
    return 'cache-cleared';
});
Route::get('test', function () {
    return "Perform test operation";
    
});
Route::group(['prefix' => 'account-recovery'], function () {
    Route::post('send-otp', 'PasswordResetController@send_otp')->name('send.otp');

    Route::get('password-reset/user_type/{user}/user_id/{user_id}', function ($user, $user_id) {
        return view('password_reset', compact('user', 'user_id'));
    })->name('password.reset.link');

    Route::match(['put', 'patch'], '/password-update/user_type/{user}/user_id/{user_id}', 'PasswordResetController@passwordUpdate')->name('password.reset.update');
});
/**
 * Protected Routes
 */
Route::group(['prefix' => '/admin', 'middleware' => 'auth'], function () {
    /*
     *------------------Academic Year Management Routes----------------------------
     * */
    Route::get('academic-year/list','AcademicYearController@listAcademicYear')->name('academicYear.list');
    Route::post('academic-year/add','AcademicYearController@storeAcademicYear')->name('academicYear.add');
    Route::get('academic-year/list/destroy/{id}','AcademicYearController@destroyAcademicYear')->name('academicYear.destroy');
    Route::get('academic-year/list/activate/{id}','AcademicYearController@activeAcademicYear')->name('academicYear.active');
    /**
     * ---------------------Notification, Email, SMS Routes-------------------------
     */
    Route::get('send-emails/index', 'HomeController@sendMailIndex')->name('send.mail.index');
    Route::post('send-emails/send', 'HomeController@sendMailSend')->name('send.mail.send');
    Route::get('send-sms/create', 'HomeController@sendSMSIndex')->name('send.sms.index');
    Route::post('send-sms/send', 'HomeController@sendSMSSend')->name('send.sms.send');
    Route::get('sent-sms/prices', 'HomeController@sentSMSPrices')->name('sent.sms.prices');
    Route::post('sent-sms/calculator', 'HomeController@sentSMSPricesCalculator')->name('sent.sms.calculator');
    /**
     * Student Notifications
     */
    Route::get('notification-sent', [HomeController::class, 'notificationSentList'])->name('notification.list');
    Route::get('send/notifications/index', [HomeController::class, 'notificationIndex'])->name('notification.send.index');
    Route::post('send/notifications', [HomeController::class, 'notificationSend'])->name('notification.send');

    /**
     * Admin Notes
     */
    Route::get('notes-from-others', [HomeController::class, 'noteIndex'])->name('admin.note.index');
    Route::post('notes-send', [HomeController::class, 'noteSend'])->name('admin.note.send');
    Route::get('notes/clear', [HomeController::class, 'notesClear'])->name('admin.note.clear');
    // student password reset from admin panel
    Route::get('student-password-reset/{studentInfo}', [StudentInfoController::class, 'student_password_reset'])->name('student.password.admin.reset');
    /*
     * ------------------------Student Information Routes-----------------------------------
     * */
    Route::get('/studentinfo/delete/{id}', 'StudentInfoController@delete')->name('studentinfo.delete');
    // student resource routes
    Route::resource('studentInfo', 'StudentInfoController');
    Route::get('student/comment/index/{studentInfo}','StudentInfoController@indexComment')->name('student.comment.index');
    Route::post('student/comment/add','StudentInfoController@addComment')->name('student.comment.store');
    Route::get('student/comment/delete/{id}','StudentInfoController@deleteComment')->name('student.comment.delete');
    // terminate student profile access
    Route::get('student-profile-access/{id}/{loginAccess}', [StudentInfoController::class, 'loginAccess'])->name('studentinfo.loginAccess');
    Route::post('/studentview', 'StudentInfoController@studentview')->name('student.view');
    Route::get('/studentview/{id}', 'StudentInfoController@studentDownload')->name('studentinfo.download');
    Route::match(['put', 'patch'], 'student-remarks/update/{studentID}', [StudentInfoController::class, 'remarksUpdate'])->name('studentinfo.remarks.update');
    Route::get('student-information/{type}', 'StudentInfoController@export_all_filter')->name('student.all_export.filter');
    Route::post('studentinfo/download/', 'StudentinfoExportImportController@export_std')->name('studentinfo.export');
    Route::post('studentinfo/list-by-academic-year/', 'StudentInfoController@listByAcademicYear')->name('studentinfo.list.byAcademicYear');
    Route::get('studentinfo/list-by-academic-year/destroy/{id}', 'StudentInfoController@destroyFromListByAcademicYear')->name('studentinfo.list.byAcademicYear.destroy');
    //Promote students
    Route::get('promote-students','StudentInfoController@studentPromoteStart')->name('student.promote.start');
    Route::post('promote-students/promote','StudentInfoController@studentPromote')->name('student.promote');
    Route::post('promote-students/promote/bulk','StudentInfoController@studentPromoteBulk')->name('student.promote.bulk');
    /*
    * ------------------------Student Import and Export Routes-----------------------------------
    * */
    Route::post('studentinfo/import_std', 'ImportStudentController@import_st')->name('student.import');
    Route::post('studentinfo/import/update', 'ImportStudentController@import_st_update')->name('student.import.update');
    Route::get('/student-import', 'ImportStudentController@import_std')->name('student.excelImport');
    Route::get('studentreport/{dept}/{status}', 'StudentInfoReportController@report_dept_status')->name('student.report_dept_status');
    /*
    * ------------------------Student Portal Feature Control Routes-----------------------------------
    * */
    Route::get('student-portal-control/{featureID}', [StudentInfoController::class, 'featureControl'])->name('student.feature.manage');
    Route::get('student-portal-control', [StudentInfoController::class, 'featureControlIndex'])->name('student.feature.index');
    /**
     * Registration Controlller
     */
    Route::get('enrolled-course/{department}', [RegistrationController::class, 'enrollStudentIndex'])->name('enroll.students.index');
    Route::post('enrolled-courses/{department}', [RegistrationController::class, 'enrollCourses'])->name('enroll.course.store');
    Route::get('class-courses/enrolled/remove/{registration}', 'RegistrationController@classCourseRemove')->name('course.enrolled.remove');

    /**
     * Course Related Routes
     */
    Route::get('/courses-delete/{courseID}', 'CourseController@destroy')->name('course.destroy');
    Route::resource('course', 'CourseController')->except('destroy');
    /**
     * Marks Related Routes
     */
    Route::get('mark-destroy/{mark}', 'MarkController@destroy')->name('mark.destroy');
    Route::resource('/mark', 'MarkController')->except('index', 'destroy');
    // import marks
    Route::get('mark-import', 'ImportMarkController@upload')->name('mark.import.index');
    Route::post('mark-import/generate-list', 'ImportMarkController@generateList')->name('mark.import.generate');
    Route::post('mark-import', 'ImportMarkController@import_mark')->name('mark.import');
    // Ajax Routes for Marks Management
    Route::get('get-students-by-class', 'MarkController@get_students_by_class')->name('get-student.list');
    Route::get('get-courses-by-outline', 'MarkController@get_courses_by_outline')->name('get-courses-by-outline.list');

    /**
     * Individual Student Marks
     */
    Route::get('student-marks/index', 'MarkController@student_marks_index')->name('student-marks.index');
    Route::post('student-marks/show', 'MarkController@student_marks_show')->name('student-marks.show');

    /** Academic Record Routes */
    Route::group(['prefix' => 'academic-record', 'as' => 'academic.'], function () {
        Route::get('report-card', 'AcademicTranscriptController@report_card_index')->name('report-card.index');
        Route::post('report-card/generate', 'AcademicTranscriptController@report_card_generate')->name('report-card.generate');
    });
    /**
     * Exams and Student Exams Admin side Routes
     */
    Route::get('exam-destroy/{id}', [StudentExamController::class, 'destroy'])->name('exams.destroy');
    Route::resource('/exams', 'StudentExamController')->except('create', 'destroy');
    /**
     * Ajax Controllers
     */
    Route::get('course-credit', 'CourseController@courseCredit')->name('courseCredit.ajax');
    Route::get('marks-fetch', 'MarkController@marks_fetch')->name('marks.fetch');
    Route::get('transcript-generated-last', 'MarkController@lastGenerated')->name('lastGenerated.fetch');
    Route::get('report/course/leftover/student-list', [CourseReportController::class, 'leftover_student_list'])->name('report.course.leftover.students');

    /*
########## Admin Management Routes ###########
 */
    Route::post('user/import', 'ImportUserController@import')->name('user.import');
    Route::get('user/destroy/{user}', 'UserController@destroy')->name('user.destroy');
    Route::resource('user', 'UserController')->except('show', 'destroy');
    Route::match(['put', 'patch'], 'role-update/{id}', 'UserController@role_update')->name('user.assign_roles');
    Route::resource('role', 'RoleController');
    Route::resource('permission', 'PermissionController');
    Route::get('/settings', [
        'as' => 'user.settings',
        'uses' => 'UserController@settings',
    ]);
    Route::post('/settings', [
        'as' => 'user.settings',
        'uses' => 'UserController@postSettings',
    ]);
    /** Settings controller */
    // laravel audit and student feature
    Route::get('all-activities', 'AuditController@index')
        ->name('activity.audit')
        ->middleware('auth');
    // Database Backups
    Route::get('download-database-backup', 'HomeController@database_backup')->name('database.backup');
    // current semester CRUD
    Route::get('current-semester-running/delete/{id}', 'Current_Semester_Controller@destroy')->name('current-semester-running.destroy');
    Route::resource('current-semester-running', 'Current_Semester_Controller')->except('destroy');
    /** Departments */
    Route::get('department/delete/{department}', 'Department_Controller@destroy')->name('department.destroy');
    Route::resource('department', 'Department_Controller')->except('destroy');
    // program outlines
    Route::get('program-outline', [Department_Controller::class, 'programOutline'])->name('programs.outline');
    Route::post('program-outline-store', [Department_Controller::class, 'programOutlineStore'])->name('programs.outline.store');
    Route::get('program-outline/{outline}/edit', [Department_Controller::class, 'programOutlineEdit'])->name('programs.outline.edit');
    Route::patch('program-outline/{outline}/patch', [Department_Controller::class, 'programOutlinePatch'])->name('programs.outline.patch');
    Route::get('program-outline/{outline}/delete', [Department_Controller::class, 'programOutlineDestroy'])->name('programs.outline.destroy');

    // Subjects to course outlines
    Route::patch('program-outline/{outline}/subjects',[Department_Controller::class, 'programOutlineSubjects'])->name('programsoutline.subjects');
    Route::patch('program-outline/{outline}/years',[Department_Controller::class, 'programOutlineAcademicYears'])->name('programsoutline.years');
    

    Route::match(['put', 'patch'], 'program-instruction/update/{studentExam}', [Department_Controller::class, 'program_instruction_update'])->name('programs.instruction.update');
    // Event Types
    Route::get('event-types/delete/{id}', 'EventTypeController@destroy')->name('event-types.destroy');
    Route::resource('event-types', 'EventTypeController')->except('destroy');
    // semester events
    Route::get('semester-event/{session_id}', 'EventController@index')->name('semester-event.index');
    Route::get('semester-delete/{event_id}', 'EventController@destroy')->name('semester-event.delete');
    Route::resource('semester-event', 'EventController')->except('index', 'destroy');
    // Document Routes
    Route::get('document/{document}', [DocumentController::class, 'destroy'])->name('document.destroy');
    Route::resource('document', 'DocumentController')->except('create', 'edit', 'show', 'update', 'destroy');
    Route::get('document/generate/w9', [DocumentController::class, 'w9_index'])->name('document.w9.index');
    Route::post('document/generate/w9/download', [DocumentController::class, 'w9_download'])->name('document.w9.download');
    // store document student wise
    Route::get('student/documents', 'DocumentController@student_document_index')->name('student.document.index');
    Route::post('student/documents/store', 'DocumentController@student_document_store')->name('student.document.store');
    Route::get('student/documents/{student_id}', 'DocumentController@student_document_list')->name('student.document.list');
    Route::get('student/documents/destroy/{studentDocument}', 'DocumentController@student_document_destroy')->name('student.document.destroy');
});

/*
########## Accounting  Route ###########
 */
Route::group(['prefix' => '/admin', 'middleware' => 'auth', 'namespace' => 'Accounting'], function () {
    Route::get('fee/delete/{feeId}', 'FeeController@destroy')->name('fee.destroy');
    Route::resource('fee', 'FeeController')->except('destroy');
    Route::get('payment-on-today', 'FeeController@paymentToday')->name('fee.payment.today');
    Route::post('payment-by-date', 'FeeController@paymentDateWise')->name('fee.payment.date');
    Route::get('manual-payment', 'FeeController@manualPaymentIndex')->name('fee.manual.index');
    Route::post('manual-payment-store', 'FeeController@manualPaymentStore')->name('fee.manual.store');
    Route::get('manual-payment/edit/{id}', 'FeeController@manualPaymentEdit')->name('fee.manual.edit');
    Route::get('manual-payment/delete/{id}', 'FeeController@manualPaymentDestroy')->name('fee.manual.destroy');
    Route::get('approve-payment/{id}', [FeeController::class, 'paymentApprove'])->name('fee.manual.approve');
    Route::get('reject-payment/{id}', [FeeController::class, 'paymentReject'])->name('fee.manual.reject');
    Route::match(['put', 'patch'], 'manual-payment/update/{id}', 'FeeController@manualPaymentUpdate')->name('fee.manual.update');
    /**
     * 1098 routes
     */
    Route::get('1098-2021-only', [TaxController::class, 'index'])->name('tax.old.index');
    Route::post('old-1098-posting', [TaxController::class, 'store'])->name('tax.old.store');
    Route::get('old-1098-posting/{id}', [TaxController::class, 'edit'])->name('tax.old.edit');
    Route::get('old-1098-posting/delete/{id}', [TaxController::class, 'destroy'])->name('tax.old.destroy');
    Route::match(['put', 'patch'], 'old-1098-update/{id}', [TaxController::class, 'update'])->name('tax.old.update');
    Route::get('student-1098-form/{studentID}', [TaxController::class, 'create'])->name('tax.old.generate');
    /** Withdrawn Refund System */
    Route::get('withdrawn-student-refund-form', 'FeeController@withdrawn_refund')->name('withdrawn.refund.index');
    Route::post('withdrawn-student-refund-form/generate', 'FeeController@withdrawn_refund_generate')->name('withdrawn.refund.generate');
});

Route::group(['prefix' => 'reports', 'as' => 'report.'], function () {
    Route::group(['prefix' => 'courses', 'as' => 'course.'], function () {
        Route::get('leftover/index', [CourseReportController::class, 'leftover_index'])->name('leftover.index');
        Route::post('leftover/student/list', [CourseReportController::class, 'leftover_list'])->name('leftover.list');
        // completed courses
        Route::get('completed/index', [CourseReportController::class, 'completed_index'])->name('completed.index');
        Route::post('completed/student/list', [CourseReportController::class, 'completed_list'])->name('completed.list');
    });
});
/*
########## Student Portal Route ###########
 */
//default route uses both admin panel
Route::get('minimum-payable', [FeeController::class, 'minimumPayabale'])->name('pay.minimum');

Auth::routes();

Route::get('/admin/dashboard', 'HomeController@index')->name('admin.home');
Route::get('/mark-as-read', 'HomeController@markNotificationsRead')->name('mark.read');
