<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login</title>

    <!-- Prevent the demo from appearing in search engines -->
    <meta name="robots" content="noindex">

@include('layouts.partial.css')
<style>
    .layout-login-centered-boxed__form{
        max-width: 50rem !important;
        min-width: calc(325px + 22rem * 2) !important;
    }
   
    </style>
</head>

<body class="layout-login-centered-boxed">
    <div class="layout-login-centered-boxed__form">
        <div class="d-flex flex-column justify-content-center align-items-center mt-2 mb-2 navbar-light">
            <a href="index.html" class="navbar-brand text-center mb-2 mr-0" style="min-width: 0">
                <!-- LOGO -->
                <svg width="26px" viewBox="0 0 27 26" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                    <g id="drawer-logo-wrapper" stroke="none" stroke-width="1" fill="currentColor" fill-rule="evenodd">
                        <path d="M21.9257604,14.9506975 C20.582703,15.0217165 19.3145795,14.3502722 18.6558508,13.2193504 C18.5961377,13.1299507 18.488013,13.0821416 18.3788008,13.0968482 C18.2695887,13.1115549 18.1791809,13.1860986 18.1471473,13.287853 L16.3403333,18.8266167 C16.0783106,19.5012544 15.4036423,19.9432488 14.6567374,19.9295884 C13.9098324,19.915928 13.2530282,19.4495818 13.0177202,18.7658483 L10.3561926,9.20532122 C10.3224612,9.0828362 10.2066255,8.99820016 10.075223,9.00002907 C9.94382048,9.00185799 9.83056595,9.0896826 9.8005142,9.21305538 C9.53809432,10.6490488 9.07561673,12.0442508 8.42563983,13.3607751 C7.81040896,14.4321066 6.59978897,15.0547797 5.33446397,14.9506975 L0.286383595,14.9506975 C0.200836429,14.9508269 0.119789989,14.987678 0.0652579686,15.0512416 C0.0105052402,15.1148427 -0.011403821,15.1989481 0.00568007946,15.2799517 C1.26517458,21.5063521 6.92177656,26 13.500072,26 C20.0783674,26 25.7349694,21.5063521 26.9944639,15.2799517 C27.0112295,15.1987308 26.9894777,15.1145345 26.935158,15.050392 C26.8808383,14.9862496 26.7996356,14.9488738 26.7137603,14.9484877 C23.5217604,14.9499609 21.9257604,14.9506975 21.9257604,14.9506975 Z" opacity="0.539999962"></path>
                        <path d="M5.48262697,13.1162874 C6.53570764,13.1162874 6.62233928,13.1162874 7.63604194,9.25361392 C7.86780969,8.37139838 8.14008055,7.33311522 8.48548201,6.11058557 C8.7087856,5.42413873 9.37946641,4.96506482 10.1258577,4.98776578 C10.8742462,4.96784002 11.5440567,5.43246093 11.761733,6.1225074 L14.4619398,15.7986995 C14.4940991,15.9151627 14.6022445,15.9971672 14.7273152,15.9999282 C14.8523859,16.0026893 14.9643174,15.9255432 15.0019812,15.8106214 L16.5152221,11.1654422 C16.7421482,10.5403405 17.3447552,10.1140124 18.0318383,10.0924774 C18.6964712,10.0434044 19.3301356,10.3708193 19.6553377,10.9313408 C19.7678463,11.1405147 19.8803549,11.3453535 19.9759873,11.5426056 C20.6296623,12.8128226 20.8198019,13.1119522 21.7761252,13.1119522 L26.7186288,13.1119522 C26.7943575,13.1119652 26.8669186,13.0826781 26.9200192,13.030667 C26.9730799,12.97881 27.0019231,12.9083695 26.9999003,12.8355824 C26.9032945,5.71885474 20.8862135,-0.00118613704 13.4977698,1.84496545e-07 C6.10932623,0.00118650603 0.0942250201,5.72315932 8.19668591e-05,12.8399177 C-0.00175692205,12.9131783 0.0274115935,12.9840093 0.080884445,13.0361333 C0.134357296,13.0882573 0.207535985,13.1171917 0.283603687,13.1162874 L5.48262697,13.1162874 Z"></path>
                    </g>
                </svg>

                <span class="ml-2">User Request Form</span>
            </a>
        </div>

        <div class="card card-body">

        <form>
                        @csrf
                <div class="form-row">
                    <div class="col-12 col-md-6 mb-3">
                        <label class="text-label" for="first_name">First Name:</label>
                        <div class="input-group input-group-merge">
                            <input id="first_name"  name="first_name" type="text" required="" class="form-control form-control-prepended" placeholder="First Name">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <span class="far fa-user"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 mb-3">
                    <label class="text-label" for="email">Last Name:</label>
                        <div class="input-group input-group-merge">
                            <input id="last_name"  name="last_name" type="text" required="" class="form-control form-control-prepended" placeholder="Last Name">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <span class="far fa-user-circle"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-12 col-md-6 mb-3">
                        <label class="text-label" for="father_name">Father Name:</label>
                        <div class="input-group input-group-merge">
                            <input id="father_name"  name="father_name" type="text" required="" class="form-control form-control-prepended" placeholder="Father Name">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                <span class="far fa-user-circle"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 mb-3">
                        <label class="text-label" for="father_name">DOB:</label>
                        <div class="input-group input-group-merge">
                            <input id="dob"  name="dob" type="text" required="" class="form-control form-control-prepended" placeholder="DOB">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                <span class="far fa-user-circle"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 mb-3">
                    <label class="text-label" for="identity_number">Identity Number:</label>
                        <div class="input-group input-group-merge">
                            <input id="identity_number" name="identity_number" type="text" required="" class="form-control form-control-prepended" placeholder="Identity Number">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                <span class="far fa-user-circle"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 mb-3">
                    <label class="text-label" for="email">Gender:</label>
                        <div class="input-group input-group-merge">
                            <select id="gender" data-toggle="select" name="gender" class="form-control" required="">
                                            <option value="" >Select</option>
                                            <option value="male" >male</option>
                                            <option value="female" >female</option>
                                        </select>
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <span class="far fa-user"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-12 col-md-6 mb-3">
                        <label class="text-label" for="email">Email Address:</label>
                            <div class="input-group input-group-merge">
                                <input id="email"  name="email" type="email" required="" class="form-control form-control-prepended" placeholder="john@doe.com">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <span class="far fa-envelope"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 mb-3">
                            <label class="text-label" for="phone_no">Phone:</label>
                            <div class="input-group input-group-merge">
                                <input id="phone_no"  name="phone_no" type="text" required="" class="form-control form-control-prepended" placeholder="Phone">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <span class="fas fa-mobile-alt"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="form-row">
                    <div class="col-12 col-md-6 mb-3">
                        <label class="text-label" for="role">Role:</label>
                        <div class="input-group input-group-merge">
                        <select id="role" data-toggle="select" name="role" class="form-control" required>
                                            <option value="" >Select</option>
                                            <option value="student" >student</option>
                                            <option value="parent" >parent</option>
                                            <option value="teacher" >teacher</option>
                                            <option value="guest" >guest</option>
                                        </select>
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                <span class="fas fa-biking"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 mb-3">
                    <label class="text-label" for="province_id">Province:</label>
                        <div class="input-group input-group-merge">
                        <select id="province_id" data-toggle="select" name="province_id" class="form-control" required>
                                    <option value="">select</option>
                                    @foreach($provinces as $province)
                                    <option {{old('province_id') == $province->id ? 'selected' : ''}}
                                            value="{{$province->id}}">
                                            {{$province->name}}</option>
                                    @endforeach
                                </select>
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <span class="fas fa-chalkboard-teacher"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-12 col-md-6 mb-3">
                        <label class="text-label" for="district_id">District:</label>
                        <div class="input-group input-group-merge">
                        <select id="district_id" data-toggle="select" name="district_id" class="form-control" required="">
                                    <option value="">select</option>
                                </select>
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <span class="far fa-id-card"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 mb-3">
                    <label class="text-label" for="school_id">School:</label>
                        <div class="input-group input-group-merge">
                        <select id="school_id" data-toggle="select" name="school_id" class="form-control">
                                    <option value="">select</option>
                                    @foreach($schools as $school)
                                    <option {{old('school_id') == $school->id ? 'selected' : ''}}
                                            value="{{$school->id}}">
                                            {{$school->name}}</option>
                                    @endforeach
                                </select>
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <span class="fas fa-restroom"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                <div class="col-12 col-md-6 mb-3">
                    <label class="text-label" for="school_id">Grade:</label>
                        <div class="input-group input-group-merge">
                <select id="grade_id" data-toggle="select" name="grade_id" class="form-control">
                                    <option value="">select</option>
                                    @foreach($grades as $grade)
                                    <option {{old('grade_id') == $grade->id ? 'selected' : ''}}
                                            value="{{$grade->id}}">
                                            {{$grade->name}}</option>
                                    @endforeach
                                </select>
                                <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <span class="fas fa-address-book"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 mb-3">
                    <label class="text-label" for="password">Password:</label>
                    <div class="input-group input-group-merge">
                        <input id="password" type="password" name="password" required="" class="form-control form-control-prepended" placeholder="Enter your password">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <span class="fa fa-key"></span>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
                <div class="form-row">
                            <div class="col-12 col-md-6 mb-3">
                <button type="button" class="btn btn-primary" id="saveBTN" onclick="saveForm()">Submit</button>
</div>
            </form>
            
</div>
        </div>
    </div>
    @include('layouts.partial.js')
<script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>

<script type="text/javascript">
var base_url ='{{ config('app.app_url') }}';
function saveForm(id) {
    var url =base_url+'api/request/save';
    var data = {
        '_token': '{{ csrf_token() }}',
        first_name: $('#first_name').val(),
        identity_number: $('#identity_number').val(),
        last_name: $('#last_name').val(),
        father_name: $('#father_name').val(),
        gender: $('#gender').val(),
        dob: $('#dob').val(),
        email: $('#email').val(),
        phone_no: $('#phone_no').val(),
        role: $('#role').val(),
        province_id: $('#province_id').val(),
        district_id: $('#district_id').val(),
        school_id: $('#school_id').val(),
        grade_id: $('#grade_id').val(),
        password: $('#password').val(),
    };
    if (!(id === undefined)) {
        url =base_url+'api/request/update';
        data.id = id;
    }
    $.ajax({
        type: "POST",
        url: url,
        data: data,
        fail: (function() {
            $.toaster({
                priority: 'danger',
                title: 'Info',
                message: 'There was error saving record.'
            });
        }),
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
        }),
        dataType: 'json'
    });
}

$(document).ready(function(){
    $('#province_id').change(function(){
       let pro_id = $(this).val();
       let data = {
        'pro_id': $(this).val(),
        '_token': '{{ csrf_token() }}',
       };
       $.ajax({
            url: '/get_districts',
            type: 'post',
            data : data,
            success: function(res){
                $('#district_id').html(res);
            }
       });
    });
});

</script>

</body>

</html>



