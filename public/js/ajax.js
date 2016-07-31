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

function changeStatus(id) {
    var status = $('#status-'+id).val();
    $.ajax({
        url      : '/user-profile/status',
        type     : 'POST',
        response : 'json',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: { project_id: id, status: status },
        success  : function (data) {
            $('#div-status-' + data.project_id).text(data.status);
            console.log(data.status);
        }
    });
};

function changeUserStatus(id) {
    var status = $('#admin-status-'+id).val();

    $.ajax({
        url      : '/admin-panel/users/status',
        type     : 'POST',
        response : 'json',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="admin-csrf-token"]').attr('content')
        },
        data: { id: id, status: status },
        success  : function (data) {
            $('#admin-div-status-' + data.id).text(data.status);
            console.log(data.status);
        }
    });
};

function assignUser(id) {
    var user_id = $('#admin-assign-'+id).val();

    $.ajax({
        url      : '/admin-panel/assign-projects',
        type     : 'POST',
        response : 'json',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="assign-csrf-token"]').attr('content')
        },
        data: { project_id: id, user_id: user_id },
        success  : function (data) {
            $('#assigment-' + data.project_id).text(data.name);
            console.log(data.project_id);
        }
    });
};

function getProjectById(id) {

    if(id == null) {
        $('#title').val(null);
        $('#software').val(null);
        $('#literature').val(null);
        $('#content').val(null);
        $('#id').val(null);
        $('#project_id').val(null);
    } else {
        $.ajax({
            url      : '/admin-panel/get-project/' + id,
            type     : 'GET',
            response : 'json',
            success  : function (data) {
                if(data.status == null) {
                    $('#title').val(data.data.title);
                    $('#software').val(data.data.software_requirements);
                    $('#literature').val(data.data.recomended_literature);
                    $('#content').val(data.data.description);
                    $('#id').val(data.data.id);
                    $('#project_id').val(data.data.project_id);
                    console.log(data.data);
                } else {
                    alert(data.status);
                }
            }
        });
    }
};

function projectDelete(id) {
    result = confirm('Are you sure?');

    if(result == true) {
        $.ajax({
            url      : 'delete-projects/' + id,
            type     : 'GET',
            dataType : 'json',
            success  : function (data) {
                $('#project-div-'+id).remove();
            }
        });
    } else {
        return false;
    }
};

function getNewById(id) {

    if(id == null) {
        $('#title').val(null);
        $('#short_description').val(null);
        $('#description').val(null);
        $('#id').val(null);
    } else {
        $.ajax({
            url      : '/admin-panel/get-new/' + id,
            type     : 'GET',
            response : 'json',
            success  : function (data) {
                if(data.status == null) {
                    $('#title').val(data.data.title);
                    $('#short_description').val(data.data.short_description);
                    $('#description').val(data.data.description);
                    $('#id').val(data.data.id);
                    console.log(data.data);
                } else {
                    alert(data.status);
                }
            }
        });
    }
};

function newDelete(id) {
    result = confirm('Are you sure?');

    if(result == true) {
        $.ajax({
            url      : 'delete-new/' + id,
            type     : 'GET',
            dataType : 'json',
            success  : function (data) {
                $('#new-div-'+id).remove();
            }
        });
    } else {
        return false;
    }
};