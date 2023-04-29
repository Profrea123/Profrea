@include('user.userheader')

<section class="bg-space-header">
    <div class="container">         
        <div class="row pt-5">
            <div class="clearfix">
                <div class="float-left">
                    <h2 class="space-headtitle f1 fw-bold">Digital Prescription</h2>
                </div>
                <div class="float-right">
                    @if($vital != '' && $medical_history != '')
                    <a class="btn btn-primary" href="#" onclick="printDiv()"> Print</a>
                    @endif
                    <a class="btn btn-success" href="{{ url()->previous() }}"> Back</a>
                </div>
            </div>
        </div>
    </div>

    
    <div class="container">
        <div id="DPIdToPrint" class="row align-items-center mt-3 p-2" style="background-color: #fff; font-family: 'Poppins', sans-serif;box-sizing: border-box;">
            <table style="width: 700px;margin: 0 auto;">
                <tr>
                    <td>
                        <table style="width: 100%;padding: 16px;box-shadow: 0 0 16px 0px rgba(0,0,0,0.2);margin: 20px 0;border-radius: 5px;">
                            <tr>
                                <td  style="padding: 20px;">
                                    <table style="width: 100%;position: relative;padding: 5px 0 0 0;background: #fff;border-radius: 6px;font-size: 16px;font-weight: 400;color: #686565; ">
                                        <tr>
                                            <td style="width: 40%;padding: 6px 10px 0;">
                                            <a href="# " style="font-size:40px; color:#474444">
                                                    <img style="width: 135px; " src="https://www.demo2.profrea.com/datafiles/uploads/profiles/pf-logo.png" alt=" ">
                                                </a>
                                            </td>
                                            <td style="width: 100%;vertical-align: text-top;padding: 6px 10px 0;">
                                                    <table style="width:100%;">
                                                        <tbody>
                                                            <tr>
                                                                <td style="vertical-align:baseline;width: 45%;text-align: end;padding-right: 12px;">
                                                                <!-- <img style="width: 85px; " src="https://www.demo2.profrea.com/datafiles/uploads/profiles/male.png" alt=" "> -->
                                                                </td>
                                                                <td>
                                                                    <h4 style="font-weight: 600;padding: 0;margin: 0;color: #20a8f4;font-size: 18px;"><strong>{{ ucwords($row_user->name) }}</strong></h4>
                                                                    <p style="border-radius: 5px;margin: 4px 0 0 0; font-size: 12px; ">{{ $row_user->education . '('. $row_user->speciality_name.')' }}</p>
                                                                    <p style="border-radius: 5px;font-size: 12px; margin:0;"><strong>Phone: 96435 55592</strong></p>
                                                                    <p style="font-size: 12px; margin:0;"> <strong>Email: info@Profrea.com</strong></p>
                                                                    <p style="font-size: 12px; margin:0;">Address: 119, 1st Floor, S City Road, Block D,South City I, Sector 41, Gurugram, Haryana, 122001</p>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                            </td>
                                        </tr>
                                    </table>
                                    <table style="width: 100%;position: relative;background: #fff;border-radius: 6px;font-size: 16px;font-weight: 400;color: #686565; ">
                                        <tr>

                                            <td>
                                                <h2 style="text-transform: uppercase;font-size: 16px;margin: 12px 0 10px 0;padding: 7px 10px;border-bottom: 1px solid #20a8f4;color: #20a8f4;font-weight: 600;">Appointment Details</h2>

                                                <table style="width: 100%; padding: 20px 0; ">
                                                    <tbody>
                                                        <tr>
                                                            <td style="width: 20%;"> <h4 style="padding: 0 0 0px 10px;font-size: 12px;color:#686565;"> Patient's Name :</4></td>
                                                            <td style="padding: 0 10px 0px 0;font-size: 12px;"> <strong>{{ ucwords($booking_details->name); }}, {{ ($booking_details->gender_id==1)?'M':'F'; }} </strong></td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width: 20%;"> <h4 style="padding: 0 0 0px 10px;font-size: 12px;color:#686565;"> Phone :</4></td>
                                                            <td style="padding: 0 10px 0px 0;font-size: 12px;"><strong>{{ $booking_details->mobileNo; }}</strong></td>
                                                        </tr>
                                                       
                                                        <tr>
                                                            <td style="width: 20%;"> <h4 style="padding: 0 0 0px 10px;font-size: 12px;color:#686565;"> Email :</4></td>
                                                            <td style="padding: 0 10px 0px 0;font-size: 12px;"><strong>{{ $booking_details->email; }}</strong></td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width: 20%;"> <h4 style="padding: 0 0 0px 10px;font-size: 12px;color:#686565;"> Booking Number</4></td>
                                                            <td style="padding: 0 10px 0px 0;font-size: 12px;"><strong>{{ $booking_details->booking_no; }}</strong></td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width: 20%;"> <h4 style="padding: 0 0 0px 10px;font-size: 12px;color:#686565;"> Booking Date Time</4></td>
                                                            <td style="padding: 0 10px 0px 0;font-size: 12px;"><strong>{{ date('d, M Y',                                                    strtotime($booking_details->booking_date)).' '.date('h:i:s A',strtotime($booking_details->booking_time)); }}</strong></td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width: 20%;"> <h4 style="padding: 0 0 0px 10px;font-size: 12px;color:#686565;"> Booking Type</4></td>
                                                            @php
                                                            if($booking_details->booking_type == 1){
                                                                $bookingType = 'Audio';
                                                            }else if($booking_details->booking_type == 2){
                                                                $bookingType = 'Video';
                                                            }else{
                                                                $bookingType = 'In Clinic';
                                                            }
                                                            @endphp
                                                            <td style="padding: 0 10px 0px 0;font-size: 12px;"><strong>{{ $bookingType; }}</strong></td>
                                                        </tr>
                                                        
                                                    </tbody>
                                                </table>


                                            </td>

                                        </tr>
                                        <tr>
                                            <td >
                                                <h2 style="text-transform: uppercase;font-size: 16px;margin: 12px 0 10px 0;padding: 7px 10px;border-bottom: 1px solid #20a8f4;color: #20a8f4;font-weight: 600;">Vital Details</h2>

                                                <table style="padding: 20px 0;width: 95%;">
                                                    <tbody>
                                                        <tr>
                                                            <th style="padding: 0 0 5px 0;width: 145px; text-align:center; border-right: 1px solid #dee2e6; color:#474444;font-size: 15px;">Height:</th>
                                                            <th style="padding: 0 0 5px 0;width: 145px; text-align:center; border-right: 1px solid #dee2e6; color:#474444;font-size: 15px;">Weight:</th>
                                                            <th style="padding: 0 0 5px 0;width: 145px; text-align:center; border-right: 1px solid #dee2e6; color:#474444;font-size: 15px;">Blood Pressure:</th>
                                                            <th style="padding: 0 0 5px 0;width: 145px;text-align:center;color:#474444;font-size: 15px;border-right: 0;">Temperature:</th>
                                                        </tr>
                                                        <tr>
                                                            <td style="padding: 0 0 5px 0;width: 145px;text-align:center;border-right: 1px solid #dee2e6;font-size: 12px;">{{ $vital->height }} <sub>(m)</sub></td>
                                                            <td style="padding: 0 0 5px 0;width: 145px;text-align:center;border-right: 1px solid #dee2e6;font-size: 12px;">{{ $vital->weight }} <sub>(kgs)</sub></td>
                                                            <td style="padding: 0 0 5px 0;width: 145px;text-align:center;border-right: 1px solid #dee2e6;font-size: 12px;">{{ $vital->blood_pressure }} <sub>(mm hg)</sub></td>
                                                            <td style="padding: 0 0 5px 0;width: 145px;text-align:center;font-size: 12px;">{{ $vital->temperature }} <sub>(°F)</sub></td>
                                                        </tr>

                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td >
                                                <h2 style="text-transform: uppercase;font-size: 16px;margin: 12px 0 10px 0;padding: 7px 10px;border-bottom: 1px solid #20a8f4;color: #20a8f4;font-weight: 600;">Chief Complaints</h2>
                                                @if(!empty($patientChiefComplaints))
                                                <ol>
                                                    @foreach($patientChiefComplaints as $list)
                                                        <li style="font-size: 12px; ">{{ $list->complaint.' '.$list->since.' '.$list->course.' '.$list->severity }} </li>
                                                        <div style="font-size: 12px;">Details: {{ $list->details }}</div>
                                                    @endforeach
                                                </ol>
                                                @else
                                                    <div style="font-size: 12px;">No DATA FOUND </div>
                                                @endif
                                              
                                            </td>
                                        </tr>
                                        <tr>
                                            <td >
                                                <h2 style="text-transform: uppercase;font-size: 16px;margin: 12px 0 10px 0;padding: 7px 10px;border-bottom: 1px solid #20a8f4;color: #20a8f4;font-weight: 600;">Patient's Medical & Family History</h2>

                                                <table style="width:100%;">
                                                    <tbody>
                                                        <tr>
                                                            <td style="width: 38%;"><h4 style="padding: 0 0 0px 10px;font-size: 12px;color:#686565;">Medical History</h4></td>
                                                            <td> <p style="font-size: 12px;padding: 0 10px;margin: 0;"> <strong>{{ $medical_history->medical }}</strong> </p></td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width: 38%;"> <h4 style="padding: 0 0 0px 10px;font-size: 12px;color:#686565;">Medication History</h4></td>
                                                            <td><p style="font-size: 12px;padding: 0 10px;margin: 0;"><strong>{{ $medical_history->medical }} </strong></p></td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width: 38%;"><h4 style="padding: 0 0 0px 10px;font-size: 12px;color:#686565;">Surgical History</h4></td>
                                                            <td><p style="font-size: 12px;padding: 0 10px;margin: 0;"> <strong>{{ $medical_history->surgical }}</strong> </p></td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width: 38%;"><h4 style="padding: 0 0 0px 10px;font-size: 12px;color:#686565;">Drug Allergies</h4></td>
                                                            <td><p style="font-size: 12px;padding: 0 10px;margin: 0;"><strong>{{ $medical_history->drug }}</strong> </p></td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width: 38%;"><h4 style="padding: 0 0 0px 10px;font-size: 12px;color:#686565;">Diet Allergies/Restrictions</h4></td>
                                                            <td><p style="font-size: 12px;padding: 0 10px;margin: 0;"> <strong>{{ $medical_history->restrictions }}</strong> </p></td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width: 38%;"><h4 style="padding: 0 0 0px 10px;font-size: 12px;color:#686565;">Personal History, Lifestyle & Habits</h4></td>
                                                            <td><p style="font-size: 12px;padding: 0 10px;margin: 0;"><strong>{{ $medical_history->habits }} </strong></p></td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width: 38%;"><h4 style="padding: 0 0 0px 10px;font-size: 12px;color:#686565;">Environmentel & Occupation History</h4></td>
                                                            <td><p style="font-size: 12px;padding: 0 10px;margin: 0;"> <strong>{{ $medical_history->occupation }}</strong> </p></td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width: 38%;"><h4 style="padding: 0 0 0px 10px;font-size: 12px;color:#686565;">Family Medical History</h4></td>
                                                            <td><p style="font-size: 12px;padding: 0 10px;margin: 0;"><strong>{{ $medical_history->family_history }}</strong> </p></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                    <table style="width: 100%;position: relative;background: #fff;border-radius: 6px;font-size: 16px;font-weight: 400;color: #686565; ">
                                        
                                        <tr>
                                            <td >
                                                <h2 style="text-transform: uppercase;font-size: 16px;margin: 12px 0 10px 0;padding: 7px 10px;border-bottom: 1px solid #20a8f4;color: #20a8f4;font-weight: 600;">Notes</h2>

                                                   <table style="width:100%;">
                                                    <tbody>
                                                        <tr>
                                                            <td style="width: 38%;">
                                                            <h4 style="padding: 0 0 0px 10px;font-size: 12px;color:#686565;">Junior Doctor Notes</h4>
                                                            </td>
                                                            <td>
                                                            <p style="font-size: 12px;padding: 0 10px;margin: 0;"><strong>{{ $dr_notes->jr_dr_note }}</strong> </p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width: 38%;"><h4 style="padding: 0 0 0px 10px;font-size: 12px;color:#686565;">Diagostic Test Result</h4></td>
                                                            <td><p style="font-size: 12px;padding: 0 10px;margin: 0;"><strong>{{ $dr_notes->test_result }}</strong> </p></td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width: 38%;"><h4 style="padding: 0 0 0px 10px;font-size: 12px;color:#686565;">Clinical Observation Notes</h4></td>
                                                            <td><p style="font-size: 12px;padding: 0 10px;margin: 0;"><strong>{{ $dr_notes->clinical_note }}</strong> </p></td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width: 38%;"><h4 style="padding: 0 0 0px 10px;font-size: 12px;color:#686565;">Personal Notes</h4></td>
                                                            <td><p style="font-size: 12px;padding: 0 10px;margin: 0;"><strong>{{ $dr_notes->personal_note }}</strong> </p></td>
                                                        </tr>
                                                       
                                                    </tbody>
                                                   </table> 

                                            </td>
                                        </tr>
                                        
                                        <tr>
                                            <td >
                                                <h2 style="text-transform: uppercase;font-size: 16px;margin: 12px 0 10px 0;padding: 7px 10px;border-bottom: 1px solid #20a8f4;color: #20a8f4;font-weight: 600;">Diagnosis/Provisional Diagnosis</h2>

                                             

                                                <h4 style="font-weight: 600;margin-bottom:10px;font-size:12px;padding: 0 10px;">Diagnosed Medical Condition (Acceptable in ICD-10 Nomenclature)</h4>
                                                @if($patient_condition)
                                                <?php $cArr = explode(',',$patient_condition->condition); 
                                                $count = count($cArr); ?> 
                                                <ol>
                                                    @for($i = 0;$i < $count; $i++)
                                                        <li style="font-size: 12px; ">{{ $cArr[$i] }} </li>
                                                    @endfor
                                                </ol>
                                                @endif
                                              
                                            </td>
                                        </tr>
                                        <tr>
                                            <td >
                                                <h2 style="text-transform: uppercase;font-size: 16px;margin: 12px 0 10px 0;padding: 7px 10px;border-bottom: 1px solid #20a8f4;color: #20a8f4;font-weight: 600;">Medication Prescribed</h2>

                                                <!-- <h4 style="font-weight: 600;margin-bottom:5px;font-size:16px;padding: 0 10px;">Diagnosed Medical Condition (Acceptable in ICD-10 Nomenclature)</h4> -->
                                                @if(!empty($patient_medication))
                                                <ol>
                                                    @foreach($patient_medication as $list)
                                                        <li style="font-size: 12px; "><b>{{ $list->medicine_name }}</b></li>
                                                        <div style="font-size: 12px;">Prefer this for {{ $list->course_time.' '.$list->course_duration.' '.$list->repetition.' '.$list->in_the.' '.$list->notes.' '.$list->when}}</div>
                                                        <div style="font-size: 12px;">To be taken: {{ $list->qty }} </div>
                                                    @endforeach
                                                </ol>
                                                @else
                                                    <div style="font-size: 12px;">No DATA FOUND </div>
                                                @endif
                                              
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="">
                                                <h2 style="text-transform: uppercase;font-size: 16px;margin: 12px 0 10px 0;padding: 7px 10px;border-bottom: 1px solid #20a8f4;color: #20a8f4;font-weight: 600;">   Diagnostic Tests</h2>

                                                <h4 style="font-weight: 600;margin-bottom:10px;font-size:12px;padding: 0 10px;">Tests</h4>
                                                @if($patient_tests)
                                                <?php $ctArr = explode(',',$patient_tests->test); 
                                                $tcount = count($ctArr); ?> 
                                                <ol>
                                                    @for($i = 0;$i < $tcount; $i++)
                                                    <li style="font-size: 12px; padding:0 10px">{{ $ctArr[$i] }} </li>
                                                    @endfor
                                                </ol>
                                                <!-- <h4 style="font-weight: 600;margin-bottom:10px;font-size:12px;padding: 0 10px;">Instruction</h4> -->
                                                <!-- <p style="border-radius: 5px; border: 1px solid #ddd;     padding: 10px 10px !important;font-size: 12px; padding:0 10px">{{ $patient_tests->instruction }}</p> -->
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="">
                                                <h2 style="text-transform: uppercase;font-size: 16px;margin: 12px 0 10px 0;padding: 7px 10px;border-bottom: 1px solid #20a8f4;color: #20a8f4;font-weight: 600;">   Follow Up</h2>


                                                <table>
                                                    <tbody>
                                                        <tr style="vertical-align: baseline;">
                                                            <td> <h4 style="padding: 0 0 0px 10px;font-size: 12px;color:#686565;">Valid for {{ $followup->days }} Day/s :</h4></td>
                                                            <td>@php
                                                                $date    = $followup->created_at; 
                                                                $expdate =  date('Y-m-d', strtotime($date. ' + '.$followup->days.' days'));
                                                            @endphp
                                                            <p style="font-size: 12px;padding: 0 10px;margin: 0;">
                                                            Start Date: <strong>{{ date('F d,Y', strtotime($date)) }}</strong> <br/>
                                                            Expiry Date: <strong>{{ date('F d,Y', strtotime($expdate)) }}</strong>
                                                            </p></td>
                                                        </tr>
                                                    </tbody>
                                                </table>

                                               
                                                
                                                
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <h2 style="text-transform: uppercase;font-size: 16px;margin: 12px 0 10px 0;padding: 7px 10px;border-bottom: 1px solid #20a8f4;color: #20a8f4;font-weight: 600;">Advice or Instructions</h2>
                                                
                                                <table>
                                                    <tbody>
                                                        <tr style="vertical-align: baseline;">
                                                            <td><h4 style="padding: 0 0 0px 10px;font-size: 12px;color:#686565;">Advice or Instructions for the medicine  :</h4></td>
                                                            <td><p style="font-size: 12px;padding: 0 10px;margin: 0;"><strong>{{ $followup->advice }}</strong></p></td>
                                                        </tr>
                                                    </tbody>
                                                </table>

                                                
                                                
                                            </td>
                                        </tr>
                                    </table>

                                </td>
                            </tr>

                        </table>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    
</section> 

<script>
    
    function printDiv() 
    {
        var divToPrint=document.getElementById('DPIdToPrint');
        var newWin=window.open('','Print-Window');
        newWin.document.open();
        newWin.document.write('<html><body onload="window.print()">'+divToPrint.innerHTML+'</body></html>');
        newWin.document.close();
        setTimeout(function(){newWin.close();},10);
    }
</script>