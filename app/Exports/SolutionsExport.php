<?php

namespace App\Exports;

use App\Models\Solution;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class SolutionsExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */

    private $data = [];

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        $solutions = [];
        foreach ($this->data as $value) {
            $solutions[] = array(
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
                "user_id" => $value->user_id,
                'question' => isset($value->question) ? $value->question:'',
                'answer' => isset($value->answer) ? $value->answer:'',
                "marks" => isset($value->marks) ? $value->marks:'',
                'image_file_type' => $value->image_file_type,
                'image' => isset($value->image) ? $value->image:'',
                'label' => isset($value->label) ? $value->label:'',
                'question_type_id' => isset($value->question_type) ? $value->question_type:'',
                'question_type' => isset($value->questionType->question_type) ? $value->questionType->question_type:'',
                'level' => isset($value->level) ? $value->level:'',
                'status' => $value->status,
                'order_no' => $value->order_no
            );
        }

        return collect([
            $solutions
        ]);
    }


    public function headings(): array
    {
        return [
            'Id',
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
            "User Id",
            "Question",
            "Answer",
            "Marks",
            "Image File Type",
            "Image",
            "Label",
            "QuestionType Id",
            "QuestionType",
            "Level",
            "Status",
            "Order No",
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function (AfterSheet $event) {
                $cellRange = 'A1:Z1';
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setBold(true)->setSize(14);
            },
        ];
    }
}
