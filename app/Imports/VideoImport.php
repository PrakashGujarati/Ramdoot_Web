<?php

namespace App\Imports;

use App\Models\Videos;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class VideoImport implements ToModel,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Videos([
            'board_id' => $row['board_id'],
            'medium_id' => $row['medium_id'],
            'standard_id' => $row['standard_id'],
            'subject_id' => $row['subject_id'],
            'semester_id' => $row['semester_id'],
            'unit_id' => $row['unit_id'],
            'user_id' => $row['user_id'],
            'title' => $row['title'],
            'sub_title' => $row['sub_title'],
            'url_type' => $row['url_file_type'],
            'url' => $row['url'],
            'thumbnail' => $row['thumbnail'],
            'thumbnail_file_type' => $row['thumbnail_file_type'],
            'duration' => $row['duration'],
            'description' => $row['description'],
            'edition' => $row['edition'],
            'label' => $row['label'],
            'release_date' => $row['release_date'],
            'start_time' => $row['start_time'],
            'status' => $row['status'],
            'order_no' => $row['order_no']
        ]);
    }
}
