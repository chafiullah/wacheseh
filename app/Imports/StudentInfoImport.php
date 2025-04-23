<?php

namespace App\Imports;

use App\StudentInfo;
use App\PromoteStudent;
use App\Helper\Helper;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class StudentInfoImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $student= StudentInfo::create([
            'admission_date'  => $row['admission_date'],
            'name' => Str::title( $row['name']),
            'gender'  => $row['gender'],
            'date_of_birth'  => $row['date_of_birth'],
            'region'  => $row['region'],
            'email'  => $row['email'],
            'phone'  => $row['phone'],
            'password'  => Hash::make($row['password']),
            'address'  => $row['address'],
            'student_series'  => $row['student_series'],
            'student_id'  => Helper::generateStudentUniqueID(),
            'legal_guidance'  => $row['legal_guidance'],
            'guidance_email'  => $row['guidance_email'],
            'guidance_phone'  => $row['guidance_phone'],
            'status'  => $row['status'],
            'repeater'  => $row['repeater'],
        ]);
        $student_reforged = Helper::reforgeStudentId($student);
        $student->update([
            'student_id' => $student_reforged
         ]);
        return new PromoteStudent([
            'academic_year'=>Helper::getYear($student->admission_date),
            'department_id'=>$row['class_id'],
            'student_id'=>$student->id,
            'outline_id'=>0,
        ]);
    }

    public function rules(): array
    {
        return [
            'admission_date' => [
                'required',
                'string',
            ],
            'date_of_birth' => [
                'required',
                'string',
            ]
        ];
    }
    public function customValidationMessages(): array
    {
        return [
            'admission_date.string' => 'Admission date validation field failed, the date must be present and presented as a string, so check your excel file if you have converted the column as text.',
            'date_of_birth.string' => 'Date of Birth date validation field failed, the date must be present and presented as a string, so check your excel file if you have converted the column as text.',
        ];
    }
}
