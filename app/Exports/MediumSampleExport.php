<?php

namespace App\Exports;

use App\Models\Medium;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class MediumSampleExport implements FromCollection,WithHeadings,ShouldAutoSize, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    private  $data = [];

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        dd($this->data);
        $mediums=[];
        foreach ($this->data as $value) {
            $mediums[] = array(
                'id' => $value->id,
                'board_id' => $value->board_id,
                'board_name' => isset($value->board->name) ? $value->board->name:'',
                'medium_name' => "",
                'status' => $value->status,
                'order_no' => $value->order_no
            );
        }

        return collect([
            $mediums
        ]);
    }

    public function headings(): array
    {
        return [
        	'Id',
            "Board Id",
            "Board Name",
	    	"Medium Name",
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
