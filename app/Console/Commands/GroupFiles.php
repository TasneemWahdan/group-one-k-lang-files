<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Bus;
use App\Jobs\GroupFilesProcess;
use Throwable;

class GroupFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:group-files';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Group files according to filename into languages folders';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $filesDir = base_path(). '/resources/files';
        $files = scandir($filesDir);
        $chunkSize = 50;
        $chunks = array_chunk($files, $chunkSize);
        $batch  = Bus::batch([])->then(function (Batch $batch) {
                                        return $batch;
                                        })->catch(function (Batch $batch, Throwable $e) {
                                            return $e->getMessage();
                                        })->finally(function (Batch $batch) {
                                            return 'finished processing files';
                                        })->name('Process languages Files')
                                        ->onConnection('database')
                                        ->dispatch();
        
        foreach ($chunks as $key => $chunk) {
            try{
                $batch->add(new GroupFilesProcess($chunk, $filesDir));
            }

            catch(\Exception $e){
                return $e->getMessage();
            }
        }

        dd('Grouped Files Successfully.  For details you can check job_batches table with batch id= '. $batch->id );                               
    }
}
