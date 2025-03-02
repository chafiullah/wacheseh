<?php

namespace App\Exports;

use App\StudentInfo;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;

class StudentInfoExport implements FromCollection,WithHeadings,WithEvents
{

    public $semester;
    public $department;
    public function __construct($semester,$department)
	{
        $this->semester=$semester;
        $this->department=$department;
	}
    
    public function registerEvents(): array
    {
        $styleArray = [
        	'font'=>[
        		'bold'=>true,
        	]
        ];
        return [
            // Handle by a closure.
            AfterExport::class => function(AfterExport $event) use($styleArray) {
                $event->sheet->getStyle('A1:F1')->applyFormArray($styleArray);
            },
        ];
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return StudentInfo::query()->where('Program',$this->department)->where('Enrollment_Semester',$this->semester)->orderby('Registration_Number','ASC')->get([
            'id', 
            'Enrollment_Semester',
            'Registration_Number',
            'Full_Name',
            'Batch',
            'Program',
            'Date_of_Birth',
            'Gender',
            'Marital_Status',
            'Blood_Group',
            'Religion',
            'Nationality',
            'Fathers_Name',
            'Fathers_Profession',
            'Mothers_Name',
            'Mothers_Profession',
            'Student_Mobile_Number',
            'Email_Address',
            'Guardian_Name',
            'Guardian_Mobile_Number',
            'Permanent_Address',
            'Current_status',
            'Current_semester'
            ]);
    }

    public function headings(): array
    {
        return [
            'id', 
            'Enrollment Semester',
            'Registration Number',
            'Full Name',
            'Batch',
            'Program',
            'Date of Birth',
            'Gender',
            'Marital Status',
            'Blood Group',
            'Religion',
            'Nationality',
            'Fathers Name',
            'Fathers Profession',
            'Mothers Name',
            'Mothers Profession',
            'Student Mobile Number',
            'Email Address',
            'Guardian Name',
            'Guardian Mobile Number',
            'Permanent Address',
            'Current Status',
            'Current Semester'
            
        ];
    }

    
}
