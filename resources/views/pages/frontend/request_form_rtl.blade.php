@extends('layouts.frontend.master')
@section('title')
    <title>SCA</title>
@endsection
@section('content')
    <div class="page-inner" style="direction: rtl">
        <div class="req_form_container">

            <h2>{{ __('request_form.request') }}</h2>
            <p>{{ __('request_form.request_access') }}</p>
            <p style="color:red">{{ (session('msg') != '')?session('msg'):'' }}</p>
            @php
            session(['msg'=>'']);
            @endphp
            <div class="form-group subscribe_popup req_form">
                <form action="/front/{{$lang}}/request_form_submit" method="POST">
                    <div class="">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                <select name="role" class="form-control form-control-lg" required id="role">
                                    <option selected>Select {{ __('request_form.role') }}</option>
                                    <option value='student'>{{ __('request_form.student') }}</option>
                                    <option value='parent'>{{ __('request_form.parent') }}</option>
                                    <option value='teacher'>{{ __('request_form.teacher') }}</option>
                                </select>
                                <select name="gender" class="form-control form-control-lg" required
                                    >
                                    <option selected>Select {{ __('request_form.gender') }}</option>
                                    <option value='male'>Male</option>
                                    <option value='female'>Female</option>
                                </select>
                                <input name="identity_number" class="form-control form-control-lg" type="text"
                                    name="" placeholder="{{ __('request_form.identity_number') }}"
                                    >
                                    <input name="phone_no" class="form-control form-control-lg" type="text" name=""
                                    placeholder="{{ __('request_form.phone') }}" >
                                    <select name="district_id" id="district_id" class="form-control form-control-lg" required
                                    style="width: 500px;margin-top:10px">
                                    <option selected>Select {{ __('request_form.district') }}</option>
                                    @foreach($districts as $district)
                                        <option {{old('district_id') == $district->id ? 'selected' : ''}}
                                            value="{{$district->id}}">
                                            {{$district->name}}</option>
                                        @endforeach
                                </select>
                                <select name="grade_id" id="grade_id" class="form-control form-control-lg"
                                    style="width: 500px;margin-top:10px">
                                    <option value="" selected>Select {{ __('request_form.grade') }}</option>
                                    @foreach($grades as $grade)
                                        <option {{old('grade_id') == $grade->id ? 'selected' : ''}}
                                            value="{{$grade->id}}">
                                            {{$grade->name}}</option>
                                        @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                            <input name="first_name" type="text" class="form-control form-control-lg" name=""
                            placeholder="{{ __('request_form.full_name') }}" >
                            <input name="dob" class="form-control form-control-lg" type="text" name=""
                                    placeholder="{{ __('request_form.date_of_birth') }}"
                                    >
                                    <input name="email" class="form-control form-control-lg" type="email" required
                                    name="" placeholder="{{ __('request_form.email') }}"
                                    >
                              
                                <select name="province_id" id="province_id" class="form-control form-control-lg" required
                                    style="width: 500px;margin-top:10px">
                                    <option selected>Select {{ __('request_form.province') }}</option>
                                    @foreach($provinces as $province)
                                        <option {{old('province_id') == $province->id ? 'selected' : ''}}
                                            value="{{$province->id}}">
                                            {{$province->name}}</option>
                                        @endforeach
                                </select>
                                
                                <select name="language" class="form-control form-control-lg" required id="language">
                                    <option selected>Select {{ __('request_form.language') }}</option>
                                    <option value='en'>{{ __('request_form.english') }}</option>
                                    <option value='da'>{{ __('request_form.dari') }}</option>
                                    <option value='pa'>{{ __('request_form.pashto') }}</option>
                                </select>
                               
                                <input name="password" class="form-control form-control-lg" type="text" name=""
                                    placeholder="{{ __('request_form.password') }}" >

                            </div>
                            <div class="col-md-6">
                                <input class="btn btn-primary" type="submit" value="{{ __('contact.send') }}"
                                style="width: 80px">

                            </div>
                        </div>
                    </div>




                </form>
            </div>
        </div>
    </div>




@endsection
@section('styles')

@stop
@section('scripts')

<script>
    $(document).ready(function() {
    $('#grade_id').show();
$('#role').change(function(){
    console.log('change value');
    if($('#role').val() != 'student') {
        $('#grade_id').hide();
    }else{
        $('#grade_id').show();
    }
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
</script>
@stop
