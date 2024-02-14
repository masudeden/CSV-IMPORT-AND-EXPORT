$(document).ready(function(){
    fetchData();
});

function fetchData(){
    if($.fn.DataTable.isDataTable('#userDataTable')){
        $('#userDataTable').DataTable().destroy();
    }

    var userDataTable = $('#userDataTable').DataTable({
        processing: true,
        serverSide: true,
        paging: true,
        lengthMenu: [5, 10, 15, 20],
        ordering: true,
        columnDefs: [
            {orderable: false, "target": [3]}
        ],
        ajax: {
            url: 'getData.php',
            type: 'GET',
            data: function (d) {
                d.page = Math.ceil(d.start / d.length) + 1;
                d.rowsPerPage = d.length;
                d.draw = d.draw;
                d.search = d.search.value;
            },
            dataType: 'json',
        },
        columns: [
            { data: 'name' },
            { data: 'email' },
            { data: 'phone' },
            {
                data: null,
                render: function (data){
                    return '<div class="btn-group" role="group">'+
                        '<button type="button" class="btn btn-sm btn-primary" onclick="editUser(' + data.id + ')" data-bs-toggle="modal" data-bs-target="#editUserModal" data-user-id="' + data.id + '">Edit</button>'+
                        '<button type="button" class="btn btn-sm btn-danger" onclick="confirmDeleteModal(' + data.id + ')" data-bs-toggle="modal" data-bs-target="#deleteUserModal" data-user-id="' + data.id + '">Delete</button>'+
                        '</div>';
                }
            }
        ],
    });
}

function uploadCSV(){
    var formData = new FormData($('#csvForm')[0]);

    $.ajax({
        url: 'upload.php',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response){
            if(response === 'success'){
                hideMessage('success-message');
                showMessage('success-message', 'CSV File imported successfully');
                $('#importCsvModal').modal('hide');
                fetchData();
            }else{
                displayError(response.error);
            }

        },
        error: function (xhr, status, error){
            displayError('AJAX Error: '+xhr.responseText);
        }
    });
}

function exportCSV() {
    var dataTable = $('#userDataTable').DataTable();

    var dataTableData = dataTable.rows().data().toArray();

    var csvContent = "Name,Email,Phone\n";
    dataTableData.forEach(function (row) {
        var rowData = Array.isArray(row) ? row : Object.values(row);

        var filteredData = rowData.filter(function (_, index) {
            return index !== 0;
        });
        csvContent += filteredData.map(function (cell) {
            return cell;
        }).join(",") + "\n";
    });

    var encodedUri = encodeURI("data:text/csv;charset=utf-8," + csvContent);

    var link = document.createElement("a");
    link.setAttribute("href", encodedUri);
    link.setAttribute("download", "exported_data.csv");
    document.body.appendChild(link);
    link.click(); // Fix the typo here
    document.body.removeChild(link);

    showMessage('success-message', 'CSV file exported successfully.');
}

function insertUser(){
    $.ajax({
        url: 'insertUser.php',
        type: 'POST',
        data: $('#insertUserForm').serialize(),
        success: function(response){
            hideMessage('error-message');
            showMessage('success-message','User Inserted successfully.');
            $('#insertUserModal').modal('hide');
            fetchData();
        },
        error: function (xhr, status, error){
            displayError('Ajax error: ' + xhr.responseText);
        }
    });
}

function editUser(userId) {
    $.ajax({
        url: 'getUserDetails.php',
        type: 'POST',
        data: { userId: userId },
        dataType: 'json',
        success: function (userDetails) {
            $('#editUserName').val(userDetails.name);
            $('#editUserEmail').val(userDetails.email);
            $('#editUserPhone').val(userDetails.phone);
            $('#editUserForm').append('<input type="hidden" name="userId" value="' + userId + '">');
        },
        error: function (xhr, status, error) {
            displayError('AJAX error: ' + xhr.responseText);
        }
    });
}

function saveEditedUser(){
    $.ajax({
        url: 'saveEditedUser.php',
        type: 'POST',
        data: $('#editUserForm').serialize(),
        success: function (response) {
            console.log(response);
            hideMessage('error-message');
            showMessage('success-message', 'User edited successfully.');
            $('#editUserModal').modal('hide');
            fetchData();
        },
        error: function (xhr, status, error) {
            displayError('AJAX error: ' + xhr.responseText);
        }
    });
}

function confirmDeleteModal(userId){
    $('#confirmDeleteButton').data('user-id', userId);
}

function confirmDeleteUser(){
    var userId = $('#confirmDeleteButton').data('user-id');

    $.ajax({
        url: 'deleteUser.php',
        type: 'POST',
        data: {userId: userId},
        success: function(response){
            hideMessage('error-message');
            showMessage('success-message','User deleted successfully.');
            $('#deleteUserModal').modal('hide');
            fetchData();
        },
        error: function (xhr, status, error) {
            displayError('AJAX error: ' + xhr.responseText);
        }
    });

}

function hideMessage(id){
    $('#' + id).hide();
}

function showMessage(id,message){
    $('#' + id).find('#success-text').text(message);
    $('#' + id).show();
}

function displayError(message){
    hideMessage('success-message');
    $('#error-text').text(message);
    showMessage('error-message', message)
}