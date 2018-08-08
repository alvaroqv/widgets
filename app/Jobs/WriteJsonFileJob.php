<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\JsonFiles;
use App\Jobs\WriteJsonFileJob;
use pcrov\JsonReader\JsonReader;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class WriteJsonFileJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $id;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::info('Starting the File Process: '.$this->id);
        $destinationPath = public_path().DIRECTORY_SEPARATOR.'files';
        $jsonfile = JsonFiles::find($this->id);
        if($jsonfile == null){
            Log::info("Didn't find the file id : ".$this->id );
            return;
        }

        $path =  $destinationPath.DIRECTORY_SEPARATOR.$jsonfile->filename ;

        Log::info('File Processing path: '.$path );

        $reader = new JsonReader();
        $reader->open($path);

        if($reader->read()){

            $jsonfile->status = 2;
            $jsonfile->save();

            Log::info('File Processing status 2: '. $jsonfile->filename );

            $i =0;
            $dados = array();

            foreach($reader->value() as $data){
                
                $dados[$i]= array(
                    'filename' => $jsonfile->filename,
                    'name' =>  $data['name'],
                    'address' =>  $data['address'],
                    'checked' =>  $data['checked'],
                    'description' =>  $data['description'],
                    'interest' =>  $data['interest'],
                    'date_of_birth' =>  $data['date_of_birth'],
                    'email' =>  $data['email'],
                    'account' =>  $data['account'],
                    'card_type' =>  $data['credit_card']['type'],
                    'card_number' => $data['credit_card']['number'],
                    'card_name' => $data['credit_card']['name'],
                    'card_date' => $data['credit_card']['expirationDate'],
                );
                //  var_dump($data);
                $i++;
                //if($i == 230){break;}

                if($i == ($jsonfile->lastline + 100) ){
                    
                    Log::debug('Saving Data: '.$jsonfile->filename .' - Line: '.$i);
                    
                    $dataToSave = array_slice($dados, $jsonfile->lastline, 100);   
                    DB::table('jsons_data')->insert($dataToSave);
                    $jsonfile->lastline = $i;

                    Log::debug('Updating File line: '.$jsonfile->filename .' - Line: '.$i);
                    $jsonfile->save();
                }
            }
            if(($i-$jsonfile->lastline) > 0 ){
                $dataToSave = array_slice($dados, $jsonfile->lastline, ($i-$jsonfile->lastline));   
                DB::table('jsons_data')->insert($dataToSave);
                $jsonfile->lastline = $i;
                $jsonfile->save();
            }
        }
        Log::info('File Processing ending status 3 : '.$jsonfile->filename );
        $jsonfile->status = 3;
        $jsonfile->save();

    //$content =json_encode($dados)
     //  file_put_contents(public_path().DIRECTORY_SEPARATOR.'files_processed'.DIRECTORY_SEPARATOR.$jsonfile->filename, $content);
    }
}
