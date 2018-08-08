<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\JsonFiles;
use App\Jobs\WriteJsonFileJob;
use pcrov\JsonReader\JsonReader;
use Illuminate\Support\Facades\DB;


class UploadController extends Controller
{


    public function uploadForm()
    {
        return view('upload_form');
    }

    public function uploadSubmit(Request $request)
    {

        $destinationPath = public_path().DIRECTORY_SEPARATOR.'files';

        $file = $request->file('jsonfile');
        $extension = $file->getClientOriginalExtension();
        $filename  = 'jsonfile-' . time() . '.' . $extension;

        $data=[
            'name' => request('name'),
            'filename' =>  $filename, 
            'lastline' => 0,
            'status' => 1, 
        ];

        $request->file('jsonfile')->move($destinationPath,$filename);

        $jsonfile = JsonFiles::firstOrCreate($data);

        return redirect('json');
    }

   /* public function processFile()
    {
        $this->dispatch(
            new WriteJsonFileJob()
        );
        return view('projects-files',compact('jsonfiles'));
    }*/

    public function listFile(){
        $jsonfiles = JsonFiles::where('status', 1)->get();
        return view('projects-files',compact('jsonfiles'));
    }

    public function listExport($filename){
        $jsonfiles = DB::table('jsons_data')->where('filename', $filename)->get();
        return view('export-table',compact('jsonfiles'));
    }

    public function listProcessingFile(){
        $jsonfiles = JsonFiles::where('status', 2)->get();
        return view('projects-files-processing',compact('jsonfiles'));
    }

    public function listProcessedFile(){
        $jsonfiles = JsonFiles::where('status', 3)->get();
        return view('projects-files-processed',compact('jsonfiles'));
    }


    public function processJson($id){
        $jsonfile = JsonFiles::find($id);
        $jsonfile->status = 2;
        $jsonfile->save();
        
        WriteJsonFileJob::dispatch($id);
        return redirect('/json');
    }

    public function processJson_old($id){
        $destinationPath = public_path().DIRECTORY_SEPARATOR.'files';
        $jsonfile = JsonFiles::find($id);
        $path =  $destinationPath.DIRECTORY_SEPARATOR.$jsonfile->filename ;

        $reader = new JsonReader();
        $reader->open($path);

        if($reader->read()){

            $jsonfile->status = 2;
            $jsonfile->save();

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
                $i++;
                if($i == 5){break;}
            }
           // var_dump($dados);
           DB::table('jsons_data')->insert($dados);
           $jsonfile->status = 3;
           $jsonfile->save();
           //$jsonfiles = JsonFiles::where('id', $id)->get();
        }
        //return view('projects-files',compact('jsonfiles'));
    }

    public function deleteJson($id){
        $jsonfiles = JsonFiles::find($id);
        if($jsonfiles)
            $jsonfiles->delete();
        //return redirect('json');
    }

}
