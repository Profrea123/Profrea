@include('user.userheader')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.css">
<script src="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.js"></script>
    <section class="bg-space-header">
        <div class="container">         
            <?php $segment = Request::segment(0); ?>

            <div class="row pt-5">
               <div class="col-md-4 clearfix">
                   <h2 class="pract-head f1">Smart Prescription</h2>
               </div>
               <div class="col-md-8 text-md-end">
                    <a class="bck-btn" href="<?php echo $segment.'/booking-history'; ?>"> Back</a>
               </div>
            </div>

            <div class="row">
                <div class="col-lg-12 mb-4 mb-sm-5">
                    @if(session('message'))
                        <div class="alert alert-success"> {{ session('message') }}</div>
                    @endif
                    <div class="card card-style1 border-0">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#allMedicine">Medicine</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#Instruction">Instruction</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#Tests">Tests</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#Diagnosis">Diagnosis</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#complaints">Chief Complaints</a>
                            </li>
                        </ul>
                        
                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div class="tab-pane container active" id="allMedicine">
                                <div class="card mt-3">
                                <span class="medician float-right">
                                    <button class="" data-bs-toggle="modal" data-bs-target="#addEditMedicines"><i class="feather-plus-circle"></i>Add Medicines</button>
                                </span>
                                <div class="table-responsive">
                                    @if($prescription != '')
                                    <table class="table table-info">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Medicine Name</th>
                                                <th>how to</th>
                                                <th>Qty</th>
                                                <th>Medication</th>
                                                <!-- <th>Intake</th>
                                                <th>Time to take</th>
                                                <th>When</th> -->
                                                <th>Course</th>
                                                <!-- <th>Notes</th> -->
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($prescription as $key => $pr)
                                            <tr>
                                               <td>{{ $key + 1 }}</td> 
                                               <td>{{ $pr->medicine_name }}</td> 
                                               <td>{{ $pr->how_to }}</td> 
                                               <td>{{ $pr->qty }}</td> 
                                               <td>{{ strtoupper($pr->medication) }}</td> 
                                               <!-- <td>{{ $pr->repetition }}</td> 
                                               <td>{{ $pr->in_the }}</td> 
                                               <td>{{ $pr->when }}</td>  -->
                                               <td>{{ $pr->course_time.' '.$pr->course_duration }}</td> 
                                               <!-- <td>{{ $pr->notes }}</td>  -->
                                               <td>
                                                @php $json = json_encode($pr); @endphp
                                                    <a href="javascript:void(0)" data-id="{{ $json }}" class="btn btn-primary editPrescription">Edit</a> 
                                                    <a href="{{ url('doctor/delete-prescription/'.$pr->idprescription); }}" class="btn btn-danger" onclick="return deletePres()">Delete</a> 
                                               </td> 
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    @else
                                    No Data Found!
                                    @endif
                                </div>
                                </div>
                            </div>

                            <div class="tab-pane container" id="Instruction">
                                <div class="card mt-3">
                                <span class="medician float-right">
                                    <button onclick="showInstru()"><i class="feather-plus-circle"></i>Add Instruction</button>
                                </span>
                                <div class="table-responsive">
                                    @if($frequently_instruction != '')
                                    <table class="table table-info">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Instruction</th>
                                                <!-- <th>Description</th> -->
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($frequently_instruction as $key => $fi)
                                            <tr>
                                               <td>{{ $key + 1 }}</td> 
                                               <td>{{ $fi->title }}</td> 
                                               <!-- <td>{{ $fi->desc }}</td> -->
                                               <td>
                                               @php $fijson = json_encode($fi); @endphp
                                                    <a href="javascript:void(0)" data-id="{{ $fijson }}" class="btn btn-primary editInstruction">Edit</a> 
                                                    <a href="{{ url('doctor/delete-instruction/'.$fi->fui_id); }}" class="btn btn-danger" onclick="return deletePres()">Delete</a> 
                                               </td> 
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    @else
                                    No Data Found!
                                    @endif
                                </div>
                                </div>
                            </div>

                            <div class="tab-pane container" id="Tests">
                                <div class="card mt-3">
                                <span class="medician float-right">
                                    <button onclick="showTests()"><i class="feather-plus-circle"></i>Add Diagnostic Test</button>
                                </span>
                                <div class="table-responsive">
                                    @if($blood_tests != '')
                                    <table class="table table-info">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Test</th>
                                                <th>Description</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($blood_tests as $key => $fi)
                                            <tr>
                                               <td>{{ $key + 1 }}</td> 
                                               <td>{{ $fi->title }}</td> 
                                               <td>{{ $fi->desc }}</td>
                                               <td>
                                               @php $tjson = json_encode($fi); @endphp
                                                    <a href="javascript:void(0)" data-id="{{ $tjson }}" class="btn btn-primary editTest">Edit</a> 
                                                    <a href="{{ url('doctor/delete-test/'.$fi->bt_id); }}" class="btn btn-danger" onclick="return deletePres()">Delete</a> 
                                               </td> 
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    @else
                                    No Data Found!
                                    @endif
                                </div>
                                </div>
                            </div>

                            <div class="tab-pane container" id="Diagnosis">
                                <div class="card mt-3">
                                <span class="medician float-right">
                                    <button onclick="showDiagnosis()"><i class="feather-plus-circle"></i>Add Diagnosis</button>
                                </span>
                                <div class="table-responsive">
                                    @if($condition != '')
                                    <table class="table table-info">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Test</th>
                                                <th>Description</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($condition as $key => $hc)
                                            <tr>
                                               <td>{{ $key + 1 }}</td> 
                                               <td>{{ $hc->title }}</td> 
                                               <td>{{ $hc->desc }}</td>
                                               <td>
                                               @php $tjson = json_encode($hc); @endphp
                                                    <a href="javascript:void(0)" data-id="{{ $tjson }}" class="btn btn-primary editCondition">Edit</a> 
                                                    <a href="{{ url('doctor/delete-diagnosis/'.$hc->hc_id); }}" class="btn btn-danger" onclick="return deletePres()">Delete</a> 
                                               </td> 
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    @else
                                    No Data Found!
                                    @endif
                                </div>
                                </div>
                            </div>
                            <div class="tab-pane container" id="complaints">
                                <div class="card mt-3">
                                <span class="medician float-right">
                                    <button onclick="showComplaintsForm()"><i class="feather-plus-circle"></i>Add Complaints</button>
                                </span>
                                <div class="table-responsive">
                                    @if(!empty($complaints))
                                    <table class="table table-info">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Complaints</th>
                                                <th>Since</th>
                                                <th>Course</th>
                                                <th>Severity</th>
                                                <th>Details</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($complaints as $key => $list)
                                            <tr>
                                               <td>{{ $key + 1 }}</td> 
                                               <td>{{ $list->complaint }}</td> 
                                               <td>{{ $list->since }}</td>
                                               <td>{{ $list->course }}</td>
                                               <td>{{ $list->severity }}</td>
                                               <td>{{ $list->details }}</td>
                                               <td>
                                               @php $tjson = json_encode($list); @endphp
                                                    <a href="javascript:void(0)" data-id="{{ $tjson }}" class="btn btn-primary editComplaints">Edit</a> 
                                                    <a href="{{ url('doctor/delete_complaints/'.$list->comp_id); }}" class="btn btn-danger" onclick="return deletePres()">Delete</a> 
                                               </td> 
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    @else
                                    No Data Found!
                                    @endif
                                </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            
            
        </div>
    </section>

    <div class="modal fade" id="addEditDiagnosis" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Diagnostic Medical Condition</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('doctor.add-diagnosis') }}" method="post">
        @csrf
          <div class="modal-body">
            <div class="row">
                <label for="healthCondition">Health Condition</label>
                <input type="text" name="title" id="healthCondition" class="form-control" value="">
            </div>
            <div class="row">
                <label for="healthDescription">Description</label>
                <textarea placeholder="Add Description" name="desc" class="form-control" id="healthDescription" ></textarea>
            </div>
        </div>
        <div class="modal-footer">
            <input type="hidden" name="doctor_id" value="{{ $row_user->id }}">
            <input type="hidden" name="hc_id" id="hc_id">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
    </div>
  </div>
</div>
    <div class="modal fade" id="addEditTest" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Daignostic Test</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('doctor.add-test') }}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <label for="testTitle">Test Name</label>
                        <input type="text" name="title" id="testTitle" class="form-control" value="">
                    </div>
                    <div class="row">
                        <label for="testDescription">Description</label>
                        <textarea placeholder="Add Description" name="desc" class="form-control" id="testDescription" ></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="doctor_id" value="{{ $row_user->id }}">
                    <input type="hidden" name="bt_id" id="bt_id">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addEditInstruction" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Instructions</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('doctor.add-instruction') }}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <label for="fuinstruction_new">Add Frequently Used Instruction</label>
                        <textarea placeholder="Add new instruction" name="fuinstruction" class="form-control" id="fuinstruction_new" ></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="doctor_id" value="{{ $row_user->id }}">
                    <input type="hidden" name="fui_id" id="fui_id">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addEditComplaints" tabindex="-1" role="dialog" aria-labelledby="compalintsLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="compalintsLabel">Chief Complaints</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('doctor.add-edit-complaints') }}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="complaint">Complaints</label>
                        <input type="text" class="form-control" name="complaint" id="complaint" value="">
                    </div>
                    <div class="form-group row">
                        <label for="since">Since</label>
                        <input type="text" class="form-control" name="since" id="since" value="">
                    </div>
                    <div class="form-group row">
                        <label for="course">Course</label>
                        <input type="text" class="form-control" name="course" id="course" value="">
                    </div>
                    <div class="form-group row">
                        <label for="severity">Severity</label>
                        <input type="text" class="form-control" name="severity" id="severity" value="">
                    </div>
                    <div class="form-group row">
                        <label for="details">details</label>
                        <textarea class="form-control" name="details" id="details"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="doctor_id" value="{{ $row_user->id }}">
                    <input type="hidden" name="comp_id" id="comp_id">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addEditMedicines">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Medicine</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('doctor.casesheet.add-prescription') }}" method="post">
                    @csrf
                        
                    <div class="mb-3" id="input_medicine">
                        <label for="dr_medicine" class="form-label">Medicine</label>
                        <input type="text" class="form-control" id="new_medicine" name="new_medicine" placeholder="Enter Medicine Name">
                    </div>

                    <div class="row">
                        <div class="mb-3 col-4">
                            <label for="" class="form-label">How to</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="how_to" value="take" id="takecheckbox">
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
                                <input type="number" name="qty" step=".01" min="1" class="form-control" id="drqty">
                            </div>
                            <div class="m-2">
                                <label for="drmed" class="form-label">Medication</label>
                                <select name="medication" class="form-select" id="drmed">
                                    <option value="tablets">Tablets</option>
                                    <option value="liquid">Liquid</option>
                                    <option value="capsules">Capsules</option>
                                    <option value="injections">Injections</option>
                                </select>
                            </div>
                            <div class="m-2">
                                <label for="drintake" class="form-label">Intake</label>
                                <select name="is_take" id="drintake" class="form-select">
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
                        <div class="mb-3 d-flex">
                            <div class="form-check m-1">
                                <input class="form-check-input" type="checkbox" name="inthe[]" value="morning" id="morcheckbox">
                                <label class="form-check-label" for="morcheckbox">
                                    Morning
                                </label> 
                            </div>
                            
                            <div class="form-check m-1">
                                <input class="form-check-input" type="checkbox" name="inthe[]" value="noon" id="nooncheckbox">
                                <label class="form-check-label" for="nooncheckbox">
                                    Noon
                                </label>
                            </div>
                            
                            <div class="form-check m-1">
                                <input class="form-check-input" type="checkbox" name="inthe[]" value="evening" id="eveningcheckbox">
                                <label class="form-check-label" for="eveningcheckbox">
                                Evening
                                </label>
                            </div>
                            
                            <div class="form-check m-1">
                                <input class="form-check-input" type="checkbox" name="inthe[]" value="night" id="inghtcheckbox">
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
                                <input class="form-check-input" type="radio" name="when_to_take" value="afterFood" id="afterFood">
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
                                <input class="form-control" type="number" name="for" value="" id="forcheckbox">
                            </div>
                            
                            <div class="m-1">
                                <label class="form-label" for="ducheckbox"> Duration</label>
                                <select name="duration" id="ducheckbox" class="form-select">
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

                    <div class="row">
                        <div class="col-md-2">
                            <input type="hidden" name="idprescription" id="idprescription">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script>
        function showComplaintsForm(){
            $('#addEditComplaints').modal('show');
        }
        function showInstru(){
            $('#addEditInstruction').modal('show');
        }
        function showTests(){
            $('#addEditTest').modal('show');
        }
        function showDiagnosis(){
            $('#addEditDiagnosis').modal('show');
        }

        function deletePres(){
            var val = confirm('Do you want to delete?')
            if(val==true){
                return true;
            }else{
                return false;
            } 
        }
        

        $('.editPrescription').click('on',function(){
            var pres = $(this).attr('data-id');
            var obj = JSON.parse(pres);
            console.log(obj);
            $('#new_medicine').val(obj.medicine_name);
            if(obj.how_to == 'take'){
                $('#takecheckbox').prop('checked',true);
            }else{
                $('#applycheckbox').prop('checked',true);
            }
            $('#drqty').val(obj.qty);
            if(obj.medication == 'tablets'){
                $('#drmed option[value=tablets]').attr('selected','selected');
            }else if(obj.medication == 'liquid'){
                $('#drmed option[value=liquid]').attr('selected','selected');
            }else if(obj.medication == 'capsules'){
                $('#drmed option[value=capsules]').attr('selected','selected');
            }else{
                $('#drmed option[value=injections]').attr('selected','selected');
            }
            if(obj.is_take == 1){
                $('#drintake option[value=1]').attr('selected','selected');
            }else if(obj.is_take == 2){
                $('#drintake option[value=2]').attr('selected','selected');
            }else{
                $('#drintake option[value=3]').attr('selected','selected');
            }
            if(obj.inthe == 'morning'){
                $('#morcheckbox').attr('checked','true');
            }else if(obj.inthe == 'noon'){
                $('#nooncheckbox').attr('checked','true');
            }else if(obj.inthe == 'evening'){
                $('#eveningcheckbox').attr('checked','true');
            }else{
                $('#inghtcheckbox').attr('checked','true');
            }
            if(obj.when == 'beforefood'){
                $('#beforefood').attr('checked','true');
            }else{
                $('#afterFood').attr('checked','true');
            }
            $('#forcheckbox').val(obj.for);
            if(obj.duration == 'day'){
                $('#ducheckbox option[value=day]').attr('selected','selected');
            }else if(obj.is_take == 'month'){
                $('#ducheckbox option[value=month]').attr('selected','selected');
            }else{
                $('#ducheckbox option[value=year]').attr('selected','selected');
            }
            $('#instNotes').val(obj.notes);
            $('#idprescription').val(obj.idprescription);
            
            $('#addEditMedicines').modal('show');
        });

        $('.editInstruction').click('on',function(){
            var pres = $(this).attr('data-id');
            var obj = JSON.parse(pres);
            console.log(obj);
            $('#fuinstruction_new').val(obj.title);
            $('#fui_id').val(obj.fui_id);
            
            $('#addEditInstruction').modal('show');
        });
        $('.editTest').click('on',function(){
            var pres = $(this).attr('data-id');
            var obj = JSON.parse(pres);
            console.log(obj);
            $('#testTitle').val(obj.title);
            $('#testDescription').val(obj.desc);
            $('#bt_id').val(obj.bt_id);
            
            $('#addEditTest').modal('show');
        });
        $('.editCondition').click('on',function(){
            var pres = $(this).attr('data-id');
            var obj = JSON.parse(pres);
            console.log(obj);
            $('#healthCondition').val(obj.title);
            $('#healthDescription').val(obj.desc);
            $('#hc_id').val(obj.hc_id);
            
            $('#addEditDiagnosis').modal('show');
        });
        $('.editComplaints').click(function(){
            var pres = $(this).attr('data-id');
            var obj = JSON.parse(pres);
            console.log(obj);
            $('#complaint').val(obj.complaint);
            $('#since').val(obj.since);
            $('#course').val(obj.course);
            $('#severity').val(obj.severity);
            $('#details').val(obj.details);
            $('#comp_id').val(obj.comp_id);
            
            $('#addEditComplaints').modal('show');
        });
    </script>
