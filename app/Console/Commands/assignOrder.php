<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Standard;
class assignOrder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'assign.order_no';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $all_datas=Standard::all();
        foreach ($all_datas as $key => $value) {
            $udp=Standard::find($value->id);
            $udp->order_no=$key+1;
            $udp->save();
        }
    }
}
