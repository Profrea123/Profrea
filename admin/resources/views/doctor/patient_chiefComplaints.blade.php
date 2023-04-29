
@include('user.userheader')


<section class="bg-space-header">
    <div class="container">         
        <?php $segment = Request::segment(0); ?>
        <div class="row pt-5">
           <div class="col-md-4 clearfix">
               <h2 class="pract-head f1">Case Sheet</h2>
           </div>
           <div class="col-md-8 text-md-end">
                <a class="bck-btn" href="<?php echo $segment.'/booking-history'; ?>"> Back</a>
                <span class="clinicsbtn">
                    @if(isset($redirectDetails->complete_tab) && $redirectDetails->complete_tab == 10)
                        <a class="mx-md-3" href="{{ url('doctor/digital-prescription/'.$booking_no) }}">Digital Prescription</a>
                    @endif
                </span>
           </div>
        </div>

        <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="card card-style1 border-0">
                <div class="card-body p-0 pt-2">
                    @include('doctor.patient_details_top')
                </div>
            </div>
        </div>
                    <div class="col-md-12">
                            @if($errors->any())
                                <div class="alert alert-danger">
                                @foreach($errors->all() as $error)
                                    {{ $error }} </br>
                                @endforeach
                                </div>
                            @endif

                            @if(session('message'))
                                <div class="alert alert-success"> {{ session('message') }}</div>
                            @endif
                    
                   
                        <div class="accordion" id="accordionExample">
                            
                            <div class="accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                                @php 
                                    $redirectURL = 'javascript:void(0)';
                                    if(isset($redirectDetails->complete_tab) && $redirectDetails->complete_tab >=1){
                                        $redirectURL = url('doctor/update_redirection/1');
                                    }
                                @endphp
                                    <a class="accordion-button collapsed" type="button" href="{{ $redirectURL }}">
                                        <i class="fas fa-check-circle text-success pr-3"></i> Vital 
                                    </a>
                                </h2>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="">
                                <button class="accordion-button show" type="button" data-bs-toggle="collapse" data-bs-target="#Diagnosis" aria-expanded="false" aria-controls="Diagnosis">
                                    @if(isset($redirectDetails->complete_tab) && $redirectDetails->complete_tab >=2)
                                        <i class="fas fa-check-circle text-success pr-3"></i>
                                    @endif
                                    Chief Complaints
                                </button>
                                </h2>
                                <div id="Diagnosis" class="accordion-collapse collapse show" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <div class="row">
                                            <div class="col-md-6 offset-3">
                                                <div class="card">
                                                    <div class="card-header">
                                                        Chief Complaints  
                                                    </div>
                                                    <div class="card-body">
                                                    <h5 class="card-title">Complaints</h5>
                                                        <p class="card-text">
                                                            
                                                            @if(isset($patientChiefComplaints) && !empty($patientChiefComplaints))
                                                            <ol class="list-group list-group-numbered">
                                                                @foreach($patientChiefComplaints as $key => $c)
                                                                <li class="list-group-item"> {{ $c->complaint }} <a class="float-right" href="{{ url('doctor/patient-complaint-delete/'.$c->pcc_id) }}"><i class="fas fa-trash text-danger"></i></a> </li>
                                                                @endforeach
                                                            </ol>
                                                            @else
                                                            {{ 'No Data Found' }}
                                                            @endif
                                                        </p>
                                                    <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addComplaints">Add New Complaints</a>
                                                    </div>
                                                    
                                                    <div class="card-header">
                                                    Frequently used Complaints
                                                    </div>
                                                    <div class="card-body text-muted">
                                                        <p class="card-text">
                                                            @if(isset($chiefComplaints) && !empty($chiefComplaints))
                                                            <ol class="list-group list-group-numbered">
                                                                @foreach($chiefComplaints as $key => $c)
                                                                @php $jsonData = json_encode($c); @endphp
                                                                    <li class="list-group-item showpopup"> {{$c->complaint }} <a class="float-right" href="javascript:void(0)" data-value="{{ $jsonData }}"><i class="fas fa-plus-circle text-success"></i></a> </li>
                                                                @endforeach
                                                            </ol>   
                                                            @else
                                                                {{ 'No Data Found' }}
                                                            @endif
                                                        </p>
                                                        
                                                        @if(isset($redirectDetails->complete_tab) && $redirectDetails->complete_tab >=2)
                                                            <a href="{{ route('doctor.view-history') }}" class="btn btn-success">Next</a>
                                                        @endif

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="">
                                @php 
                                    $redirectURL = 'javascript:void(0)';
                                    if(isset($redirectDetails->complete_tab) && $redirectDetails->complete_tab >=3){
                                        $redirectURL = url('doctor/update_redirection/3');
                                    }
                                @endphp
                                    <a class="accordion-button collapsed" type="button" href="{{ $redirectURL }}">
                                        <i class="fas fa-check-circle text-success pr-3"></i> Patient's Medical & Family History 
                                    </a>
                                </h2>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="">
                                <!-- <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#vaults" aria-expanded="false" aria-controls="vaults">
                                    <i class="fas fa-check-circle text-success pr-3"></i> Patient Health vaults
                                </button> -->
                                @php 
                                    $redirectURL = 'javascript:void(0)';
                                    if(isset($redirectDetails->complete_tab) && $redirectDetails->complete_tab >=4){
                                        $redirectURL = url('doctor/update_redirection/4');
                                    }
                                @endphp
                                
                                <a class="accordion-button collapsed" type="button" href="{{ $redirectURL }}">
                                        <i class="fas fa-check-circle text-success pr-3"></i> Patient Health vaults 
                                    </a>
                                </h2>
                                                        
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingThree">
                                <!-- <button class="accordion-button show" type="button" data-bs-toggle="collapse" data-bs-target="#Notes" aria-expanded="false" aria-controls="Notes">
                                    Notes
                                </button> -->
                                @php 
                                    $redirectURL = 'javascript:void(0)';
                                    if(isset($redirectDetails->complete_tab) && $redirectDetails->complete_tab >=5){
                                        $redirectURL = url('doctor/update_redirection/5');
                                    }
                                @endphp
                                
                                <a class="accordion-button collapsed" type="button" href="{{ $redirectURL }}">
                                        <i class="fas fa-check-circle text-success pr-3"></i> Notes 
                                    </a>
                                </h2>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingThree">
                                @php 
                                $redirectURL = 'javascript:void(0)';
                                if(isset($redirectDetails->complete_tab) && $redirectDetails->complete_tab >=6){
                                    $redirectURL = url('doctor/update_redirection/6');
                                }
                            @endphp
                                <a class="accordion-button collapsed" type="button" href="{{ $redirectURL }}">
                                    <i class="fas fa-check-circle text-success pr-3"></i> Diagnosis/Provisional Diagnosis 
                                </a>
                                </h2>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header" id="">
                                @php 
                                    $redirectURL = 'javascript:void(0)';
                                    if(isset($redirectDetails->complete_tab) && $redirectDetails->complete_tab >=7){
                                        $redirectURL = url('doctor/update_redirection/7');
                                    }
                                @endphp
                                    <a class="accordion-button collapsed" type="button" href="{{ $redirectURL }}">
                                        <i class="fas fa-check-circle text-success pr-3"></i> Medication Prescribed
                                    </a>
                                </h2>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header" id="">
                                @php 
                                    $redirectURL = 'javascript:void(0)';
                                    if(isset($redirectDetails->complete_tab) && $redirectDetails->complete_tab >=8){
                                        $redirectURL = url('doctor/update_redirection/8');
                                    }
                                @endphp
                                    <a class="accordion-button collapsed" type="button" href="{{ $redirectURL }}">
                                        <i class="fas fa-check-circle text-success pr-3"></i> Diagnostic Tests
                                    </a>
                                </h2>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="">
                                @php 
                                    $redirectURL = 'javascript:void(0)';
                                    if(isset($redirectDetails->complete_tab) && $redirectDetails->complete_tab >=9){
                                        $redirectURL = url('doctor/update_redirection/9');
                                    }
                                @endphp
                                <a class="accordion-button collapsed" type="button" href="{{ $redirectURL }}">
                                        <i class="fas fa-check-circle text-success pr-3"></i>  Follow Up chat Days
                                    </a>
                                </h2>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="">
                                @php 
                                    $redirectURL = 'javascript:void(0)';
                                    if(isset($redirectDetails->complete_tab) && $redirectDetails->complete_tab >=10){
                                        $redirectURL = url('doctor/update_redirection/10');
                                    }
                                @endphp
                                <a class="accordion-button collapsed" type="button" href="{{ $redirectURL }}">
                                        <i class="fas fa-check-circle text-success pr-3"></i>  Advice/Instructions
                                    </a>
                                </h2>
                                
                            </div>

                        </div>
                    </div>
                </div>
        

     
                
        </div>
    </div>

</section>


 
<div class="modal fade" id="addComplaints" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Add Complaints</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{ route('doctor.casesheet.add-patient-chiefcomplaint') }}" method="post">
            @csrf
            <div class="form-group">
                <label for="complaint">Complaints</label>
                <input type="text" name="complaint" id="complaint" class="form-control" value="">
            </div>
            <div class="form-group">
                <label for="since">Since</label>
                <input type="text" name="since" id="since" class="form-control" value="">
            </div>
            <div class="form-group">
                <label for="course">Course</label>
                <input type="text" name="course" id="course" class="form-control" value="">
            </div>
            <div class="form-group">
                <label for="severity">Severity</label>
                <input type="text" name="severity" id="severity" class="form-control" value="">
            </div>
            
            <div class="form-group">
                <label for="details">Details</label>
                <textarea placeholder="Add details" name="details" class="form-control" id="details" ></textarea>
            </div>
            <input type="hidden" name="user_id" value="{{ Session::get('user_id') }}">
            <input type="hidden" name="booking_no" value="{{ Session::get('booking_no') }}">
            <input type="hidden" name="doctor_id" value="{{ Session::get('doctor_id') }}">
            <button type="submit" name="complaintSubmit" value="true" class="btn btn-primary mt-2">Save</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
    $('.showpopup').click('on',function(){
        var data = $(this).find('a').attr('data-value');
        var obj = JSON.parse(data);
        //var data = $(this).attr('data-value');
        console.log(data);
        // $('#staticBackdropLabel').html('Edit Condition');
        $('#complaint').val(obj.complaint);
        $('#since').val(obj.since);
        $('#course').val(obj.course);
        $('#severity').val(obj.severity);
        $('#details').val(obj.details);
        $('#addComplaints').modal('show');
    });

</script>