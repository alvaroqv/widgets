<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\JsonFiles;
use DateTime;
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

    public function converteData($data){
        Log::debug('Date format Convert: '.$data);
        if(strlen($data) == 12){
            $data = str_replace("\/","-",$data);
        }
        $time = strtotime($data);
        $date = new DateTime();
        $date->setTimestamp($time);
        Log::debug('Date format Convert Righ: '. $date->format('Y-m-d H:i:s') );
        
        return $date;
     }

     public function verifyAge($date){
        if($date == null) return 0;
        $date = $this->converteData($date);

        Log::debug('Date format Verify Age: '. $date->format('Y-m-d H:i:s') );

        $now = new DateTime();
        $interval = $now->diff($date);

        Log::debug('Found Age: '. $interval->y );

        return $interval->y;
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

                Log::info('File Processing date_of_birth: '. $this->verifyAge($data['date_of_birth']) );
                
                if( $data['date_of_birth'] == null || ( ($this->verifyAge($data['date_of_birth']) >= 18) &&  ($this->verifyAge($data['date_of_birth']) <= 65) )) {
                
                Log::info('Processing Bithday OK: '. $this->verifyAge($data['date_of_birth']) ); 
                
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

                }
                
               
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
