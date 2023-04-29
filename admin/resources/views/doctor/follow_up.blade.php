
@include('user.userheader')

    <section class="bg-space-header">
        <div class="container">         
            <?php $segment = Request::segment(0); ?>
            <div class="row pt-5">
                <div class="col-md-4 clearfix">
                    <h2 class="pract-head f1">Follow Up</h2>
                </div>
                <div class="col-md-8 text-md-end">
                    <a class="bck-btn" href="<?php echo $segment.'/booking-history'; ?>"> Back</a>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 mb-4 mb-sm-5">
                    <div class="card card-style1 border-0">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#allPatients">All</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#followUpPatients">Follow Up</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#regularPatients">Regular</a>
                            </li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div class="tab-pane container active" id="allPatients">
                                <div class="card mt-3" style="border-radius: 15px;">
                                    @if($all_patients)
                                        @foreach($all_patients as $patients)
                                        <div class="card-body p-4">
                                            <div class="d-flex text-black">
                                            @if($patients->profile_picture)
                                                @php $url = 'https://www.demo2.profrea.com/datafiles/uploads/profiles/'.$patients->profile_picture; @endphp
                                            @else
                                                @php $url = 'https://bootdey.com/img/Content/avatar/avatar7.png'; @endphp
                                            @endif
                                                <div class="flex-shrink-0">
                                                    <img src="{{ $url }}"
                                                    alt="{{ $patients->profile_picture }}" class="img-fluid"
                                                    style="width: 80px; border-radius: 10px;">
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <h5 class="mb-1">{{ ucwords($patients->name) }}</h5>
                                                    <p class="mb-2 pb-1" style="color: #2b2a2a;">
                                                        Follow up valid for : {{  $patients->days }} Day/s
                                                        @php
                                                         $date    = $patients->created_at; 
                                                         $expdate =  date('Y-m-d', strtotime($date. ' + '.$patients->days.' days'));
                                                         @endphp
                                                    <br/>Start Date: {{  date('F d,y h:i A', strtotime($date)) }} 
                                                    <br/>End Date: {{ date('F d,y h:i A', strtotime($expdate)) }}
                                                    </p>                                            
                                                    <div class="d-flex pt-1">
                                                    <!-- <button type="button" class="btn btn-outline-primary me-1 flex-grow-1">Chat</button> -->
                                                    <!-- <button type="button" class="btn btn-primary flex-grow-1 followUp" data-id="{{  $patients->fu_id }}" data-value="{{  $patients->booking_no }}">Follow</button> -->
                                                    @if($expdate >= date('Y-m-d'))
                                                    <a class="btn btn-primary flex-grow-1" href="{{  url('doctor/chat-list/'.$patients->booking_no) }}">Follow</a>
                                                    @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    @else
                                    {{ 'No data Found !' }}
                                    @endif
                                </div>
                            </div>
                            
                            <div class="tab-pane container fade" id="followUpPatients">
                            <div class="card mt-3" style="border-radius: 15px;">
                                    @if(0)
                                        @foreach($followp as $patients)
                                        <div class="card-body p-4">
                                            <div class="d-flex text-black">
                                    @if($patients->profile_picture)
                                        @php $url = 'https://www.demo2.profrea.com/datafiles/uploads/profiles/'.$patients->profile_picture; @endphp
                                    @else
                                        @php $url = 'https://bootdey.com/img/Content/avatar/avatar7.png'; @endphp
                                    @endif
                                                <div class="flex-shrink-0">
                                                    <img src="{{ $url }}"
                                                    alt="{{ $patients->profile_picture }}" class="img-fluid"
                                                    style="width: 80px; border-radius: 10px;">
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <h5 class="mb-1">{{ ucwords($patients->name) }}</h5>
                                                    <p class="mb-2 pb-1" style="color: #2b2a2a;">
                                                        Follow up duration : {{  $patients->days }} Day/s
                                                    <br/>Last Consult: {{  ($patients->start == '0000-00-00 00:00:00')? '--' :  date('F d,y h:i A', strtotime($patients->start)) }} 
                                                    <br/>Total Consultancey: {{ $patients->logcount }}
                                                    </p>                                            
                                                    <div class="d-flex pt-1">
                                                    <!-- <button type="button" class="btn btn-outline-primary me-1 flex-grow-1">Chat</button> -->
                                                    <button type="button" class="btn btn-primary flex-grow-1">Follow</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    @else
                                    {{ 'No data Found !' }}
                                    @endif
                                </div>
                            </div>
                            
                            <div class="tab-pane container fade" id="regularPatients">
                                <div class="card mt-3" style="border-radius: 15px;">
                                    @if(0)
                                        @foreach($regularp as $rpatients)
                                        <div class="card-body p-4">
                                            <div class="d-flex text-black">
                                    @if($rpatients->profile_picture)
                                        @php $url = 'https://www.demo2.profrea.com/datafiles/uploads/profiles/'.$rpatients->profile_picture; @endphp
                                    @else
                                        @php $url = 'https://bootdey.com/img/Content/avatar/avatar7.png'; @endphp
                                    @endif
                                                <div class="flex-shrink-0">
                                                    <img src="{{ $url }}"
                                                    alt="{{ $rpatients->profile_picture }}" class="img-fluid"
                                                    style="width: 80px; border-radius: 10px;">
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <h5 class="mb-1">{{ ucwords($rpatients->name) }}</h5>
                                                    <p class="mb-2 pb-1" style="color: #2b2a2a;">
                                                        Follow up duration : {{  $rpatients->days }} Day/s
                                                    <br/>Last Consult: {{  ($rpatients->start == '0000-00-00 00:00:00')? '--' :  date('F d,y h:i A', strtotime($rpatients->start)) }} 
                                                    <br/>Total Consultancey: {{ $rpatients->logcount }}
                                                    </p>                                            
                                                    <div class="d-flex pt-1">
                                                    <!-- <button type="button" class="btn btn-outline-primary me-1 flex-grow-1">Chat</button> -->
                                                    <button type="button" class="btn btn-primary flex-grow-1">Follow</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    @else
                                    {{ 'No data Found !' }}
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
    