@extends('layouts.master')
@section('title')
<title>Students</title>
@endsection
@section('content')
<div class="page__heading">
    <div class="container-fluid page__container">
        <h1 class="mb-0">Student Parents</h1>
    </div>
</div>
<div class="container-fluid page__container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-large bg-light d-flex align-items-center">
                    <div class="flex">
                        <div class="card-subtitle text-muted">List of Student Parents</div>
                    </div>
                    <a class="btn btn-danger" href="{{ route('dashboard.index') }}" style="margin-right: 5px;">Back</a>
                    <button type="button" class="btn btn-info" onclick="table.ajax.reload()"
                        style="margin-left: 5px;">Reload</button>

                </div>
                <div class="card-body">
                    <table id="course" class="display  table-bordered" style="width:100%">
                        <thead>
                            <tr>
                            <th style="display:none">Updated at</th>
                                <th>Full Name</th>
                                <th>Identification Number</th>
                                <th>School Name</th>
                                <th>Grade Name</th>
                                <th>Phone Number</th>
                                <th>Email Address</th>
                                <th>Province</th>
                                <th>Gender</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('styles')
<style>
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
    var provinceId= {{$province_id}};
var table = $('#course').DataTable({
    serverSide: true,
    ajax: {
        url: site_url + 'api/dashboard/grade-parent-list',
        type: 'POST',
        data: {
            province_id: provinceId,
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
            data: 'full_name'
        },
        {
            data: 'indentification_number'
        },
        {
            data: 'school_name'
        },
        {
            data: 'grade_name'
        },
        {
            data: 'phone_number'
        },
        {
            data: 'email'
        },
        {
            data: 'province_name'
        },
        {
            data: 'gender'
        }
    ],
    processing: true,
    order: [[0, 'desc']] // Apply descending order to the first column
});




function closeModal(){
    $('#modal-confirm').removeClass('show');
    $('.modal-backdrop').remove();
}

</script>

@stop