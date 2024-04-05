@extends('layouts.master')
@section('title')
<title>Regional Management Offices</title>
@endsection
@section('content')
<div class="page__heading">
    <div class="container-fluid page__container">
        <h1 class="mb-0">Regional Management Offices</h1>
    </div>
</div>
<div class="container-fluid page__container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-large bg-light d-flex align-items-center">
                    <div class="flex">
                        <div class="card-subtitle text-muted">List of Regional Management Offices</div>
                    </div>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-form">Add New
                        Record</button>
                    <button type="button" class="btn btn-info" onclick="table.ajax.reload()"
                        style="margin-left: 5px;">Reload</button>

                </div>
                <div class="card-body">
                    <table id="rmo" class="display  table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th style="display:none">Updated at</th>
                                <th>Number</th>
                                <th>RMO Name</th>
                                <th>RMO Abbreviation</th>
                                <th>Status</th>
                                <th>Contact Name</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>GPS</th>
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
<!-- ADD/EDIT FORM START-->
<div id="modal-form" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-form-title"
    style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-form-title">Regional Management Office</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div> <!-- // END .modal-header -->
            <div class="modal-body">
                <form action="#" method="post" enctype="multipart/form-data" id="entry_edit_form">
                    @csrf
                    <div class="was-validated">
                        <div class="form-row">
                            <div class="col-12 col-md-6 mb-3">
                                <label class="text-label" for="first_name">Number:</label>
                                <div class="input-group input-group-merge">
                                    <input id="number" type="text" required=""
                                        class="form-control form-control-prepended" placeholder="Number"
                                        value="{{ old('number') }}">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <span class="fas fa-list-ol"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <label class="text-label" for="name">RMO Name:</label>
                                <div class="input-group input-group-merge">
                                    <input id="name" type="text" required="" class="form-control form-control-prepended"
                                        placeholder="RMO Name" value="{{ old('name') }}">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <span class="fas fa-igloo"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-12 col-md-6 mb-3">
                                <label class="text-label" for="abbreviation">RMO Abbreviation:</label>
                                <div class="input-group input-group-merge">
                                    <input id="abbreviation" type="text" required=""
                                        class="form-control form-control-prepended" placeholder="RMO Abbreviation"
                                        value="{{ old('abbreviation') }}">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <span class="fas fa-home"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <label class="text-label" for="email">Status:</label>
                                <div class="input-group input-group-merge">
                                    <select id="status" data-toggle="select" name="status" class="form-control"
                                        required="">
                                        <option value="">Select</option>
                                        <option value="1">Active</option>
                                        <option value="0">In active</option>
                                    </select>
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <span class="fas fa-eye-slash"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                        <div class="col-12 col-md-6 mb-3">
                                <label class="text-label" for="contact_name">Contact Name:</label>
                                <div class="input-group input-group-merge">
                                    <input id="contact_name" type="text" required="" class="form-control form-control-prepended"
                                        placeholder="Contact Name" value="{{ old('contact_name') }}">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <span class="fas fa-igloo"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <label class="text-label" for="phone">Phone No:</label>
                                <div class="input-group input-group-merge">
                                    <input id="phone" type="text" required="" class="form-control form-control-prepended"
                                        placeholder="Phone No" value="{{ old('phone') }}">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <span class="fas fa-igloo"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                        <div class="col-12 col-md-6 mb-3">
                                <label class="text-label" for="email">Email:</label>
                                <div class="input-group input-group-merge">
                                    <input id="email" type="text" required="" class="form-control form-control-prepended"
                                        placeholder="Email" value="{{ old('email') }}">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <span class="fas fa-igloo"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <label class="text-label" for="gps">GPS:</label>
                                <div class="input-group input-group-merge">
                                    <input id="gps" type="text" required="" class="form-control form-control-prepended"
                                        placeholder="GPS" value="{{ old('gps') }}">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <span class="fas fa-igloo"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div> <!-- // END .modal-body -->
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveBTN" onclick="saveForm()">Save</button>
            </div> <!-- // END .modal-footer -->
        </div> <!-- // END .modal-content -->
    </div> <!-- // END .modal-dialog -->
</div>
<!-- ADD/EDIT FORM END-->

<!-- VIEW FORM START-->
<div id="modal-view" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-form-title"
    style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-form-title">Regional Management Office</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div> <!-- // END .modal-header -->
            <div class="modal-body">
                <div class="row g-3 ">
                    <div class="col-md-6">
                        <div class="me-1">Number:</div>
                        <div id="rmo_number" class="text-muted"></div>
                    </div>
                    <div class="col-md-6">
                        <div class="me-1">RMO Name:</div>
                        <div id="rmo_name" class="text-muted"></div>
                    </div>
                </div>
                <div class="row g-3 mt-2">
                    <div class="col-md-6">
                        <div class="me-1">RMO Abbreviation:</div>
                        <div id="rmo_abbreviation" class="text-muted"></div>
                    </div>
                    <div class="col-md-6">
                        <div class="me-1">Status:</div>
                        <div id="rmo_status" class="text-muted"></div>
                    </div>
                </div>
                <div class="row g-3 mt-2">
                    <div class="col-md-6">
                        <div class="me-1">Contact Name:</div>
                        <div id="rmo_contact_name" class="text-muted"></div>
                    </div>
                    <div class="col-md-6">
                        <div class="me-1">Phone Number:</div>
                        <div id="rmo_phone" class="text-muted"></div>
                    </div>
                </div>
                <div class="row g-3 mt-2">
                    <div class="col-md-6">
                        <div class="me-1">Email:</div>
                        <div id="rmo_email" class="text-muted"></div>
                    </div>
                    <div class="col-md-6">
                        <div class="me-1">GPS:</div>
                        <div id="rmo_gps" class="text-muted"></div>
                    </div>
                </div>
                <div class="row g-3 mt-2">
                    <div class="col-md-12 table-responsive">
                        <table id="contentTable" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th colspan="3" class="title">Provinces</th>
                                </tr>
                                <tr>
                                    <th>Number</th>
                                    <th>Name</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Table rows will be dynamically populated here -->
                            </tbody>
                        </table>
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
        url: site_url + 'api/rmo/list',
        type: 'POST',
        data: {
            '_token': '{{ csrf_token() }}'
        }
    },
    columns: [
        {
            data: null,
            visible: false, // Hide the column
            orderable: true, // Enable ordering on the column
            render: function (data, type, row) {
                return data.updated_at; // Return the value for ordering
            }
        },
        {
            data: 'number'
        },
        {
            data: 'name'
        },
        {
            data: 'abbreviation'
        },
        {
            data: 'status_name'
        },
        {
            data: 'contact_name'
        },
        {
            data: 'phone'
        },
        {
            data: 'email'
        },
        {
            data: 'gps'
        },
        {
            data: 'actions'
        }
    ],
    processing: true,
    order: [[0, 'desc']] // Apply descending order to the first column
});


function saveForm(id) {
    var url = site_url + 'api/rmo/save';
    var data = {
        '_token': '{{ csrf_token() }}',
        number: $('#number').val(),
        name: $('#name').val(),
        abbreviation: $('#abbreviation').val(),
        status: $('#status').val(),
        contact_name: $('#contact_name').val(),
        phone: $('#phone').val(),
        email: $('#email').val(),
        gps: $('#gps').val(),
    };
    if (!(id === undefined)) {
        url = site_url + 'api/rmo/update';
        data.id = id;
    }
    $.ajax({
        type: "POST",
        url: url,
        data: data,
        error: function(xhr, textStatus, errorThrown) {
            $.toaster({
                priority: 'danger',
                title: 'Info',
                message: xhr.responseJSON.message
            });
        },
        success: (function(data) {

            if ((id === undefined)) {
                $.toaster({
                    priority: 'success',
                    title: 'Info',
                    message: 'Record has been added successfull.'
                });
                $('#entry_edit_form').trigger("reset");
            } else {
                $.toaster({
                    priority: 'success',
                    title: 'Info',
                    message: 'Record has been updated successfully.'
                });
            }
            table.ajax.reload();
            $('#modal-form').removeClass('show');
            $('.modal-backdrop').remove();
        }),
        dataType: 'json'
    });
}

function closeModal() {
    $('#modal-confirm').removeClass('show');
    $('.modal-backdrop').remove();
}

function loadRecord(id) {
    $.ajax({
        type: "POST",
        url: site_url + 'api/rmo/show',
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
            $('#rmo_number').text(data.number);
            $('#rmo_name').text(data.name);
            $('#rmo_status').text(data.rmo_status);
            $('#rmo_abbreviation').text(data.abbreviation);
            $('#rmo_contact_name').text(data.contact_name);
            $('#rmo_phone').text(data.phone);
            $('#rmo_email').text(data.email);
            $('#rmo_gps').text(data.gps);
            $('#number').val(data.number);
            $('#status').val(data.status);
            $('#name').val(data.name);
            $('#abbreviation').val(data.abbreviation);
            $('#contact_name').val(data.contact_name);
            $('#phone').val(data.phone);
            $('#email').val(data.email);
            $('#gps').val(data.gps);
            $("#saveBTN").attr("onclick", "saveForm(" + data.id + ")");
            $("#saveBTN").html("Update");
            $("#modal-form-title").html("Regional Management Office");
            var contentsHtml = '';
            $.each(data.contents, function(key, value) {
                contentsHtml += '<tr>';
                contentsHtml += '<td>' + value.number + '</td>';
                contentsHtml += '<td>' + value.name + '</td>';
                contentsHtml += '<td>' + (value.status == 1 ? 'Active' : 'Inactive') + '</td>';
                contentsHtml += '</tr>';
            });
            $('#contentTable tbody').html(contentsHtml);

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
        url: site_url + 'api/rmo/delete',
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
    $("#modal-form-title").html("Regional management Office");
});
</script>

@stop