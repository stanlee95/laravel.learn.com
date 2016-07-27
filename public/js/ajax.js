function ajaxDelete(id) {
    $.ajax({
        url      : 'deleteById/' + id,
        type     : 'GET',
        dataType : 'json',
        success  : function (data) {
            alert('Post deleted!');
            window.location.reload();
        }
    });
};