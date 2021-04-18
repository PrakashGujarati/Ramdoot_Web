<?php

namespace App\Exports;

use App\Models\Board;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class BoardSampleExport implements FromCollection,WithHeadings,ShouldAutoSize, WithEvents
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
        $mediums=[];
        if($this->data) {
            $mediums[] = array(
                'id' => $this->data->id,
                'name' => $this->data->name,
                'abbreviation' => $this->data->abbreviation,
                'thumbnail' => $this->data->thumbnail,
                'status' => $this->data->status,
                'order_no' => $this->data->order_no,
            );
        }

        return collect([
            $mediums
        ]);
    }

    public function headings(): array
    {
        return [
        	"Id",
            "Name",
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
