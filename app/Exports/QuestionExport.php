<?php

namespace App\Exports;

use App\Models\Question;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use DB;

class QuestionExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */


    protected $data = [];

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        $questions = [];
        foreach ($this->data as $value) {
            $questions[] = array(
                'id' => $value->id,
                'board_id' => $value->board_id,
                'board_name' => isset($value->board->name) ? $value->board->name:'',
                'medium_id' => $value->medium_id,
                'medium_name' => isset($value->medium->medium_name) ? $value->medium->medium_name:'',
                'standard_id' => $value->standard_id,
                'standard' => isset($value->standard->standard) ? $value->standard->standard:'',
                'subject_id' => $value->subject_id,
                'subject_name' => isset($value->subject->subject_name) ? $value->subject->subject_name:'',
                "semester_id" => $value->semester_id,
                "semester_name" => isset($value->semester->semester) ? $value->semester->semester:'',
                'unit_id' => $value->unit_id,
                "unit_name" => isset($value->unit->title) ? $value->unit->title:'',
                'question' => isset($value->question) ? $value->question:'',
                'note' => isset($value->note) ? $value->note:'',
                "option_a" => isset($value->option_a) ? $value->option_a:'',
                'option_b' => isset($value->option_b) ? $value->option_b:'',
                'option_c' => isset($value->option_c) ? $value->option_c:'',
                'option_d' => isset($value->option_d) ? $value->option_d:'',
                'answer' => isset($value->answer) ? $value->answer:'',
                'per_question_marks' => isset($value->per_question_marks) ? $value->per_question_marks:'',
                'level' => isset($value->level) ? $value->level:'',
                'status' => $value->status,
            );
        }
        return collect([
            $questions
        ]);
    }



    public function headings(): array
    {
        return [
            "Id",
            "Board Id",
            "Board Name",
            "Medium Id",
            "Medium Name",
            "Standard Id",
            "Standard Name",
            "Subject Id",
            "Subject Name",
            "Semester Id",
            "Semester Name",
            "Unit Id",
            "Unit Name",
            "Question",
            "note",
            "option_a",
            "option_b",
            "option_c",
            "option_d",
            "answer",
            "per_question_marks",
            "level",
            "status"
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function (AfterSheet $event) {
                $cellRange = 'A1:W1';
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setBold(true)->setSize(14);
            },
        ];
    }
}
