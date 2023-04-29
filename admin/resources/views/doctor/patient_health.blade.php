
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
                                <h2 class="accordion-header" id="">
                                <!-- <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#History" aria-expanded="false" aria-controls="History">
                                    <i class="fas fa-check-circle text-success pr-3"></i> Patient's Medical & Family History
                                </button> -->
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
                                <button class="accordion-button show" type="button" data-bs-toggle="collapse" data-bs-target="#vaults" aria-expanded="false" aria-controls="vaults">
                                @if(isset($redirectDetails->complete_tab) && $redirectDetails->complete_tab >=4)
                                <i class="fas fa-check-circle text-success pr-3"></i>  
                                @endif
                                Patient Health vaults 
                                </button>
                                </h2>
                                <div id="vaults" class="accordion-collapse collapse show" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <div class="p-2">
                                                <label for="">Patient's Medical Documnets</label>
                                                @if(!empty($attachment))
                                                <div class="d-block"> 
                                                    @foreach($attachment as $at)
                                                     <!-- <iframe src="<?php echo dirname(__DIR__).'/datafiles/uploads/patient_attachments/'.$at->attachment; ?>" frameborder="0" style="width:250px;"></iframe> -->
                                                    <span class="badge bg-primary">{{  $at->attachment }}</span> 
                                                    @endforeach
                                                </div>
                                                @else
                                                <p>No Data Found!</p>
                                                @endif

                                                
                                                @if(isset($redirectDetails->complete_tab) && $redirectDetails->complete_tab >=4)
                                                    <a href="{{ route('doctor.view-patient-notes') }}" class="btn btn-success">Next</a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                             
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header" id="">
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
                                <h2 class="accordion-header" id="">
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

 