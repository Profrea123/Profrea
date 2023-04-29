
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
                                <button class="accordion-button show" type="button" data-bs-toggle="collapse" data-bs-target="#Prescribed" aria-expanded="false" aria-controls="Prescribed">
                                    @if(isset($redirectDetails->complete_tab) && $redirectDetails->complete_tab >=7)
                                    <i class="fas fa-check-circle text-success pr-3"></i>
                                    @endif
                                    Medication Prescribed
                                </button>
                                </h2>
                                <div id="Diagnosis" class="accordion-collapse collapse show" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <div class="row">
                                            <div class="col-md-6 offset-3">
                                                <div class="card">
                                                    <div class="card-header">
                                                        Medication  
                                                    </div>
                                                    <div class="card-body">
                                                    <h5 class="card-title">Medicine</h5>
                                                        <p class="card-text">
                                                            
                                                            @if(isset($patient_medication) && $patient_medication !='')
                                                            <ol class="list-group list-group-numbered">
                                                                @foreach($patient_medication as $key => $c)
                                                                    @php $json = json_encode($c); @endphp
                                                                <li class="list-group-item"> {{ $c->medicine_name }}
                                                                    <span class="float-right"> 
                                                                    <a href="javascript:void(0)" class="editMedi" data-value="{{ $json }}"><i class="fas fa-pencil-alt text-primary"></i></a>  
                                                                    <a href="{{ url('doctor/patient-medicine-delete/'.$c->pm_id) }}" onclick="return deleteFn()"><i class="fas fa-trash text-danger"></i></a> </span></li>
                                                                @endforeach
                                                            </ol>
                                                            @else
                                                            {{ 'No Data Found' }}
                                                            @endif
                                                        </p>
                                                    <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addMedication">Add New Medicine</a>
                                                    </div>
                                                    <div class="card-header">
                                                    Frequently used medications
                                                    </div>
                                                    <div class="card-body text-muted">
                                                        <p class="card-text">
                                                            @if(isset($prescription) && $prescription !='')
                                                                <ol class="list-group list-group-numbered">
                                                                    @foreach($prescription as $key => $c)
                                                                    @php $json = json_encode($c); @endphp
                                                                    <li class="list-group-item editMedicine"> {{$c->medicine_name }} <a class="float-right" href="javascript:void(0)" data-value="{{ $json }}"><i class="fas fa-plus-circle text-success"></i></a> </li>
                                                                    @endforeach
                                                                </ol>
                                                                @else
                                                                {{ 'No Data Found' }}
                                                            @endif
                                                        </p>
                                                        @if(isset($redirectDetails->complete_tab) && $redirectDetails->complete_tab >=7)
                                                            <a href="{{ route('doctor.view-patient-diagnosis') }}" class="btn btn-success">Next</a>
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


<div class="modal fade" id="addMedication" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Add Medication</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{ route('doctor.casesheet.add-patient-medication') }}" method="post">
            @csrf       
                    <div class="mb-3" id="input_medicine">
                        <label for="new_medicine" class="form-label">Medicine</label>
                        <input type="text" class="form-control" id="new_medicine" name="medicine_name" placeholder="Enter Medicine Name" required>
                    </div>

                    <div class="row">
                        <div class="mb-3 col-4">
                            <label for="" class="form-label">How to</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="how_to" value="take" id="takecheckbox" required>
                                <label class="form-check-label" for="takecheckbox">
                                    Take
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="how_to" value="apply" id="applycheckbox">
                                <label class="form-check-label" for="applycheckbox">
                                    Apply
                                </label>
                            </div>
                        </div>
                    
                        <div class="mb-3 col-8 d-flex">
                            <div class="m-2">
                                <label for="drqty" class="form-label">Quantity</label>
                                <input type="number" name="qty" step=".01" min="1" class="form-control" id="drqty" required>
                            </div>
                            <div class="m-2">
                                <label for="drmed" class="form-label">Medication</label>
                                <select name="medication" class="form-select" id="drmed" required>
                                    <option value="tablets">Tablets</option>
                                    <option value="liquid">Liquid</option>
                                    <option value="capsules">Capsules</option>
                                    <option value="injections">Injections</option>
                                </select>
                            </div>
                            <div class="m-2">
                                <label for="drintake" class="form-label">Intake</label>
                                <select name="repetition" id="drintake" class="form-select" required>
                                    <option value="1">Once a day</option>
                                    <option value="2">Twice a day</option>
                                    <option value="3">Thrice a day</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <h4 class="text-warning">Custom</h4>
                        <label class="" for="exampleCheck1">In the</label>
                        <div class="mb-3 d-flex checkbox-group required">
                            <div class="form-check m-1">
                                <input class="form-check-input" type="checkbox" name="in_the[]" value="morning" id="morcheckbox">
                                <label class="form-check-label" for="morcheckbox">
                                    Morning
                                </label> 
                            </div>
                            
                            <div class="form-check m-1">
                                <input class="form-check-input" type="checkbox" name="in_the[]" value="noon" id="nooncheckbox">
                                <label class="form-check-label" for="nooncheckbox">
                                    Noon
                                </label>
                            </div>
                            
                            <div class="form-check m-1">
                                <input class="form-check-input" type="checkbox" name="in_the[]" value="evening" id="eveningcheckbox">
                                <label class="form-check-label" for="eveningcheckbox">
                                Evening
                                </label>
                            </div>
                            
                            <div class="form-check m-1">
                                <input class="form-check-input" type="checkbox" name="in_the[]" value="night" id="inghtcheckbox">
                                <label class="form-check-label" for="inghtcheckbox">
                                Night
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="mb-3 col-4">
                            <label class="">When</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="when_to_take" value="afterFood" id="afterFood" required>
                                <label class="form-check-label" for="afterFood">
                                    After Food
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="when_to_take" value="beforeFood" id="beforeFood">
                                <label class="form-check-label" for="beforeFood">
                                    Before Food
                                </label>
                            </div>
                        </div>
                        
                        <div class="mb-3 col-8 d-flex">
                            <div class="m-1">
                                <label class="form-label" for="forcheckbox">Medicine Course for</label>
                                <input class="form-control" type="number" name="course_time" value="" id="forcheckbox" required>
                            </div>
                            
                            <div class="m-1">
                                <label class="form-label" for="ducheckbox"> Duration</label>
                                <select name="course_duration" id="ducheckbox" class="form-select">
                                    <option value="day">Day</option>
                                    <option value="month">Month</option>
                                    <option value="year">Year</option>
                                </select>
                            </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="instNotes" class="form-label">Instruction / Notes</label>
                        <textarea class="form-control" name="instNotes" id="instNotes" rows="3"></textarea>
                    </div>

                    
                    <input type="hidden" name="id" id="pm_id" value="{{ isset($patient_medication->pm_id)?$patient_medication->pm_id:'' }}">
                    <input type="hidden" name="user_id" value="{{ Session::get('user_id') }}">
                    <input type="hidden" name="booking_no" value="{{ Session::get('booking_no') }}">
                    <input type="hidden" name="doctor_id" value="{{ Session::get('doctor_id') }}">
                    <div class="row">
                        <div class="col-md-2">
                            <input type="hidden" name="idprescription" id="idprescription">
                            <button type="submit" name="medicationSubmit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
            </form>
      </div>
    </div>
  </div>
</div>

<script>
    $('.editMedi').click('on',function(){
        var pres = $(this).attr('data-value');
        var obj = JSON.parse(pres);
        filltheeditform(obj);
    });
    
    $('.editMedicine').click('on',function(){
        var pres = $(this).find('a').attr('data-value');
        var obj = JSON.parse(pres);
        console.log(obj);
        filltheeditform(obj);
    });

    function filltheeditform(obj){
        $('#new_medicine').val(obj.medicine_name);
        if(obj.how_to == 'take'){
            $('#takecheckbox').prop('checked',true);
        }else{
            $('#applycheckbox').prop('checked',true);
        }
        $('#drqty').val(obj.qty);
        if(obj.medication == 'injections'){
            $('#drmed option[value=injections]').attr('selected','selected');
        }else if(obj.medication == 'liquid'){
            $('#drmed option[value=liquid]').attr('selected','selected');
        }else if(obj.medication == 'capsules'){
            $('#drmed option[value=tablets]').attr('selected','selected');
        }else{
            $('#drmed option[value=tablets]').attr('selected','selected');
        }
        if(obj.repetition == 3){
            $('#drintake option[value=3]').attr('selected','selected');
        }else if(obj.repetition == 2){
            $('#drintake option[value=2]').attr('selected','selected');
        }else{
            $('#drintake option[value=1]').attr('selected','selected');
        }
        const newinthe = obj.in_the.split(',')
        // console.log('newinthearry',newinthe);
        newinthe.forEach(res => {
            if(res == 'noon'){
                $('#nooncheckbox').attr('checked',true);
            }
            if(res == 'evening'){
                $('#eveningcheckbox').attr('checked',true);
            }
            if(res == 'night'){
                $('#inghtcheckbox').attr('checked',true);
            }
            if(res == 'morning'){
                $('#morcheckbox').attr('checked',true);
            }
        });

        if(obj.when == 'beforefood'){
            $('#beforefood').attr('checked',true);
        }else{
            $('#afterFood').attr('checked',true);
        }
        $('#forcheckbox').val(obj.course_time);
        if(obj.course_duration == 'year'){
            $('#ducheckbox option[value=year]').attr('selected','selected');
        }else if(obj.course_duration == 'month'){
            $('#ducheckbox option[value=month]').attr('selected','selected');
        }else{
            $('#ducheckbox option[value=day]').attr('selected','selected');
        }
        $('#pm_id').val(obj.pm_id);
        $('#instNotes').val(obj.notes);
        $('#idprescription').val(obj.idprescription);
        
        $('#addMedication').modal('show');
    }
        function deleteFn(){
            var x = confirm('Do you want to delete it?');
            if(x== true){
                return true;
            }else{
                return false;
            }
        }
</script>