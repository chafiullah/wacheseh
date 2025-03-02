<?php

use Illuminate\Support\Facades\Route;

Route::group(
    [
        "prefix" => "teacher",
        "as" => "teacher.",
        "middleware" => "auth",
        "namespace" => "Teacher",
    ],
    function () {
        /** From the admin side */
        Route::get("list", "AdminTeacherController@teachers")->name(
            "list"
        );
        Route::get("assign-course-profile/{teacher}", "AdminTeacherController@assign_courses_index")->name("assign.course");
        Route::post("assign-courses-profile", "AdminTeacherController@assign_courses_store")->name("assign.course.store");
        Route::get("courses-profile-remove/{teacher}", "AdminTeacherController@remove_courses_profile")->name("remove.course.profiles");
        /** From the Teacher Side */
        Route::get("courses", "MyCoursesController@my_courses")->name(
            "courses"
        );
        Route::get("students", "ManageStudentsController@my_students")->name("students");
        /** Course groups and group wise students */
        Route::group(
            ["prefix" => "course/groups", "as" => "course.group."],
            function () {
                Route::get("list", "CourseGroupController@groups")->name("list");
                Route::post("store", "CourseGroupController@group_store")->name("store");
                Route::get("delete", "CourseGroupController@group_delete")->name("destroy");
                // fetch students
                Route::get("stuednts", "CourseGroupController@student_list")->name("student.list");
                // add students to group
                Route::post("students/store", "CourseGroupController@students_store")->name("student.store");
                Route::get("student/delete", "CourseGroupController@students_delete")->name("student.destroy");
            }
        );
        /** Send emails to students/group-students from teachers' portal */
        Route::group(
            ["prefix" => "send-emails", "as" => "email."],
            function () {
                Route::get("select-students", "ManageStudentsController@send_mail_select_students")->name("index");
                Route::post("select-students/mail/send", "ManageStudentsController@send_mail")->name("send");
            }
        );
        /** Grade Book Routes */
        Route::group(["prefix" => "grades", "as" => "grade."], function () {
            Route::get("courses", "MyCoursesController@grade_book_courses")->name("course");
            Route::get("class/{department}/course/{course}/term/{term}/grade-book", "MyCoursesController@grade_book_generate")->name("book.generate");
            Route::post("grade-book/store", "MyCoursesController@grade_book_store")->name("book.store");
            Route::get("grade-book/get-grades", "MyCoursesController@get_grades")->name("get");
        });
    }
);
