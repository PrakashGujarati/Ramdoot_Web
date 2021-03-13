<?php

namespace App\Imports;

use App\Models\question;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class QuestionImport implements ToModel,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function __construct($request)
    {
        $this->request = $request;
    }


    public function model(array $row)
    {
        $request=$this->request;   
        return new question([
            'board_id' => $request->board_id,
            'medium_id' => $request->medium_id,
            'standard_id' => $request->standard_id,
            'semester_id' => $request->semester_id,
            'subject_id' => $request->subject_id,
            'unit_id' => $request->unit_id,
            'question' => $row['question'],
           'note'    => $row['note'],
           'option_a' => $row['option_a'],
           'option_b' => $row['option_b'],
           'option_c' => $row['option_c'],
           'option_d' => $row['option_d'],
           'answer' => $row['answer'],
           'per_question_marks' => $row['per_question_marks'],
        ]);
    }
}
