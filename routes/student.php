<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\student\StudentHomeController;
use App\Http\Controllers\student\StudentRegistrationController;

Route::group(["namespace" => "student"], function () {
    Route::get("/student-login", "StudentLoginController@login_show");
    Route::post("/student-login", "StudentLoginController@login")->name(
        "student.login"
    );
});
Route::group(
    ["namespace" => "student", "middleware" => "auth:student"],
    function () {
        Route::get("/student-logout", "StudentLoginController@logout");
        Route::get("/student-home", "StudentHomeController@home")->name(
            "student.home"
        );
        Route::get("/student-profile", "StudentHomeController@profile");

        Route::get("/profile-settings", "StudentSettingController@index");
        Route::match(
            ["put", "patch"],
            "/profile-settings/{studentInfo}",
            "StudentSettingController@profile_update"
        )->name("student.profile.update");

        /** Student Marks */
        Route::get(
            "/student-academic-result",
            "StudentResultController@index"
        )->name("student.result.index");
        Route::get('student-academic-result/academic-year/{year}/class/{class_id}','StudentResultController@result')->name('student.result.show');
        
        /** Payment Routes */
        Route::get("/student-payment", "PaymentController@index");
        Route::post(
            "student-online-payment",
            "PaymentController@makePyament"
        )->name("student.makePyament");
        Route::get(
            "student-payment-history",
            "PaymentController@paymentHistory"
        )->name("payment.history");
        /** Program Outline, Exams, Courses */
        Route::get("program-outline", [
            StudentRegistrationController::class,
            "studentProgramOutline",
        ])->name("program.outline.student");
        Route::get("enrolled-courses", [
            StudentRegistrationController::class,
            "enrolledCourses",
        ])->name("student.courses.enrolled");
        // Route::get('academic-events',[StudentHomeController::class,'academic_events'])->name('student.academic.events');
        /**
         * Notification Handler
         */
        Route::get("notification/mark-read/{studentID}", [
            StudentHomeController::class,
            "notificationMarkRead",
        ])->name("notification.mark.read");
        Route::get("notification/all/{studentID}", [
            StudentHomeController::class,
            "notificationAll",
        ])->name("notification.student.all");
        /**
         * Documents
         */
        Route::get("official-documents", [
            StudentHomeController::class,
            "official_documents",
        ])->name("student.documents");
    }
);
