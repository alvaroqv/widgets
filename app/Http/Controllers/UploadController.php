<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\JsonFiles;
use App\Jobs\WriteJsonFileJob;
use pcrov\JsonReader\JsonReader;
use Illuminate\Support\Facades\DB;


class UploadController extends Controller
{


    /**
     * Upload Form page
     */
    public function uploadForm()
    {

        $s = '06/10/2011 19:00:02';
$date = strtotime($s);
echo date('d/M/Y H:i:s', $date);


        return view('upload_form');
    }

    /**
     * Upload the JSON file and save the JSON file path
     */
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


    /**
     * List Files uploaded - STATUS = // 1 - not process / 2 - processing / 3 - processed
     */
    public function listFile(){
        $jsonfiles = JsonFiles::where('status', 1)->get();
        return view('projects-files',compact('jsonfiles'));
    }

    /**
     * Shows files for Excel Export
     */
    public function listExport($filename){
        $jsonfiles = DB::table('jsons_data')->where('filename', $filename)->get();
        return view('export-table',compact('jsonfiles'));
    }

    /**
     *  Lista Files in processing stage
     */
    public function listProcessingFile(){
        $jsonfiles = JsonFiles::where('status', 2)->get();
        return view('projects-files-processing',compact('jsonfiles'));
    }

    /**
     * List Files Processed
     */
    public function listProcessedFile(){
        $jsonfiles = JsonFiles::where('status', 3)->get();
        return view('projects-files-processed',compact('jsonfiles'));
    }


    /**
     *  Send files to process  - Call the QUEUE
     */
    public function processJson($id){
        $jsonfile = JsonFiles::find($id);
        $jsonfile->status = 2;
        $jsonfile->save();
        
        WriteJsonFileJob::dispatch($id);
        return redirect('/json');
    }

    
/**
 * Delete the file from Database
 */
    public function deleteJson($id){
        $jsonfiles = JsonFiles::find($id);
        if($jsonfiles)
            $jsonfiles->delete();
        //return redirect('json');
    }

}
