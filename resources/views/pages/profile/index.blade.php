@extends('layouts.master')
@section('title')
    <title>Student profile</title>
@endsection
@section('content')
<style>
body{
    margin-top:20px;
    color: #1a202c;
    text-align: left;
    background-color: #e2e8f0;    
}
.main-body {
    padding: 15px;
}
.card {
    box-shadow: 0 1px 3px 0 rgba(0,0,0,.1), 0 1px 2px 0 rgba(0,0,0,.06);
}

.card {
    position: relative;
    display: flex;
    flex-direction: column;
    min-width: 0;
    word-wrap: break-word;
    background-color: #fff;
    background-clip: border-box;
    border: 0 solid rgba(0,0,0,.125);
    border-radius: .25rem;
}

.card-body {
    flex: 1 1 auto;
    min-height: 1px;
    padding: 1rem;
}

.gutters-sm {
    margin-right: -8px;
    margin-left: -8px;
}

.gutters-sm>.col, .gutters-sm>[class*=col-] {
    padding-right: 8px;
    padding-left: 8px;
}
.mb-3, .my-3 {
    margin-bottom: 1rem!important;
}

.bg-gray-300 {
    background-color: #e2e8f0;
}
.h-100 {
    height: 100%!important;
}
.shadow-none {
    box-shadow: none!important;
}


/****TABS STYLES****/
.tab-wrap {
	 transition: 0.3s box-shadow ease;
	 border-radius: 6px;
	 max-width: 100%;
	 display: flex;
	 flex-wrap: wrap;
	 position: relative;
	 list-style: none;
	 background-color: #fff;
	 margin: 5px 0;
	 box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
}
 .tab-wrap:hover {
	 box-shadow: 0 12px 23px rgba(0, 0, 0, 0.23), 0 10px 10px rgba(0, 0, 0, 0.19);
}
 .tab {
	 display: none;
}
 .tab:checked:nth-of-type(1) ~ .tab__content:nth-of-type(1) {
	 opacity: 1;
	 transition: 0.5s opacity ease-in, 0.8s transform ease;
	 position: relative;
	 top: 0;
	 z-index: 100;
	 transform: translateY(0px);
	 text-shadow: 0 0 0;
}
 .tab:checked:nth-of-type(2) ~ .tab__content:nth-of-type(2) {
	 opacity: 1;
	 transition: 0.5s opacity ease-in, 0.8s transform ease;
	 position: relative;
	 top: 0;
	 z-index: 100;
	 transform: translateY(0px);
	 text-shadow: 0 0 0;
}
 .tab:checked:nth-of-type(3) ~ .tab__content:nth-of-type(3) {
	 opacity: 1;
	 transition: 0.5s opacity ease-in, 0.8s transform ease;
	 position: relative;
	 top: 0;
	 z-index: 100;
	 transform: translateY(0px);
	 text-shadow: 0 0 0;
}
 .tab:checked:nth-of-type(4) ~ .tab__content:nth-of-type(4) {
	 opacity: 1;
	 transition: 0.5s opacity ease-in, 0.8s transform ease;
	 position: relative;
	 top: 0;
	 z-index: 100;
	 transform: translateY(0px);
	 text-shadow: 0 0 0;
}
 .tab:checked:nth-of-type(5) ~ .tab__content:nth-of-type(5) {
	 opacity: 1;
	 transition: 0.5s opacity ease-in, 0.8s transform ease;
	 position: relative;
	 top: 0;
	 z-index: 100;
	 transform: translateY(0px);
	 text-shadow: 0 0 0;
}
 .tab:first-of-type:not(:last-of-type) + label {
	 border-top-right-radius: 0;
	 border-bottom-right-radius: 0;
}
 .tab:not(:first-of-type):not(:last-of-type) + label {
	 border-radius: 0;
}
 .tab:last-of-type:not(:first-of-type) + label {
	 border-top-left-radius: 0;
	 border-bottom-left-radius: 0;
}
 .tab:checked + label {
	 background-color: #fff;
	 box-shadow: 0 -1px 0 #fff inset;
	 cursor: default;
}
 .tab:checked + label:hover {
	 box-shadow: 0 -1px 0 #fff inset;
	 background-color: #fff;
}
 .tab + label {
	 box-shadow: 0 -1px 0 #eee inset;
	 border-radius: 6px 6px 0 0;
	 cursor: pointer;
	 display: block;
	 text-decoration: none;
	 color: #333;
	 flex-grow: 3;
	 text-align: center;
	 background-color: #f2f2f2;
	 user-select: none;
	 text-align: center;
	 transition: 0.3s background-color ease, 0.3s box-shadow ease;
	 height: 50px;
	 box-sizing: border-box;
	 padding: 15px;
}
 .tab + label:hover {
	 background-color: #f9f9f9;
	 box-shadow: 0 1px 0 #f4f4f4 inset;
}
 .tab__content {
	 padding: 10px 25px;
	 background-color: transparent;
	 position: absolute;
	 width: 100%;
	 z-index: -1;
	 opacity: 0;
	 left: 0;
	 transform: translateY(-3px);
	 border-radius: 6px;
}

</style>


<div class="container">
    <div class="main-body">
    
          <!-- Breadcrumb -->
          <nav aria-label="breadcrumb" class="main-breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="index.html">Home</a></li>
              <li class="breadcrumb-item"><a href="javascript:void(0)">User</a></li>
              <li class="breadcrumb-item active" aria-current="page">User Profile</li>
            </ol>
          </nav>
          <!-- /Breadcrumb -->
    
          <div class="row gutters-sm">
            <div class="col-md-4 mb-3">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex flex-column align-items-center text-center">
                    <img src="{{asset($rec['profile_image'])}}" alt="Admin" class="rounded-circle" width="150">
                    <div class="mt-3">
                      <h4>{{$rec['student_name']}} </h4>
                      <p class="text-secondary mb-1">{{$rec['student_gender']}}</p>
                      <p class="text-muted font-size-sm">{{$rec['school_name']}}</p>
                      <p class="text-muted font-size-sm">{{$rec['province_name']}} - {{$rec['district_name']}}</p>
                      {{-- <button class="btn btn-primary">Follow</button>
                      <button class="btn btn-outline-primary">Message</button> --}}
                    </div>
                  </div>
                </div>
              </div>
              {{-- <div class="card mt-3">
                <ul class="list-group list-group-flush">
                  <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                    <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-globe mr-2 icon-inline"><circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg>Website</h6>
                    <span class="text-secondary">https://bootdey.com</span>
                  </li>
                  <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                    <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-github mr-2 icon-inline"><path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22"></path></svg>Github</h6>
                    <span class="text-secondary">bootdey</span>
                  </li>
                  <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                    <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-twitter mr-2 icon-inline text-info"><path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"></path></svg>Twitter</h6>
                    <span class="text-secondary">@bootdey</span>
                  </li>
                  <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                    <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-instagram mr-2 icon-inline text-danger"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>Instagram</h6>
                    <span class="text-secondary">bootdey</span>
                  </li>
                  <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                    <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-facebook mr-2 icon-inline text-primary"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg>Facebook</h6>
                    <span class="text-secondary">bootdey</span>
                  </li>
                </ul>
              </div> --}}
            </div>
            <div class="col-md-8">
              <div class="card mb-3">
                <div class="card-body">
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Current Grade</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      {{$rec['grade_name']}} 
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Email</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        {{$rec['student_email']}} 
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Identification Number</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      {{$rec['identity_number']}}
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Last Login</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      {{$rec['last_seen']}}
                    </div>
                  </div>
                  {{--<hr>
                   <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Address</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      Bay Area, San Francisco, CA
                    </div>
                  </div>
                  <hr> --}}
                  {{-- <div class="row">
                    <div class="col-sm-12">
                      <a class="btn btn-info " target="__blank" href="https://www.bootdey.com/snippets/view/profile-edit-data-and-skills">Edit</a>
                    </div>
                  </div> --}}
                </div>
              </div>

              <div class="row gutters-sm">
                <div class="col-sm-12 mb-12">
                  <div class="tab-wrap">
                    @for ($i = count($rec['grades'])-1; $i >=0 ; $i--)
                        <input type="radio" id="tab{{$i+1}}" name="tabGroup1" class="tab" {{$i==count($rec['grades'])-1?'checked':''}}>
                        <label for="tab{{$i+1}}">{{$rec['grades'][$i]['grade_name']}}</label>
                    @endfor
                    {{-- separate loop because of the styling issue --}}
                    @for ($i = count($rec['grades'])-1; $i >=0 ; $i--)
                    <div class="tab__content">
                      <h2>subjects</h2>
                      <hr>
                        @for ($b = 0; $b < count($rec['grades'][$i]['subjects']) ; $b++)
                          {{-- <p>{{$rec['grades'][$i]['subjects'][$b]['subject_name']}} </p> --}}
                          <div class="panel-group">
                            <div class="panel panel-default">
                              <div class="panel-heading">
                                <h4 class="panel-title">
                                  <a data-toggle="collapse" href="#collapse{{$i.$b}}">{{$rec['grades'][$i]['subjects'][$b]['subject_name']}}</a>
                                </h4>
                              </div>
                              
                              <div id="collapse{{$i.$b}}" class="panel-collapse collapse">
                                {!! (count($rec['grades'][$i]['subjects'][$b]['chapters']) !=0)?"<h3>chapters</h3>":"" !!}
                                @for ($c = 0; $c < count($rec['grades'][$i]['subjects'][$b]['chapters']) ; $c++)
                                <ul class="list-group">
                                  
                                    <li class="list-group-item">
                                      <table>
                                        <thead>
                                          <tr>
                                            <th>Title</th>
                                            <th>Status</th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                          <tr>
                                            <td style="padding: 30px">{{$rec['grades'][$i]['subjects'][$b]['chapters'][$c]['name']}}</td>
                                            <td style="padding: 10px">{{($rec['grades'][$i]['subjects'][$b]['chapters'][$c]['state'] =='1')?'read':'unread'}}</td>
                                          </tr>
                                        </tbody>
                                      </table>
                                    </li>
                                  
                                </ul>
                                @endfor
                                {{-- <div class="panel-footer">Footer</div> --}}
                              </div>
                            </div>
                          </div>
                        @endfor
                        
                    </div>
                    @endfor
                    <!-- active tab on page load gets checked attribute -->
                    {{-- <input type="radio" id="tab1" name="tabGroup1" class="tab" checked>
                    <label for="tab1">Short</label>
                
                    <input type="radio" id="tab2" name="tabGroup1" class="tab">
                    <label for="tab2">Medium</label>
                
                    <input type="radio" id="tab3" name="tabGroup1" class="tab">
                    <label for="tab3">Long</label>

                    <input type="radio" id="tab4" name="tabGroup1" class="tab">
                    <label for="tab4">test</label>
                
                    <div class="tab__content">
                      <h3>Short Section</h3>
                      <p>Praesent nonummy mi in odio. Nullam accumsan lorem in dui. Vestibulum turpis sem, aliquet eget, lobortis pellentesque, rutrum eu, nisl. Nullam accumsan lorem in dui. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu.</p>
                    </div>
                
                    <div class="tab__content">
                      <h3>Medium Section</h3>
                      <p>Praesent nonummy mi in odio. Nullam accumsan lorem in dui. Vestibulum turpis sem, aliquet eget, lobortis pellentesque, rutrum eu, nisl. Nullam accumsan lorem in dui. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu.</p>
                
                      <p>In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Morbi mattis ullamcorper velit. Pellentesque posuere. Etiam ut purus mattis mauris sodales aliquam. Praesent nec nisl a purus blandit viverra.</p>
                    </div>
                
                    <div class="tab__content">
                      <h3>Long Section</h3>
                      <p>Praesent nonummy mi in odio. Nullam accumsan lorem in dui. Vestibulum turpis sem, aliquet eget, lobortis pellentesque, rutrum eu, nisl. Nullam accumsan lorem in dui. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu.</p>
                
                      <p>In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Morbi mattis ullamcorper velit. Pellentesque posuere. Etiam ut purus mattis mauris sodales aliquam. Praesent nec nisl a purus blandit viverra.</p>
                
                      <p>Praesent nonummy mi in odio. Nullam accumsan lorem in dui. Vestibulum turpis sem, aliquet eget, lobortis pellentesque, rutrum eu, nisl. Nullam accumsan lorem in dui. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu.</p>
                
                      <p>In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Morbi mattis ullamcorper velit. Pellentesque posuere. Etiam ut purus mattis mauris sodales aliquam. Praesent nec nisl a purus blandit viverra.</p>
                    </div>

                    <div class="tab__content">
                      <h3>test Section</h3>
                      <p>test</p>
                    </div> --}}
                
                  </div>
                  {{-- <div class="card h-100">
                    <div class="card-body">
                      <h6 class="d-flex align-items-center mb-3"><i class="material-icons text-info mr-2">assignment</i>Project Status</h6>
                      <small>Web Design</small>
                      <div class="progress mb-3" style="height: 5px">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                      <small>Website Markup</small>
                      <div class="progress mb-3" style="height: 5px">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: 72%" aria-valuenow="72" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                      <small>One Page</small>
                      <div class="progress mb-3" style="height: 5px">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: 89%" aria-valuenow="89" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                      <small>Mobile Template</small>
                      <div class="progress mb-3" style="height: 5px">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: 55%" aria-valuenow="55" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                      <small>Backend API</small>
                      <div class="progress mb-3" style="height: 5px">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: 66%" aria-valuenow="66" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                    </div>
                  </div> --}}
                </div>
                {{-- <div class="col-sm-6 mb-3">
                  <div class="card h-100">
                    <div class="card-body">
                      <h6 class="d-flex align-items-center mb-3"><i class="material-icons text-info mr-2">assignment</i>Project Status</h6>
                      <small>Web Design</small>
                      <div class="progress mb-3" style="height: 5px">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                      <small>Website Markup</small>
                      <div class="progress mb-3" style="height: 5px">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: 72%" aria-valuenow="72" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                      <small>One Page</small>
                      <div class="progress mb-3" style="height: 5px">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: 89%" aria-valuenow="89" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                      <small>Mobile Template</small>
                      <div class="progress mb-3" style="height: 5px">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: 55%" aria-valuenow="55" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                      <small>Backend API</small>
                      <div class="progress mb-3" style="height: 5px">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: 66%" aria-valuenow="66" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                    </div>
                  </div>
                </div> --}}
              </div>
            </div>
          </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

@stop
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
@stop