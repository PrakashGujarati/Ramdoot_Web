<?php

namespace App\Exports;

use App\Models\question;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use DB;

class QuestionExport implements WithHeadings,ShouldAutoSize, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    // public function collection()
    // {
    //     //return question::all();
    //     //return question::select(['question','note','option_a','option_b','option_c','option_d','answer','per_question_marks'])->get();
    // }

    protected $data;

    public function __construct(array  $data) {
        $this->data = $data;
    }

   	public function array() : array {
        return $this->data;
    }

    public function headings(): array
    {
        return [
        	"question",
        	"note",
            "option_a",
            "option_b",
            "option_c",
            "option_d",
            "answer",
            "per_question_marks",
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $cellRange = 'A1:W1';
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setBold(true)->setSize(14);
            },
        ];
    }
}
