/* Extend jQuery with functions for PUT and DELETE requests. */

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

$(document).ready(function(){

function removeFile(id){
    $.put('jsonfile', {'id':id}, function(result){
        location.reload();
    });
};

function pocessFile(){
    $.delete_('jsonfile', {'id':id}, function(result){
        location.reload();
    });
};

});