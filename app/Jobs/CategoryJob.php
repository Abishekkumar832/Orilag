<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Category;
use Auth;

class CategoryJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $importFile;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($importFile)
    {        
        $this->importFile = $importFile;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->importFile as $value) {
            Category::updateOrCreate([
                'user_id'          => Auth::user()->id,
                'category_name'    => $value, 
            ]);
        }
    }
}
