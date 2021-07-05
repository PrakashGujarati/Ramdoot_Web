<?php

namespace App\Exports;

use App\UserDataLog;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class UserDataLogExport implements FromCollection,WithHeadings,ShouldAutoSize, WithEvents
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
    	//dd($this->data);
        $user_logs=[];
        if($this->data) {
        	foreach ($this->data as $key => $value) {

        		$user_logs[] = array(
	            	'type' => isset($value['type']) ? $value['type']:'',
	                'datetime' => isset($value['datetime']) ? $value['datetime']:'',
	                'operation' => isset($value['operation']) ? $value['operation']:'',
	                'role' => isset($value['role']) ? $value['role']:'',
	                'interval' => isset($value['interval']) ? $value['interval']:'',
	                'minutes' => isset($value['minutes']) ? $value['minutes']:'',
	            );//dd($value);
        	}
            
        }
        //dd($user_logs);

        return collect([
            $user_logs
        ]);
    }

    public function headings(): array
    {
        return [
        	"Type",
            "DateTime",
	    	"Operation",
	        "Role",
	        "Interval",
	        "Minutes",
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
