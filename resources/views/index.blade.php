@extends('app')
  
@section('title')
Widgets Assignment!!!
@stop
  
@section('content')
<h1>Processing JSON files</h1>
<h4>Demonstrate how to use Laravel Frameworks to process JSON files and save it into Database.</h4>
<p>
<ul>
<li>Shows how to upload a file into the server using Laravel</li> 
<li>Process this file using background queued process</li> 
<li>The process should be able to stop and then continue where it stopped.</li>
<li>Export files into Excel table</li>
</ul>
Link to the Upload Form: <a href="upload"> click here</a>
<br>
Link to list of uploaded Files: <a href="json"> click here</a>
<br>
Link to list of processing Files table: <a href="json/processing"> click here</a>
<br>
Link to list of processed Files table: <a href="json/processed"> click here</a>
<br>



@stop