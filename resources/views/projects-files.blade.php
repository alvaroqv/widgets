@extends('app')
  
@section('title')
Widgets Assignment!!!
@stop
  
@section('content')

<div class="row">
<div class="col-md-12">
<h4>Select Json File to Process</h4>
<div class="table-responsive">

<table id="mytable" class="table table-bordred table-striped">
<thead>
<th class="col-sm-4">Project Name</th>
<th class="col-sm-4">File Name</th>
<th class="col-sm-2">Process</th>
<th class="col-sm-2">Delete</th>
</thead>
<tbody>

@if (count($jsonfiles) > 0)
@foreach ($jsonfiles as $file)
    <tr>
    <td class="col-sm-4">{{ $file->name }}</td>
    <td class="col-sm-4">{{ $file->filename }}</td>
    <td class="col-sm-2"><p data-placement="top" data-toggle="tooltip" title="Process"><a href="/json/process/{{$file->id}}" class="btn btn-primary btn-xs" data-title="Edit"   ><span class="glyphicon glyphicon-refresh"></span></a></p></td>
    <td class="col-sm-2"><p data-placement="top" data-toggle="tooltip" title="Delete"><a href="javascript:removeFile({{$file->id}})" class="btn btn-danger btn-xs" data-title="Delete"   ><span class="glyphicon glyphicon-trash"></span></a></p></td>
    </tr>
@endforeach
</table>
@endif
</p>

@stop

@section('script')
<script>

function removeFile(id){
    var data= {"_token": "{{ csrf_token() }}"};
$.delete_('json/'+id, data, function(result){
    location.reload();
});
};

function pocessFile(){
$.put('jsonfile', {'id':id}, function(result){
    location.reload();
});
};
    $(document).ready(function(){

function _ajax_request(url, data, callback, type, method) {
    if (jQuery.isFunction(data)) {
        callback = data;
        data = {};
    }
    return jQuery.ajax({
        type: method,
        url: url,
        data: data,
        success: callback,
        dataType: type
        });
};

jQuery.extend({
    put: function(url, data, callback, type) {
        return _ajax_request(url, data, callback, type, 'PUT');
    },
    delete_: function(url, data, callback, type) {
        return _ajax_request(url, data, callback, type, 'DELETE');
    }
});

});
</script>    

@stop