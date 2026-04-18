@extends('layouts.frontend.master_rtl')
@section('title')
    <title>SCA</title>
@endsection
@section('content')
    <div class="page-inner">
        <div class="container">

            <h2>{{ __('contact.contact') }}</h2>
            <p>{{ __('contact.contact_message') }}</p>
            <p style="color:red">{{ (session('msg') != '')?session('msg'):'' }}</p>
            @php
            session(['msg'=>'']);
            @endphp
            <div class="form-group subscribe_popup contactform">
                <form action="/{{ $lang }}/contact_submit" method="POST">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <input name="name" type="text" class="form-control form-control-lg"
                        placeholder="{{ __('contact.full_name') }}" >
                    <input name="email" class="form-control form-control-lg" type="email" required 
                        placeholder="{{ __('contact.email') }}" >
                   
                    <select name="province_id" id="province_id" class="form-control form-control-lg" required
                        >
                        <option selected>انتخاب {{ __('request_form.province') }}</option>
                        @foreach ($provinces as $province)
                            <option {{ old('province_id') == $province->id ? 'selected' : '' }} value="{{ $province->id }}">
                                {{ $province->name }}</option>
                        @endforeach
                    </select>
                    <select name="district_id" id="district_id" class="form-control form-control-lg" required
                        style="width: 500px;margin-top:10px">
                        <option selected>انتخاب {{ __('request_form.district') }}</option>
                        @foreach ($districts as $district)
                            <option {{ old('district_id') == $district->id ? 'selected' : '' }}
                                value="{{ $district->id }}">
                                {{ $district->name }}</option>
                        @endforeach
                    </select>
                    <input name="subject" class="form-control form-control-lg" type="subject" 
                    placeholder="{{ __('contact.subject') }}" >
                    <textarea name="message" placeholder="{{ __('contact.message') }}" class="form-control" style="width: 900px"
                        rows="10"></textarea>
                    <input class="btn btn-primary" type="submit" value="{{ __('contact.send') }}" >
                </form>
            </div>
        </div>
    </div>




@endsection
@section('styles')

@stop
@section('scripts')
<script src="{{ asset('assets/frontend/js/jquery-3.6.0.min.js') }}"></script>

<script type="text/javascript">
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