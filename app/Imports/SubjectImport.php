<?php

namespace App\Imports;

use App\Models\Subject;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SubjectImport implements ToModel,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Subject([
            'board_id' => $row['board_id'],
            'medium_id' => $row['medium_id'],
            'standard_id' => $row['standard_id'],
            'subject_name' => $row['subject_name'],
            'sub_title' => $row['sub_title'],
            'url' => $row['url'],
            'thumbnail' => $row['thumbnail'],
            'status' => $row['status'],
            'order_no' => $row['order_no']
        ]);
    }
}
