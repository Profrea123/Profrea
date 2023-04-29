@extends('layouts.master')
@section('content')
<style>
    thead{
        background-color: #c7dcfd;
    }
</style>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>@if ($user->profession_id ==1)
                        Doctor
                    @else
                        User
                    @endif Details</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                        <li class="breadcrumb-item active">
                            @if ($user->profession_id == 1)
                                Doctor
                            @else
                                User
                            @endif Details
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title mt-2">Show @if ($user->profession_id ==1)
                                Doctor
                            @else
                                User
                            @endif List</h3>
                            <div class="text-right">
                                <a class="btn btn-success" href="{{ redirect()->getUrlGenerator()->previous() }}"> Back</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped">
                                            <thead class="text-center">
                                                <th colspan="2">Basic Details</th>
                                            </thead>

                                            <tbody>
                                                <tr>
                                                    <th>Name</th>
                                                    <td>{{ $user->name ?? '' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>E-Mail</th>
                                                    <td>{{ $user->email ?? '' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Phone</th>
                                                    <td>{{ $user->mobileNo ?? '' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Gender</th>
                                                    <td>{{ $user->gender_name ?? '' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Verified Status</th>
                                                    <td>
                                                        @if($user->is_verified =='1')         
                                                            Verified             
                                                        @else
                                                            Not Verified
                                                        @endif
                                                    </td>
                                                </tr>
                                                @if ($user->profession_id ==1)
                                                    <tr>
                                                        <th>Experience</th>
                                                        <td>{{ $user->experience ?? '' }} </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Education</th>
                                                        <td>{{ $user->education ?? '' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Speciality</th>
                                                        <td>{{ $user->speciality_name ?? '' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Photo</th>
                                                        <td>
                                                            <?php if ($user->photo_doc != '') {
                                                                echo '<a href="../../../../../datafiles/uploads/photoId/'.$user->photo_doc.'" download>Download</a>';
                                                                } ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Register</th>   
                                                        <td>
                                                            <?php  if ($user->reg_doc != '') {
                                                            echo '<a href="../../../../../datafiles/uploads/regDoc/'.$user->reg_doc.'" download>Download</a>';
                                                            } ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Indemnity</th>
                                                        <td>
                                                            <?php  if ($user->indemnity_doc != '') {
                                                            echo '<a href="../../../../../datafiles/uploads/IndemnityDoc/'.$user->indemnity_doc.'" download>Download</a>';
                                                            } ?>
                                                        </td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>   
                                @if ($user->profession_id == 5 && count($family->family_members) > 0)
                                <div class="col-md-6">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped">
                                            <thead>
                                                <tr class="text-center">
                                                    <th colspan="4">Family Members</th>    
                                                </tr>
                                                <tr>
                                                    <th>Name</th>    
                                                    <th>DOB</th>    
                                                    <th>Relation</th>    
                                                    <th>Gender</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($family->family_members as $member)
                                                    
                                                
                                                <tr>   
                                                    <td>{{ $member->name ?? '' }}</td>
                                                    <td>{{ date('d-M-Y', strtotime($member->dob)) ?? '' }}</td>
                                                    <td>{{ ucfirst($member->relation) ?? '' }}</td>
                                                    <td>{{ ucfirst($member->gender) ?? '' }}</td>
                                                </tr> 

                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                @endif
                                @if ($user->profession_id == 1)
                                {{-- Website Details --}}
                                <div class="col-md-6">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped">
                                            <thead>
                                                <tr class="text-center">
                                                    <th colspan="2">Website Details</th>    
                                                </tr>
                                            </thead>
                                            <tbody >
                                                <tr>
                                                    <th>Domain</th>    
                                                    <td>{{ $user->domain.'.profrea.com' ?? '' }}</td>
                                                </tr> 
                                                <tr>  
                                                    <th>
                                                        Slot Interval <br>
                                                        Video Booking Open Upto <br>
                                                        Video Booking Slot Status <br>
                                                        Video Amount
                                                    </th> 
                                                    <td>{{ $user->slot_interval ?? '' }} <br> 
                                                        {{ $user->booking_open_upto ? $user->booking_open_upto.' Days' :  '' }} <br> 
                                                        {{ $user->booking_slot_status ? 'Open' : 'Close' }} <br> 
                                                        {{ $user->video_amount ?? '' }}
                                                    </td>
                                                </tr>
                                                <tr>  
                                                    <th>Audio Slot Interval <br>
                                                        Audio Booking Open Upto <br>
                                                        Audio Booking Slot Status <br>
                                                        Audio Amount </th> 
                                                    <td>{{ $user->audio_slot_interval ?? '-' }} <br>
                                                        {{ $user->audio_booking_open_upto ? $user->audio_booking_open_upto.' Days' : '' }} <br>
                                                        {{ $user->audio_booking_slot_status ? 'Open' : 'Close' }} <br>
                                                        {{ $user->audio_amount ?? '' }}</td>
                                                </tr>   
                                                <tr>  
                                                    <th>Clinic Slot Interval <br>
                                                        Clinic Booking Open Upto <br>
                                                        Clinic Booking Slot Status <br>
                                                        Clinic Amount</th> 
                                                    <td>{{ $user->clinic_slot_interval ?? '-' }} <br>
                                                        {{ $user->clinic_booking_open_upto ? $user->clinic_booking_open_upto.' Days' : '' }} <br>
                                                        {{ $user->clinic_booking_slot_status ? 'open' : '' }} <br>
                                                        {{ $user->clinic_amount ?? '' }}
                                                    </td> 
                                                </tr>  

                                                <tr>  
                                                    <th>Facebook <br>
                                                        Twitter <br>
                                                        Linked-In <br>
                                                        Instagram <br>
                                                        Google Review</th> 
                                                    <td>{{ $user->fb_link ?? '-' }} <br>
                                                        {{ $user->twitter_link ?? '-' }} <br> 
                                                        {{ $user->linkedin_link ?? '-' }} <br>
                                                        {{ $user->insta_link ?? '-' }} <br>
                                                        {{ $user->google_review_link ?? '-' }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                {{-- holidays --}}
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped">
                                            <thead>
                                                <tr class="text-center">
                                                    <th colspan="5">Holidays</th>
                                                </tr>
                                                <tr>
                                                    <th>Schedule Type</th>
                                                    <th>From Date</th>
                                                    <th>To Date</th>
                                                    <th>Reason</th>
                                                </tr>
                                            </thead>
                                            @if (count($holidays->holidays) > 0)
                                            <tbody>
                                                @foreach ($holidays->holidays as $holiday)
                                                    <tr>
                                                        <td>{{ ucfirst($holiday->schedule_type) ?? ''}}</td>
                                                        <td>{{ date('d-M-Y', strtotime($holiday->from_date)) ?? ''}}</td>
                                                        <td>{{ date('d-M-Y', strtotime($holiday->to_date)) ?? ''}}</td>
                                                        <td>{{ $holiday->reason ?? ''}}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            @else
                                            <tbody>
                                                <tr class="text-center">
                                                    <td colspan="5">No Data Found...</td>
                                                </tr>
                                            </tbody>
                                            @endif
                                        </table>
                                    </div>
                                </div>

                                {{-- slots --}}
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped">
                                            <thead>
                                                <tr class="text-center">
                                                    <th colspan="5">Audio Time Slots</th>
                                                </tr>
                                                <tr>
                                                    <th>Day</th>
                                                    <th>Status</th>
                                                    <th>Start Time</th>
                                                    <th>End Time</th>
                                                    <th>Available Time Slots</th>
                                                </tr>
                                            </thead>
                                            @if (count($audio_slots) > 0)
                                            <tbody>
                                                @foreach ($audio_slots as $doctor_slot_audio)
                                                    @if ($doctor_slot_audio->type == 1)
                                                        <tr>
                                                            <td>{{ ucfirst($doctor_slot_audio->day) ?? '' }}</td> 
                                                            <td>
                                                                @if ($doctor_slot_audio->is_available)
                                                                    <span class="text-success">Open</span>
                                                                @else
                                                                    <span class="text-danger">Close</span>
                                                                @endif
                                                            </td> 
                                                            <td>{{ $doctor_slot_audio->start_time ?? '' }}</td> 
                                                            <td>{{ $doctor_slot_audio->end_time ?? '' }}</td> 
                                                            <td>
                                                                @foreach ($doctor_slot_audio->timeslots as $available_slot)
                                                                    @if ($doctor_slot_audio->id == $available_slot->doctor_time_slot_id)
                                                                        {{ $available_slot->slot_time ?? '' }} 
                                                                        @if (!$loop->last)
                                                                            ,
                                                                        @endif
                                                                    @endif
                                                                @endforeach   
                                                            </td> 
                                                        </tr>
                                                    @endif
                                                @endforeach   
                                            </tbody>
                                            @else
                                                <tbody>
                                                    <tr class="text-center">
                                                        <td colspan="5">No Data Found...</td>
                                                    </tr>
                                                </tbody>
                                            @endif
                                        </table>
                                    </div>

                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped">
                                            <thead>
                                                <tr class="text-center">
                                                    <th colspan="5">Video Time Slots</th>
                                                </tr>
                                                <tr>
                                                    <th>Day</th>
                                                    <th>Status</th>
                                                    <th>Start Time</th>
                                                    <th>End Time</th>
                                                    <th>Available Time Slots</th>
                                                </tr>
                                            </thead>
                                            @if (count($video_slots) > 0)
                                            <tbody>
                                                @foreach ($video_slots as $doctor_slot_video)
                                                    @if ($doctor_slot_video->type == 2)
                                                        <tr>
                                                            <td>{{ ucfirst($doctor_slot_video->day) ?? '' }}</td> 
                                                            <td>
                                                                @if ($doctor_slot_video->is_available)
                                                                    <span class="text-success">Open</span>
                                                                @else
                                                                    <span class="text-danger">Close</span>
                                                                @endif
                                                            </td> 
                                                            <td>{{ $doctor_slot_video->start_time ?? '' }}</td> 
                                                            <td>{{ $doctor_slot_video->end_time ?? '' }}</td> 
                                                            <td>
                                                                @foreach ($doctor_slot_video->timeslots as $available_slot_video)
                                                                    @if ($doctor_slot_video->id == $available_slot_video->doctor_time_slot_id)
                                                                        {{ $available_slot_video->slot_time ?? '' }} 
                                                                        @if (!$loop->last)
                                                                            ,
                                                                        @endif
                                                                    @endif
                                                                @endforeach   
                                                            </td> 
                                                        </tr>
                                                    @endif
                                                @endforeach   
                                            </tbody>
                                            @else
                                                <tbody>
                                                    <tr class="text-center">
                                                        <td colspan="5">No Data Found...</td>
                                                    </tr>
                                                </tbody>
                                            @endif
                                        </table>
                                    </div>

                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped">
                                            <thead>
                                                <tr class="text-center">
                                                    <th colspan="5">Clinic Time Slots</th>
                                                </tr>
                                                <tr>
                                                    <th>Day</th>
                                                    <th>Status</th>
                                                    <th>Start Time</th>
                                                    <th>End Time</th>
                                                    <th>Available Time Slots</th>
                                                </tr>
                                            </thead>
                                            @if (count($clinic_slots) > 0)
                                                
                                            <tbody>
                                                @foreach ($clinic_slots as $doctor_slot_clinic)
                                                    @if ($doctor_slot_clinic->type == 3)
                                                        <tr>
                                                            <td>{{ ucfirst($doctor_slot_clinic->day) ?? '' }}</td> 
                                                            <td>
                                                                @if ($doctor_slot_clinic->is_available)
                                                                    <span class="text-success">Open</span>
                                                                @else
                                                                    <span class="text-danger">Close</span>
                                                                @endif
                                                            </td> 
                                                            <td>{{ $doctor_slot_clinic->start_time ?? '' }}</td> 
                                                            <td>{{ $doctor_slot_clinic->end_time ?? '' }}</td> 
                                                            <td>
                                                                @foreach ($doctor_slot_clinic->timeslots as $available_slot_clinic)
                                                                    @if ($doctor_slot_clinic->id == $available_slot_clinic->doctor_time_slot_id)
                                                                        {{ $available_slot_clinic->slot_time ?? '' }} 
                                                                        @if (!$loop->last)
                                                                            ,
                                                                        @endif
                                                                    @endif
                                                                @endforeach   
                                                            </td> 
                                                        </tr>
                                                    @endif
                                                @endforeach   
                                            </tbody>
                                            @else
                                                <tbody>
                                                    <tr class="text-center">
                                                        <td colspan="5">No Data Found...</td>
                                                    </tr>
                                                </tbody>
                                            @endif
                                        </table>
                                    </div>
                                </div>  

                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection