<?php

namespace App\Exports;

use App\Models\Board;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class BoardsExport implements FromCollection,WithHeadings,ShouldAutoSize, WithEvents
{
    
    public function collection()
    {
        return Board::select('id','name','sub_title','abbreviation','thumbnail','status','order_no')->where(['status' => 'Active'])->get();
    }

    public function headings(): array
    {
        return [
        	"Id",
            "Name",
            "Sub Title",
	    	"Full form of Board/Organisation",
	        "Thumbnail",
	        "Status",
	        "Order No",
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
