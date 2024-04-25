@extends('layouts.frontend.master')
@section('title')
    <title>SCA</title>
@endsection
@section('content')
    <div class="page-inner">
        <div class="container">
            <div class="row">
                <div class="col-md-7">
                    <h2>{{ __('contact.contact') }}</h2>
                    <p>{{ __('contact.contact_message') }}</p>
                    <p style="color:red">{{ (session('msg') != '')?session('msg'):'' }}</p>
                    @php
                    session(['msg'=>'']);
                    @endphp
                    <div class="form-group subscribe_popup contactform">
                    <form action="/front/{{ $lang }}/contact_submit" method="POST">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                            <input name="name" type="text" class="form-control form-control-lg" 
                                placeholder="{{ __('contact.full_name') }}" >
                            <input name="email" class="form-control form-control-lg" type="email" required 
                                placeholder="{{ __('contact.email') }}" >
                            <input name="subject" class="form-control form-control-lg" type="subject" 
                                placeholder="{{ __('contact.subject') }}" >
                            <select name="province_id" class="form-control form-control-lg" required
                                >
                                <option selected>Select {{ __('request_form.province') }}</option>
                                @foreach ($provinces as $province)
                                    <option {{ old('province_id') == $province->id ? 'selected' : '' }} value="{{ $province->id }}">
                                        {{ $province->name }}</option>
                                @endforeach
                            </select>
                            <select name="district_id" class="form-control form-control-lg" required
                                >
                                <option selected>Select {{ __('request_form.district') }}</option>
                                @foreach ($districts as $district)
                                    <option {{ old('district_id') == $district->id ? 'selected' : '' }}
                                        value="{{ $district->id }}">
                                        {{ $district->name }}</option>
                                @endforeach
                            </select>
                            <textarea name="message" placeholder="{{ __('contact.message') }}" class="form-control" style="width: 900px"
                                rows="10"></textarea>
                            <input class="btn btn-primary" type="submit" value="{{ __('contact.send') }}" >
                        </form>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="content">

                        <h1></h1>
                        <h2>Kabul Management Office, KMO</h2>
                        <p>For general inquiries ( Sunday – Thursday, 8:00 AM – 4:00 PM)<br>
                        Phone:<br>
                        +93 (0) 202320151<br>
                        +93 (0) 202320152<br>
                        +93 (0) 202320153<br>
                        +93 (0) 202320154<br>
                        +93 (0) 202320155</p>
                        <p>Or email us:&nbsp;<a href="mailto:info@sca.org.af">info@sca.org.af</a><br>
                        Your email will be forwarded to the relevant person</p>
                        <p>Postal Address:<br>
                        SCA, P.O. Box 27027, Kabul, Afghanistan</p>
                        <h2>Regional Offices</h2>
                        <p><a href="http://swedishcommittee.org/regional-offices/mazar-e-sharif-regional-office">Mazar Regional Management Office</a><br>
                        <a href="http://swedishcommittee.org/regional-offices/taloqan-regional-office">Taloqan Regional Management Office</a><br>
                        <a href="http://swedishcommittee.org/regional-offices/wardak-regional-office">Wardak Regional&nbsp;Management Office</a><br>
                        <a href="http://swedishcommittee.org/regional-offices/jalalabad-regional-office">Jalalabad Regional Management Office</a><br>
                        <a href="http://swedishcommittee.org/regional-offices/ghazni-regional-office">Ghazni Regional Management Office</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>




@endsection
@section('styles')

@stop
@section('scripts')

@stop
