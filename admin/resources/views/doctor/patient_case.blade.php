
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
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#Vital" aria-expanded="true" aria-controls="Vital">
                                        
                                    @if(isset($redirectDetails->complete_tab) && $redirectDetails->complete_tab >=1)
                                        <i class="fas fa-check-circle text-success pr-3"></i>  
                                    @endif
                                    
                                    Vital
                                    </button>
                                    </h2>
                                    <div id="Vital" class="accordion-collapse collapse show" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            
                                            <form action="{{ route('doctor.casesheet.add-vital') }}" method="post">
                                                @csrf
                                                <div class="row">
                                                <div class="col-md-3 mb-3">
                                                    <label for="heig" class="form-label">Height <span>*</span></label>
                                                    <input type="text" class="form-control" id="heig" name="height" value="{{ isset($vital->height)?$vital->height:'' }}" required>
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <label for="weig" class="form-label">Weight (Kgs) <span>*</span></label>
                                                    <input type="text" class="form-control" id="weig" name="weight" value="{{ isset($vital->weight)?$vital->weight:'' }}" required>
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <label for="bp" class="form-label">BP(mm hg) <span>*</span></label>
                                                    <input type="text" class="form-control" id="bp" name="blood_pressure" value="{{ isset($vital->blood_pressure)?$vital->blood_pressure:'' }}" required>
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <label for="temp" class="form-label">Temperature (°F) <span>*</span></label>
                                                    <input type="text" class="form-control" id="temp" name="temperature" value="{{ isset($vital->temperature)?$vital->temperature:'' }}" required>
                                                </div>
                                                </div>
                                                <input type="hidden" name="v_id" value="{{ isset($vital->v_id)?$vital->v_id:'' }}">
                                                <input type="hidden" name="user_id" value="{{ $booking_details->user_id }}">
                                                <input type="hidden" name="doctor_id" value="{{ $booking_details->doctor_id }}">
                                                <input type="hidden" name="booking_no" value="{{ $booking_details->booking_no }}">
                                                <button type="submit" name="vitalSubmit" value="true" class="btn btn-primary">Save</button>
                                                    @if(isset($redirectDetails->complete_tab) && $redirectDetails->complete_tab >=1)
                                                        <a href="{{ route('doctor.chief-complaints') }}" class="btn btn-success">Next</a>
                                                    @endif
                                            </form>

                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingThree">
                                    <!-- <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#History" aria-expanded="false" aria-controls="History">
                                        Patient's Medical & Family History
                                    </button>                                 -->
                                    @php 
                                    $redirectURL = 'javascript:void(0)';
                                    if(isset($redirectDetails->complete_tab) && $redirectDetails->complete_tab >=2){
                                        $redirectURL = url('doctor/update_redirection/2');
                                    }
                                    @endphp
                                    <a class="accordion-button collapsed" type="button" href="{{ $redirectURL }}">
                                        <i class="fas fa-check-circle text-success pr-3"></i> Chief Complaints 
                                    </a>
                                    </h2>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingThree">
                                    <!-- <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#History" aria-expanded="false" aria-controls="History">
                                        Patient's Medical & Family History
                                    </button>                                 -->
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
                                    <h2 class="accordion-header" id="headingThree">
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
                                    <h2 class="accordion-header" id="headingThree">
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
                                    <h2 class="accordion-header" id="headingThree">
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
                                    <h2 class="accordion-header" id="headingThree">
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
                                    <h2 class="accordion-header" id="headingThree">
                                    <!-- <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#Instructions" aria-expanded="false" aria-controls="Instructions">
                                    Advice/Instructions
                                    </button> -->
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
    