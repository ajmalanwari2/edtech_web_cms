@extends('layouts.master')
@section('title')
    <title>Schools</title>
@endsection
@section('content')
    <div class="page__heading">
        <div class="container-fluid page__container">
            <h1 class="mb-0">Schools</h1>
        </div>
    </div>
    <div class="container-fluid page__container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-large bg-light d-flex align-items-center">
                        <div class="flex">
                            <div class="card-subtitle text-muted">List of Schools</div>
                        </div>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-form">Add New
                            Record</button>
                        <button type="button" class="btn btn-info" onclick="table.ajax.reload()"
                            style="margin-left: 5px;">Reload</button>

                    </div>
                    <div class="card-body">
                        <table id="school" class="display  table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th style="display:none">Updated at</th>
                                    <th>Number</th>
                                    <th>School Name</th>
                                    <th>RMO Name</th>
                                    <th>Province Name</th>
                                    <th>District Name</th>
                                    <th>Number of Grades</th>
                                    <th>Status</th>
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
                    <h5 class="modal-title" id="modal-form-title">School</h5>
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
                                    <label class="text-label" for="number">Number:</label>
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
                                    <label class="text-label" for="name">School Name:</label>
                                    <div class="input-group input-group-merge">
                                        <input id="name" type="text" required=""
                                            class="form-control form-control-prepended" placeholder="School Name"
                                            value="{{ old('name') }}">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <span class="far fa-id-card"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 mb-3">
                                    <label class="text-label" for="email">RMO Name:</label>
                                    <div class="input-group input-group-merge">
                                        <select id="regional_management_office_id" data-toggle="select"
                                            name="regional_management_office_id" class="form-control" required="">
                                            <option value="">select</option>
                                            @foreach ($regional_management_offices as $regional_management_office)
                                                <option
                                                    {{ old('regional_management_office_id') == $regional_management_office->id ? 'selected' : '' }}
                                                    value="{{ $regional_management_office->id }}">
                                                    {{ $regional_management_office->number }} -
                                                    {{ $regional_management_office->name }}</option>
                                            @endforeach
                                        </select>
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <span class="fas fa-igloo"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 mb-3">
                                    <label class="text-label" for="province_id">Province Name:</label>
                                    <div class="input-group input-group-merge">
                                        <select id="province_id" data-toggle="select" name="province_id"
                                            class="form-control" required="">
                                            <option value="">select</option>
                                            @foreach ($provinces as $province)
                                                <option {{ old('province_id') == $province->id ? 'selected' : '' }}
                                                    value="{{ $province->id }}">
                                                    {{ $province->number }} - {{ $province->name }}</option>
                                            @endforeach
                                        </select>
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <span class="fas fa-home"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 mb-3">
                                    <label class="text-label" for="district_id">District Name:</label>
                                    <div class="input-group input-group-merge">
                                        <select id="district_id" data-toggle="select" name="district_id"
                                            class="form-control" required="">
                                            <option value="">select</option>
                                            @foreach ($districts as $district)
                                                <option {{ old('district_id') == $district->id ? 'selected' : '' }}
                                                    value="{{ $district->id }}">
                                                    {{ $district->number }} - {{ $district->name }}</option>
                                            @endforeach
                                        </select>
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <span class="fas fa-warehouse"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 mb-3">
                                    <label class="text-label" for="grades">Grades:</label>
                                    <div class="input-group input-group-merge">
                                        <select id="grades" name="grades[]" required data-toggle="select" multiple
                                            class="form-control">
                                            @foreach ($grades as $grade)
                                                <option {{ old('grades') == $grade->id ? 'selected' : '' }}
                                                    value="{{ $grade->id }}">
                                                    {{ $grade->number }} - {{ $grade->name }}</option>
                                            @endforeach
                                        </select>
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <span class="fas fa-eye-slash"></span>
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
                    <h5 class="modal-title" id="modal-form-title">School</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div> <!-- // END .modal-header -->
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="me-1">Number:</div>
                            <div id="school_number" class="text-muted"></div>
                        </div>
                        <div class="col-md-6">
                            <div class="me-1">School Name:</div>
                            <div id="school_name" class="text-muted"></div>
                        </div>
                        <div class="col-md-6 mt-2">
                            <div class="me-1">RMO Name:</div>
                            <div id="school_rmo" class="text-muted"></div>
                        </div>
                        <div class="col-md-6 mt-2">
                            <div class="me-1">Province Name:</div>
                            <div id="school_province" class="text-muted"></div>
                        </div>
                        <div class="col-md-6 mt-2">
                            <div class="me-1">District Name:</div>
                            <div id="district_name" class="text-muted"></div>
                        </div>
                        <div class="col-md-6 mt-2">
                            <div class="me-1">Status:</div>
                            <div id="school_status" class="text-muted"></div>
                        </div>
                    </div>
                    <div class="row g-3 mt-2">
                        <div class="col-md-12 table-responsive">
                            <table id="subjects_table" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th colspan="3" class="title">List of School Grades</th>
                                    </tr>
                                    <tr>
                                        <th>Number</th>
                                        <th>Grade Name</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody id="grades_table_body"></tbody>
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
  .select2-results__options {
    height: 150px;
    overflow-y: auto;
}
    [dir=ltr] .select2-container--bootstrap4 .select2-selection--multiple {
        border: 1px solid #D52222 !important;
    }

    #subjects_table th.title {
        text-align: center;
    }

    #subjects_table {
        border-collapse: collapse;
    }

    #subjects_table th,
    #subjects_table td {
        padding: 5px;
    }

    #subjects_table tbody tr {
        height: 30px;
    }
</style>

<link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2.min.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/css/vendor-select2.css') }}" />

@stop
@section('scripts')
<script src="{{ asset('assets/vendor/select2/select2.min.js') }}"></script>
<script src="{{ asset('assets/js/select2.js') }}"></script>


<script type="text/javascript">
    var table = $('#school').DataTable({
        dom: 'Bfrtip',
        lengthMenu: [
            [10, 25, 50, -1],
            ['10 rows', '25 rows', '50 rows', 'Show all']
        ],
        buttons: ['pageLength', {
            extend: 'excelHtml5',

            exportOptions: {
                columns: [1, 2, 3, 4, 5, 6, 7]
            }
        }, ],
        serverSide: true,
        ajax: {
            url: site_url + 'api/school/list',
            type: 'POST',
            data: {
                '_token': '{{ csrf_token() }}'
            }
        },
        columns: [{
                data: null,
                visible: false,
                orderable: true,
                render: function(data, type, row) {
                    return data.updated_at;
                }
            },
            {
                data: 'number'
            },
            {
                data: 'name'
            },
            {
                data: 'school_rmo'
            },
            {
                data: 'school_province'
            },
            {
                data: 'district_name'
            },
            {
                data: 'grades'
            }, // New column for grades count
            {
                data: 'school_status'
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


    function saveForm(id) {
        var url = site_url + 'api/school/save';
        var data = {
            '_token': '{{ csrf_token() }}',
            number: $('#number').val(),
            name: $('#name').val(),
            province_id: $('#province_id').val(),
            regional_management_office_id: $('#regional_management_office_id').val(),
            district_id: $('#district_id').val(),
            status: $('#status').val(),
            grades: $("#grades").val(),
        };
        if (!(id === undefined)) {
            url = site_url + 'api/school/update';
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
            url: site_url + 'api/school/show',
            data: {
                id: id,
                '_token': '{{ csrf_token() }}'
            },
            fail: function() {
                $.toaster({
                    priority: 'danger',
                    title: 'Info',
                    message: 'There was an error loading the record.'
                });
            },
            success: function(data) {
                // Populate school details
                $('#school_number').text(data.number);
                $('#school_name').text(data.name);
                $('#school_province').text(data.school_province);
                $('#school_rmo').text(data.school_rmo);
                $('#district_name').text(data.district_name);
                $('#school_status').text(data.school_status);
                $('#number').val(data.number);
                $('#name').val(data.name);
                $('#province_id').val(data.province_id);
                $('#regional_management_office_id').val(data.regional_management_office_id);
                $('#district_id').val(data.district_id);
                $('#status').val(data.status);
                var grades = new Array();
                $.each(data.grades, function(key, value) {
                    grades.push(value.grade_id.id);
                });
                $('#grades').val(grades);
                $("#grades").trigger('change');
                // Populate grades table
                var gradesHtml = '';
                if (data.grades != null && data.grades.length > 0) {
                    $.each(data.grades, function(key, value) {
                        gradesHtml += '<tr>';
                        gradesHtml += '<td>' + value.grade_id.number + '</td>';
                        gradesHtml += '<td>' + value.grade_id.name + '</td>';
                        gradesHtml += '<td>' + (value.grade_id.status ? 'Active' : 'Inactive') +
                            '</td>';
                        gradesHtml += '</tr>';
                    });
                } else {
                    gradesHtml = '<tr><td colspan="3">No grades available.</td></tr>';
                }
                $('#grades_table_body').html(gradesHtml);

                // Update button and modal title
                $("#saveBTN").attr("onclick", "saveForm(" + data.id + ")");
                $("#saveBTN").html("Update");
                $("#modal-form-title").html("School");
            },
            dataType: 'json'
        });
    }
    var deleteRecordID = 0;

    function deleteRecord() {

        if (deleteRecordID == 0)
            return;

        $.ajax({
            type: "POST",
            url: site_url + 'api/school/delete',
            data: {
                id: deleteRecordID,
                '_token': '{{ csrf_token() }}'
            },
            fail: (function() {
                $.toaster({
                    priority: 'danger',
                    title: 'Info',
                    message: 'Failed when deleting record.'
                });
            }),
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
        $("#modal-form-title").html("School");
        $("#grades").val('').trigger('change');
    });

    $(document).ready(function() {
        $('#regional_management_office_id').change(function() {
            let pro_id = $(this).val();
            let data = {
                'rmo_id': $(this).val(),
                '_token': '{{ csrf_token() }}',
            };
            $.ajax({
                url: '/get_provinces',
                type: 'post',
                data: data,
                success: function(res) {
                    console.log(res);
                    $('#province_id').html(res);
                }
            });
        });
    });

    $(document).ready(function() {
        $('#province_id').change(function() {
            let pro_id = $(this).val();
            let data = {
                'pro_id': $(this).val(),
                '_token': '{{ csrf_token() }}',
            };
            $.ajax({
                url: '/get_districts',
                type: 'post',
                data: data,
                success: function(res) {
                    $('#district_id').html(res);
                }
            });
        });
    });
    $(document).ready(function() {
        $('#grades').select2();

        // $("#grades").select2({
        //     minimumInputLength: 1,
        //     tags: [],
        //     ajax: {
        //         url: site_url + 'api/grade/getGrades',
        //         dataType: 'json',
        //         type: "POST",
        //         quietMillis: 50,
        //         data: function(term) {
        //             return {
        //                 term: term,
        //                 '_token': '{{ csrf_token() }}'
        //             };
        //         },
        //         results: function(data) {
        //             return {
        //                 results: $.map(data, function(item) {
        //                     return {
        //                         text: item.name,
        //                         slug: item.number,
        //                         id: item.id
        //                     }
        //                 })
        //             };
        //         }
        //     }
        // });

    });
</script>

@stop
