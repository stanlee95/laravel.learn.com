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
    console.log(id);
    $.ajax({
        url      : '/admin-panel/get-project' + id,
        type     : 'GET',
        response : 'json',
        success  : function (data) {
            // $('#assigment-' + data.project_id).text(data.name);
            console.log(data.project_id);
        }
    });
};