@extends('layouts.master')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Plan</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Plan</li>
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
                            <h3 class="card-title mt-2">Show Plan</h3>
                            <div class="text-right">
                                <a class="btn btn-success" href="{{ route('admin.plan.index') }}"> Back</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="table-responsive">
                                    <table class="table table-bordered ">
                                        <tbody>
                                            <tr>
                                                <th>Title</th>
                                                <td>{{ $plan->title }}</td>
                                            </tr>
                                            <tr>
                                                <th>Plan Days</th>
                                                <td>{{ $plan->plan_days }}</td>
                                            </tr>
                                            
                                            
                                            <tr>
                                                <th>Hours per day</th>
                                                <td>{{ $plan->hours_per_day }}</td>
                                            </tr>
                                            <tr>
                                                <th>Hours per week</th>
                                                <td>{{ $plan->hours_per_week }}</td>
                                            </tr>
                                            <tr>
                                                <th>Hours per month</th>
                                                <td>{{ $plan->hours_per_month }}</td>
                                            </tr>
                                            <tr>
                                                <th>Plan Aamount</th>
                                                <td>{{ $plan->plan_amount }}</td>
                                            </tr>
                                            <tr>
                                                <th>Cost per hour</th>
                                                <td>{{ $plan->cost_per_hour }}</td>
                                            </tr>
                                            <tr>
                                                <th>Initial Payment</th>
                                                <td>{{ $plan->initial_payment }}</td>
                                            </tr>
                                            <tr>
                                                <th>Branding</th>
                                                <td>{{ $plan->branding?"Yes":"No" }}</td>
                                            </tr>

                                            <tr>
                                                <th>Profrea Doctor Kit</th>
                                                <td>{{ $plan->profrea_doctor_kit?"Yes":"No" }}</td>
                                            </tr>

                                            <tr>
                                                <th>Receptionist cum Helper</th>
                                                <td>{{ $plan->receptionist_cum_helper?"Yes":"No" }}</td>
                                            </tr>

                                            <tr>
                                                <th>Live Receptionist</th>
                                                <td>{{ $plan->live_receptionist?"Yes":"No" }}</td>
                                            </tr>

                                            <tr>
                                                <th>Practo Prime</th>
                                                <td>{{ $plan->practo_prime?"Yes":"No" }}</td>
                                            </tr>

                                            <tr>
                                                <th>On Call Feature</th>
                                                <td>{{ $plan->on_call_feature?"Yes":"No" }}</td>
                                            </tr>
                                            
                                            <tr>
                                                <th>GMB</th>
                                                <td>{{ $plan->gmb?"Yes":"No" }}</td>
                                            </tr>

                                            <tr>
                                                <th>Social Media Management</th>
                                                <td>{{ $plan->social_media_management?"Yes":"No" }}</td>
                                            </tr>

                                            <tr>
                                                <th>100 percent OPD</th>
                                                <td>{{ $plan->opd_percent?"Yes":"No" }}</td>
                                            </tr>


                                            <tr>
                                                <th>1.5 Feature</th>
                                                <td>{{ $plan->feature15?"Yes":"No" }}</td>
                                            </tr>

                                            <tr>
                                                <th>Lab Referrals</th>
                                                <td>{{ $plan->lab_referrals?"Yes":"No" }}</td>
                                            </tr>

                                            <tr>
                                                <th>Radiological Referrals</th>
                                                <td>{{ $plan->radiological_referrals?"Yes":"No" }}</td>
                                            </tr>

                                            <tr>
                                                <th>Medicine Referrals</th>
                                                <td>{{ $plan->medicine_referrals?"Yes":"No" }}</td>
                                            </tr>

                                            <tr>
                                                <th>Personalised Website</th>
                                                <td>{{ $plan->personalised_website?"Yes":"No" }}</td>
                                            </tr>

                                            <tr>
                                                <th>OPD Management Software</th>
                                                <td>{{ $plan->opd_management_software?"Yes":"No" }}</td>
                                            </tr>





                                            <tr>
                                                <th>Monday Slots</th>
                                                <td>{{ $plan->mon_slots }}</td>
                                            </tr>
                                            <tr>
                                                <th>Tuesday Slots</th>
                                                <td>{{ $plan->tue_slots }}</td>
                                            </tr>
                                            <tr>
                                                <th>Wednesday Slots</th>
                                                <td>{{ $plan->wed_slots }}</td>
                                            </tr>
                                            <tr>
                                                <th>Thursday Slots</th>
                                                <td>{{ $plan->thu_slots }}</td>
                                            </tr>
                                            <tr>
                                                <th>Friday Slots</th>
                                                <td>{{ $plan->fri_slots }}</td>
                                            </tr>
                                            <tr>
                                                <th>Saturday Slots</th>
                                                <td>{{ $plan->sat_slots }}</td>
                                            </tr>
                                            <tr>
                                                <th>Sunday Slots</th>
                                                <td>{{ $plan->sun_slots }}</td>
                                            </tr>
                                            <tr>
                                                <th>Status</th>
                                                <td>{{ $plan->status }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection