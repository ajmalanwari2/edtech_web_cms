@extends('layouts.master')
@section('title')
<title>News</title>
@endsection
@section('content')
<div class="page__heading">
    <div class="container-fluid page__container">
        <h1 class="mb-0">Feedback</h1>
    </div>
</div>
<div class="container-fluid page__container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-large bg-light d-flex align-items-center">
                    <div class="flex">
                        <div class="card-subtitle text-muted">List of feedbacks</div>
                    </div>
                    <button type="button" class="btn btn-info" onclick="table.ajax.reload()"
                        style="margin-left: 5px;">Reload</button>

                </div>
                <div class="card-body">
                    <table id="rmo" class="display  table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th style="display:none">Updated at</th>
                                <th>Username</th>
                                <th>Identity Number</th>
                                <th>Email</th>
                                <th>Type</th>
                                <th>Message</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@section('modals')

<!-- VIEW FORM START-->
<div id="modal-view" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-form-title"
    style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-form-title">Notices</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div> <!-- // END .modal-header -->
            <div class="modal-body">
                <div class="row g-3 ">
                    <div class="col-md-6">
                        <div class="me-1">Username:</div>
                        <div id="feedback_username" class="text-muted"></div>
                    </div>
                    <div class="col-md-6">
                        <div class="me-1">Identity Number:</div>
                        <div id="feedback_identity_number" class="text-muted"></div>
                    </div>
                </div>
                <div class="row g-3 mt-2">
                    <div class="col-md-6">
                        <div class="me-1">Email:</div>
                        <div id="feedback_email" class="text-muted"></div>
                    </div>
                    <div class="col-md-6">
                        <div class="me-1">Feedback Type:</div>
                        <div id="feedback_type" class="text-muted"></div>
                    </div>
                </div>
                <div class="row g-3 mt-2">
                    <div class="col-md-6">
                        <div class="me-1">Message:</div>
                        <div id="feedback_message" class="text-muted"></div>
                    </div>
                </div>
            </div> <!-- // END .modal-body -->
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
            </div> <!-- // END .modal-footer -->
        </div> <!-- // END .modal-content -->
    </div> <!-- // END .modal-dialog -->
</div>
<!-- VIEW FORM END-->

<!-- DELETE COFIRM modal-->
<div id="modal-confirm" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-body text-center p-4">
                <i class="material-icons icon-40pt text-warning mb-2">warning</i>
                <h6>Do you want to delete the record!</h6>
                <button type="button" class="btn btn-light" onclick="closeModal()">No</button>
                <button type="button" class="btn btn-warning my-2" onclick="deleteRecord()">Yes</button>
            </div> <!-- // END .modal-body -->
        </div> <!-- // END .modal-content -->
    </div> <!-- // END .modal-dialog -->
</div> <!-- // END .modal -->

@endsection

@endsection

@section('styles')
<style>
.modal-lg {
    max-width: 950px !important;
}

#contentTable th.title {
    text-align: center;
}

#contentTable {
    border-collapse: collapse;
}

#contentTable th,
#contentTable td {
    padding: 5px;
}

#contentTable tbody tr {
    height: 30px;
}
</style>
@stop
@section('scripts')


<script type="text/javascript">
var table = $('#rmo').DataTable({
    dom: 'Bfrtip',
    lengthMenu: [
        [10, 25, 50, -1],
        ['10 rows', '25 rows', '50 rows', 'Show all']
    ],
    buttons: ['pageLength', {
        extend: 'excelHtml5',

        exportOptions: {
            columns: [1, 2, 3, 4]
        }
    }, ],
    serverSide: true,
    ajax: {
        url: site_url + 'api/feedback/list',
        type: 'POST',
        data: {
            '_token': '{{ csrf_token() }}'
        }
    },
    columns: [{
            data: null,
            visible: false, // Hide the column
            orderable: true, // Enable ordering on the column
            render: function(data, type, row) {
                return data.updated_at; // Return the value for ordering
            }
        },
        {
            data: 'username'
        },
        {
            data: 'identity_number'
        },
        {
            data: 'email'
        },
        {
            data: 'type'
        },
        {
            data: 'message'
        },
        {
            data: 'actions'
        }
    ],
    processing: true,
    order: [
        [0, 'desc']
    ] // Apply descending order to the first column
});





function closeModal() {
    $('#modal-confirm').removeClass('show');
    $('.modal-backdrop').remove();
}

function loadRecord(id) {
    $.ajax({
        type: "POST",
        url: site_url + 'api/feedback/show',
        data: {
            id: id,
            '_token': '{{ csrf_token() }}'
        },
        fail: (function() {
            $.toaster({
                priority: 'danger',
                title: 'Info',
                message: 'There was error loading record.'
            });
        }),
        success: (function(data) {
            $('#feedback_username').text(data.username);
            $('#feedback_identity_number').text(data.identity_number);
            $('#feedback_email').text(data.email);
            $('#feedback_type').text(data.type);
            $('#feedback_message').text(data.message);
            $("#modal-form-title").html("Feedback");
        }),
        dataType: 'json'
    });
}
var deleteRecordID = 0;

function deleteRecord() {

    if (deleteRecordID == 0)
        return;

    $.ajax({
        type: "POST",
        url: site_url + 'api/feedback/delete',
        data: {
            id: deleteRecordID,
            '_token': '{{ csrf_token() }}'
        },
        error: function(xhr, textStatus, errorThrown) {
            $.toaster({
                priority: 'danger',
                title: 'Info',
                message: xhr.responseJSON.message
            });
        },
        success: (function(data) {

            $.toaster({
                priority: 'success',
                title: 'Info',
                message: 'Record has been removed.'
            });
            $('#modal-confirm').modal('toggle');
            table.ajax.reload();
        }),
        dataType: 'json'
    });
}
$(document).on('hide.bs.modal', '#modal-form', function() {
    $('#entry_edit_form').trigger("reset");
    $("#saveBTN").attr("onclick", "saveForm()");
    $("#saveBTN").html("Save");
    $("#modal-form-title").html("Notice");
});
</script>

@stop