    <div class="row align-items-center">
        @if($row_user['profile_picture'])
        @php
        $url = 'https://www.demo2.profrea.com/datafiles/uploads/profiles/'.$row_user['profile_picture'];
        @endphp
        @else
        @php
        $url = 'https://bootdey.com/img/Content/avatar/avatar7.png';
        @endphp
        @endif
        <div class="col-lg-6 mb-4 mb-lg-0">
            <img src="<?php echo $url; ?>" width="150" alt="User Image">
        </div>
        <div class="col-lg-6 text-md-end">
            <div class="">
                <h3 class="">{{ ucwords($row_user['name']) }}</h3>
                <span class="">{{ $row_user['gender_name'] }} | {{ $row_user['city_name'] }} </span>
            </div>
            <ul class="list-unstyled mb-1-9">
                <li class=""><span class="display-26 text-secondary me-2 font-weight-600">Booking Number:</span> {{ $booking_no }}</li>
                <!-- <li class="mb-2 mb-xl-3 display-28"><span class="display-26 text-secondary me-2 font-weight-600">Email:</span>{{ $row_user['email'] }}</li>
                <li class="mb-2 mb-xl-3 display-28"><span class="display-26 text-secondary me-2 font-weight-600">Mobile:</span>{{ $row_user['mobile'] }}</li> -->
                <!-- <li class="mb-2 mb-xl-3 display-28"><span class="display-26 text-secondary me-2 font-weight-600">City:</span>{{ $row_user['city_name'] }}</li> -->
                <li class="mb-2 mb-xl-3 display-28"><span class="display-26 text-secondary me-2 font-weight-600">Applied Date:</span> {{ date('F d,Y h:i A') }}</li>
            </ul>
        </div>
    </div>