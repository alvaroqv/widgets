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
</ul>
Link to the Upload Form: <a href="upload"> click here</a>
<br>
Link to list of uploaded Files: <a href="json"> click here</a>
<br><br>
<p>
<b>Explaining the project:</b>
<br>
- Two model files - Project and ProjectFiles<br>
The Project model: has two properties - id (Long), name (String) <br>
The ProjectFiles model: has three properties - id (Long), project_id (Long - Project relationship) , filename (String)  <br>
</p>
docker exec -it testeapp_web_1 php artisan queue:table<br><br>
docker exec -it testeapp_web_1 php artisan migrate<br><br>
docker exec -it testeapp_web_1 php artisan queue:work --daemon<br><br>
create php.ini file upload size
</p>
@stop