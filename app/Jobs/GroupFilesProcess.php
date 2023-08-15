<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Bus\Batchable;

class GroupFilesProcess implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */

    protected $files, $filesDir;

    public function __construct($files, $filesDir)
    {
        $this->files = $files;
        $this->filesDir = $filesDir;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {   
        foreach($this->files as $file){
            if($file != '.' && $file != '..'){
                $lang = explode('-', $file);
                $langDirectory = $this->filesDir.'/'.$lang[0];
        
            if(!is_dir( $langDirectory)){
                mkdir( $langDirectory,0777);
            }
           
           if(is_file($this->filesDir . '/' . $file))
                rename($this->filesDir . '/' . $file, $langDirectory. '/' . $file);
            }
        }
    }
}
