
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
                                <!-- <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#Vital" aria-expanded="true" aria-controls="Vital" readonly>
                                    Vital
                                </button> -->
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
                                <button class="accordion-button show" type="button" data-bs-toggle="collapse" data-bs-target="#History" aria-expanded="false" aria-controls="History">
                                    
                                @if(isset($redirectDetails->complete_tab) && $redirectDetails->complete_tab >=3)
                                <i class="fas fa-check-circle text-success pr-3"></i>  
                                @endif
                                    Patient's Medical & Family History
                                </button>
                                </h2>
                                <div id="History" class="accordion-collapse collapse show" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                        
                                        <form action="{{ route('doctor.casesheet.add-family-history') }}" method="post">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="heig" class="form-label">Medical History</label>
                                                <input type="text" class="form-control" id="medical" name="medical" value="{{ isset($medical_history->medical)?$medical_history->medical:'' }}">
                                            </div>
                                            <div class="mb-3">
                                                <label for="weig" class="form-label">Medication History</label>
                                                <input type="text" class="form-control" id="medication" name="medication" value="{{ isset($medical_history->medication)?$medical_history->medication:'' }}">
                                            </div>
                                            <div class="mb-3">
                                                <label for="bp" class="form-label">Surgical History</label>
                                                <input type="text" class="form-control" id="surgical" name="surgical" value="{{ isset($medical_history->surgical)?$medical_history->surgical:'' }}">
                                            </div>
                                            <div class="mb-3">
                                                <label for="temp" class="form-label"> Drug Allergies</label>
                                                <input type="text" class="form-control" id="drug" name="drug" value="{{ isset($medical_history->drug)?$medical_history->drug:'' }}">
                                            </div>
                                            <div class="mb-3">
                                                <label for="temp" class="form-label"> Diet Allergies/Restrictions </label>
                                                <input type="text" class="form-control" id="restrictions" name="restrictions" value="{{ isset($medical_history->restrictions)?$medical_history->restrictions:'' }}">
                                            </div>
                                            <div class="mb-3">
                                                <label for="temp" class="form-label"> Personal History, Lifestyle & Habits</label>
                                                <input type="text" class="form-control" id="habits" name="habits" value="{{ isset($medical_history->habits)?$medical_history->habits:'' }}">
                                            </div>
                                            <div class="mb-3">
                                                <label for="temp" class="form-label">Environmentel & Occupation History</label>
                                                <input type="text" class="form-control" id="occupation" name="occupation" value="{{ isset($medical_history->occupation)?$medical_history->occupation:'' }}">
                                            </div>
                                            <div class="mb-3">
                                                <label for="temp" class="form-label">Family Medical History</label>
                                                <input type="text" class="form-control" id="family_history" name="family_history" value="{{ isset($medical_history->family_history)?$medical_history->family_history:'' }}">
                                            </div>
                                            <input type="hidden" name="id" value="{{ isset($medical_history->m_id)?$medical_history->m_id:'' }}">
                                            <input type="hidden" name="user_id" value="{{ Session::get('user_id') }}">
                                            <input type="hidden" name="booking_no" value="{{ Session::get('booking_no') }}">
                                            <input type="hidden" name="doctor_id" value="{{ Session::get('doctor_id') }}">
                                            <button type="submit" name="historySubmit" value="true" class="btn btn-primary">Save</button>
                                           
                                            @if(isset($redirectDetails->complete_tab) && $redirectDetails->complete_tab >=3)
                                            <a href="{{ route('doctor.view-patient-health') }}" class="btn btn-success">Next</a>
                                            @endif
                                        </form>

                                    </div>
                                </div>
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

 