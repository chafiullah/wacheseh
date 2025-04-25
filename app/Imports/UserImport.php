<?php

namespace App\Imports;

use App\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

class UserImport implements ToModel, WithHeadingRow, SkipsEmptyRows
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new User([
            'name'  => $row['name'],
            'email'  => $row['email'],
            'phone'  => $row['phone'],
            'subject_position'  => $row['subject_position'],
            'password'  => Hash::make($row['password']),
            'status'  => $row['status'],
        ]);
    }
}
