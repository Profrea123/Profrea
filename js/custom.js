$(function () {  

  var dummyEmail = $('<input data-parsley-type="email">').parsley();
  var dummyPhone = $('<input data-parsley-type="digits" data-parsley-length="[10, 10]">').parsley();
  window.Parsley.addValidator('emailorphone', {
    validateString: function(value) {
      return (dummyEmail.isValid(true, value) || dummyPhone.isValid(true, value));
    },
    messages: {
      en: 'This string is not a email or phone!'
    }
  });

  $('#date_from').datetimepicker({
    format: 'DD-MM-YYYY',
    minDate:new Date()
  });
  $('#date_to').datetimepicker({
    format: 'DD-MM-YYYY',
    minDate:new Date()
  });
  // $("#date_from").on("dp.change", function (e) {
  //   $('#date_to').data("DateTimePicker").minDate(e.date);
  // });
  // $("#date_to").on("dp.change", function (e) {
  //   $('#date_from').data("DateTimePicker").maxDate(e.date);
  // });


  // Insert Profession
  $("#otherForm").submit(function(e){
    e.preventDefault();
    if ( $(this).parsley().isValid() )
    {
      var formData = new FormData(this);
      $.ajax({
        type: 'POST',
        url: './includes/functions.php?action=profession_insert',
        data: formData,
        cache: false,
        processData: false,
        contentType: false,
        beforeSend: function(){
          $('#otherForm_status').html('<p class="text-center"><i class="fa fa-spinner fa-spin"></i> Please wait as we process..</p>').fadeIn();
        },
        success : function(res){
          if (res=='0')
          {
            $("#otherForm")[0].reset();
          }
          else if (res=='1')
          {
            $('#otherForm_status').html('<p class="text-center text-danger">Error in inserting!</p>').fadeIn();
          }
          else if (res=='2')
          {
            $('#otherForm_status').html('<p class="text-center text-danger">Client already exist!</p>').fadeIn();
          }
          else
          {
            let resObj = JSON.parse(res);
            Swal.fire({
              icon: resObj.icon,
              title: resObj.title,
              text: resObj.msg,
              // footer: '<a href="">Why do I have this issue?</a>'
            })
            $('#otherForm_status').html("").fadeIn();
            $("#otherForm")[0].reset();
          }
        }
      });
    }
    return false;
  });
  // Find Space
  $("#findForm").submit(function(e){
    e.preventDefault();
    if ( $(this).parsley().isValid() )
    {
      var formData = $(this).serialize();
      var industry_id = $('#industry_id').val();
      var url = "spaces";
      // if(industry_id === "1")
      // {
      //   url = 'medical';
      // }
      // else if(industry_id === "2"){
      //   url = 'educational';
      // }
      // else if(industry_id === "3"){
      //   url = 'fitness';
      // }
      // $.post(url,{
      //   industry_id: industry_id
      // });
      var postFormStr = "<form method='GET' action='" + url + "'>\n";
      postFormStr += "<input type='hidden' name='industry_id' value='" + $('#industry_id').val() + "'></input>";
      postFormStr += "<input type='hidden' name='city_id' value='" + $('#city_id').val() + "'></input>";
      postFormStr += "<input type='hidden' name='offset' value='0'></input>";
      // postFormStr += "<input type='hidden' name='location_id' value='" + $('#location_id').val() + "'></input>";
      postFormStr += "</form>";
      var formElement = $(postFormStr);
      $('body').append(formElement);
      $(formElement).submit();
    }
    return false;
  });
  // Login
  $("#loginForm").submit(function(e){
    e.preventDefault();
    if ( $(this).parsley().isValid() )
    {
      var formData = new FormData(this);
      $.ajax({
        type: 'POST',
        url: './includes/functions.php?action=login',
        data: formData,
        cache: false,
        processData: false,
        contentType: false,
        beforeSend: function(){
          $('#loginForm_status').html('<p class="text-center"><i class="fa fa-spinner fa-spin"></i> Please wait as we process..</p>').fadeIn();
        },
        success : function(res){
          if (res=='0')
          {            
            $("#loginForm")[0].reset();
            // window.location ="profile-view";
            window.location ="spaces";
          }
          else if (res=='1')
          {
            $('#loginForm_status').html('<p class="text-center text-danger">Invalid Email / Phone Or Password</p>').fadeIn();
          }
          else if (res=='2')
          {
            $('#loginForm_status').html('<p class="text-center text-danger">Invalid email / phone number</p>').fadeIn();
          }
          else if (res=='3')
          {
            $('#loginForm_status').html('<p class="text-center text-success">OTP sent to your mobile or email ! Please enter OTP to continue</p>').delay(5000).fadeOut();
            $('#otp_box').show();
            $('.log-inbtn').html('Login');
          }
          else if (res=='4')
          {
            $('#loginForm_status').html('<p class="text-center text-danger">Error OTP update!</p>').fadeIn();
          }
          else if (res=='5')
          {
            $('#loginForm_status').html('<p class="text-center text-danger">Invalid OTP!</p>').fadeIn();
          }
          else if (res=='6')
          {
            $('#loginForm_status').html('<p class="text-center text-danger">SMS not send. Pease try again.</p>').fadeIn();
          }
          else
          {
            $('#loginForm_status').html("").fadeIn();
          }
        }
      });
    }
    return false;
  });
  // Register
  $("#registerForm").submit(function(e){
    e.preventDefault();
    if ( $(this).parsley().isValid() )
    {
      var formData = new FormData(this);
      $.ajax({
        type: 'POST',
        url: './includes/functions.php?action=register',
        data: formData,
        cache: false,
        processData: false,
        contentType: false,
        beforeSend: function(){
          $('#registerForm_status').html('<p class="text-center"><i class="fa fa-spinner fa-spin"></i> Please wait as we process..</p>').fadeIn();
        },
        success : function(res){
          if (res=='0')
          {            
            $("#registerForm")[0].reset();
            window.location ="profile-view";
          }
          else if (res=='1')
          {
            $('#registerForm_status').html('<p class="text-center text-danger">Email / Mobile already exist</p>').fadeIn();
          }
          else if (res=='2')
          {
            $('#registerForm_status').html('<p class="text-center text-danger">Invalid mobile!</p>').fadeIn();
          }
          else if (res=='3')
          {
            $('#registerForm_status').html('<p class="text-center text-success">OTP sent to your mobile or email ! Please enter OTP to continue</p>').delay(5000).fadeOut();
            $('#otp_box').show();
            $('.log-inbtn').html('Register');
          }
          else if (res=='4')
          {
            $('#registerForm_status').html('<p class="text-center text-danger">Error OTP insert!</p>').fadeIn();
          }
          else if (res=='5')
          {
            $('#registerForm_status').html('<p class="text-center text-danger">Invalid OTP!</p>').fadeIn();
          }
          else if (res=='6')
          {
            $('#registerForm_status').html('<p class="text-center text-danger">SMS not send. Pease try again.</p>').fadeIn();
          }
          else
          {
            $('#registerForm_status').html("").fadeIn();
          }
        }
      });
    }
    return false;
  });
  // Forgetpassword
  $("#forgetpasswordForm").submit(function(e){
    e.preventDefault();
    if ( $(this).parsley().isValid() )
    {
      var formData = new FormData(this);
      var username = $('#username').val();
      $.ajax({
        type: 'POST',
        url: './includes/functions.php?action=forgetpassword',
        data: formData,
        cache: false,
        processData: false,
        contentType: false,
        beforeSend: function(){
          $('#forgetpasswordForm_status').html('<p class="text-center"><i class="fa fa-spinner fa-spin"></i> Please wait as we process..</p>').fadeIn();
        },
        success : function(res){
          if (res=='0') {
            $("#forgetpasswordForm")[0].reset();
            // window.location ="reset-password";
            var postFormStr = "<form method='POST' action='reset-password'>\n";
            postFormStr += "<input type='hidden' name='username' value='"+username+"'></input>";
            postFormStr += "</form>";
            var formElement = $(postFormStr);
            $('body').append(formElement);
            $(formElement).submit();            
          } else if (res=='1') {
            $('#forgetpasswordForm_status').html('<p class="text-center text-danger">Invalid mobile / Password</p>').fadeIn();
          } else if (res=='2') {
            $('#forgetpasswordForm_status').html('<p class="text-center text-danger">Invalid mobile!</p>').fadeIn();
          } else if (res=='3') {
            $('#forgetpasswordForm_status').html('<p class="text-center text-success">OTP sent to your mobile or email ! Please enter OTP to continue</p>').delay(5000).fadeOut();
            $('#otp_box').show();
            $('.log-inbtn').html('Reset Password');
          } else if (res=='4') {
            $('#forgetpasswordForm_status').html('<p class="text-center text-danger">Error OTP update!</p>').fadeIn();
          } else if (res=='5') {
            $('#forgetpasswordForm_status').html('<p class="text-center text-danger">Invalid OTP!</p>').fadeIn();
          } else if (res=='6') {
            $('#forgetpasswordForm_status').html('<p class="text-center text-danger">SMS not send. Pease try again.</p>').fadeIn();
          } else {
            $('#forgetpasswordForm_status').html("").fadeIn();
          }
        }
      });
    }
    return false;
  });
  // Resetpassword
  $("#resetpasswordForm").submit(function(e){
    e.preventDefault();
    if ( $(this).parsley().isValid() )
    {
      var formData = new FormData(this);
      $.ajax({
        type: 'POST',
        url: './includes/functions.php?action=resetpassword',
        data: formData,
        cache: false,
        processData: false,
        contentType: false,
        beforeSend: function(){
          $('#resetpasswordForm_status').html('<p class="text-center"><i class="fa fa-spinner fa-spin"></i> Please wait as we process..</p>').fadeIn();
        },
        success : function(res){
          if (res=='0') {
            $("#resetpasswordForm")[0].reset();
            window.location ="profile-view";
          } else if (res=='1') {
            $('#resetpasswordForm_status').html('<p class="text-center text-danger">Invalid registered email or mobile!</p>').fadeIn();
          } else {
            $('#resetpasswordForm_status').html("").fadeIn();
          }
        }
      });
    }
    return false;
  });
  // Changepassword
  $("#changepasswordForm").submit(function(e){
    e.preventDefault();
    if ( $(this).parsley().isValid() )
    {
      var formData = new FormData(this);
      $.ajax({
        type: 'POST',
        url: './includes/functions.php?action=changepassword',
        data: formData,
        cache: false,
        processData: false,
        contentType: false,
        beforeSend: function(){
          $('#changepasswordForm_status').html('<p class="text-center"><i class="fa fa-spinner fa-spin"></i> Please wait as we process..</p>').fadeIn();
        },
        success : function(res){
          if (res=='0')
          {            
            $("#changepasswordForm")[0].reset();
            $('#changepasswordForm_status').html('<p class="text-center text-success">Password Changed Successfully!</p>').fadeIn();
          }
          else if (res=='1')
          {
            $('#changepasswordForm_status').html('<p class="text-center text-danger">Invalid login!</p>').fadeIn();
          }
          else
          {
            $('#changepasswordForm_status').html("").fadeIn();
          }
        }
      });
    }
    return false;
  });
  // Resend OTP
  $('#resendotp').click(function(){
    var resendotpfrom = $(this).data('from');
    if (resendotpfrom == 'login' || resendotpfrom == 'forgotpassword') {
      var username = $('#username').val();
      $data = {resendotpfrom:resendotpfrom,username:username}
    }
    else if (resendotpfrom == 'register') {
      var email = $('#email').val();
      var phone = $('#phone').val();
      $data = {resendotpfrom:resendotpfrom,email:email,phone:phone}
    }    
    $.ajax({
      url: "./includes/functions.php?action=resendotp",
      data: $data,
      method: "POST",
      beforeSend: function(){
        $("#resend_status").html('<p class="text-center"><i class="fa fa-spinner fa-spin"></i> Please wait as we process..</p>').fadeIn();
      },
      success: function (result)
      {
        if (result=='0')
        {            
          $('#resend_status').html('<p class="text-center text-success">OTP resent successfully</p>').delay(5000).fadeOut();
        }
        else if (result=='1')
        {
          $('#resend_status').html('<p class="text-center text-danger">Error OTP update!</p>').fadeIn();
        }
        else if (result=='2')
        {
          $('#resend_status').html('<p class="text-center text-danger">Invalid mobile</p>').fadeIn();
        }
        else if (result=='3')
        {
          $('#resend_status').html('<p class="text-center text-danger">SMS not send. Pease try again.</p>').fadeIn();
        }
        else
        {
          $('#resend_status').html("").fadeIn();
        }
      }
    });
  });
  

  //callback form
  $("#callbackForm").submit(function(e){
    e.preventDefault();
    if ( $(this).parsley().isValid() )
    {
      var formData = new FormData(this);
      $.ajax({
        type: 'POST',
        url: './includes/functions.php?action=callback_request',
        data: formData,
        cache: false,
        processData: false,
        contentType: false,
        beforeSend: function(){
          $('#callbackForm_status').html('<p class="text-center"><i class="fa fa-spinner fa-spin"></i> Please wait as we process..</p>').fadeIn();
        },
        success : function(res){
         
            let resObj = JSON.parse(res);
            Swal.fire({
              icon: resObj.icon,
              title: resObj.title,
              text: resObj.msg,
            }).then(function() {
              window.location = "faq";
          })
            $('#callbackForm_status').html("").fadeIn();
            $("#callbackForm")[0].reset();
           
          
        }
      });
    }
    return false;
  });

  $("#booking-cancel-form").submit(function(e){
    e.preventDefault();
    if ( $(this).parsley().isValid() )
    {
      var formData = new FormData(this);
      $.ajax({
        type: 'POST',
        url: './includes/functions.php?action=booking_cancel',
        data: formData,
        cache: false,
        processData: false,
        contentType: false,
        beforeSend: function(){
          $('#booking_status').html('<p class="text-center"><i class="fa fa-spinner fa-spin"></i> Please wait as we process..</p>').fadeIn();
        },
        success : function(res){
          let resObj = JSON.parse(res);
          Swal.fire({
            icon: resObj.icon,
            title: resObj.title,
            text: resObj.msg,
          }).then(function() {
            $('#booking_status').html("").fadeIn();
            $("#booking-cancel-form")[0].reset();
            $("#bookingCancel").modal("hide");
            location.reload();
        })
          
        }
      });
    }
    return false;
  });
  
  $("#booking-regenerate-form").submit(function(e){
    e.preventDefault();
    if ( $(this).parsley().isValid() )
    {
      var formData = new FormData(this);
      $.ajax({
        type: 'POST',
        url: './token_regenerate.php',
        data: formData,
        cache: false,
        processData: false,
        contentType: false,
        beforeSend: function(){
          $('#booking_regenerate').html('<p class="text-center"><i class="fa fa-spinner fa-spin"></i> Please wait as we process..</p>').fadeIn();
        },
        success : function(res){
          let resObj = JSON.parse(res);
          Swal.fire({
            icon: resObj.icon,
            title: resObj.title,
            text: resObj.msg,
          }).then(function() {
            $('#booking_regenerate').html("").fadeIn();
            $("#booking-regenerate-form")[0].reset();
            $("#bookingRegenerate").modal("hide");
            location.reload();
        })
          
        }
      });
    }
    return false;
  });

  $("#booking-complete-form").submit(function(e){
    e.preventDefault();
    if ( $(this).parsley().isValid() )
    {
      var formData = new FormData(this);
      $.ajax({
        type: 'POST',
        url: './includes/functions.php?action=booking_complete',
        data: formData,
        cache: false,
        processData: false,
        contentType: false,
        beforeSend: function(){
          $('#booking_complete').html('<p class="text-center"><i class="fa fa-spinner fa-spin"></i> Please wait as we process..</p>').fadeIn();
        },
        success : function(res){
          let resObj = JSON.parse(res);
          Swal.fire({
            icon: resObj.icon,
            title: resObj.title,
            text: resObj.msg,
          }).then(function() {
            $('#booking_complete').html("").fadeIn();
            $("#booking-complete-form")[0].reset();
            $("#bookingComplete").modal("hide");
            location.reload();
        })
        }
      });
    }
    return false;
  });
  // Attachments
  $("#booking-attachment-form").submit(function(e){
    e.preventDefault();
    if ( $(this).parsley().isValid() )
    {
      var formData = new FormData(this);
      $.ajax({
        type: 'POST',
        url: './includes/functions.php?action=booking_attachment',
        data: formData,
        cache: false,
        processData: false,
        contentType: false,
        beforeSend: function(){
          $('#booking_attachment').html('<p class="text-center"><i class="fa fa-spinner fa-spin"></i> Please wait as we process..</p>').fadeIn();
        },
        success : function(res){
          let resObj = JSON.parse(res);
          Swal.fire({
            icon: resObj.icon,
            title: resObj.title,
            text: resObj.msg,
          }).then(function() {
            $('#booking_attachment').html("").fadeIn();
            $("#booking-attachment-form")[0].reset();
            $("#bookingAttachment").modal("hide");
            location.reload();
        })
        }
      });
    }
    return false;
  });

  $("#scheduleVisitForm").submit(function(e){
    e.preventDefault();
    if ( $(this).parsley().isValid() )
    {
      var formData = new FormData(this);
      $.ajax({
        type: 'POST',
        url: './includes/functions.php?action=schedule_visit',
        data: formData,
        cache: false,
        processData: false,
        contentType: false,
        beforeSend: function(){
          $('#scheduleVisitForm_status').html('<p class="text-center"><i class="fa fa-spinner fa-spin"></i> Please wait as we process..</p>').fadeIn();
        },
        success : function(res){         
          let resObj = JSON.parse(res);
          Swal.fire({
            icon: resObj.icon,
            title: resObj.title,
            text: resObj.msg,
          }).then(function() {
            $('#scheduleVisitForm_status').html("").fadeIn();
            $("#scheduleVisitForm")[0].reset();
            $("#scheduleModal").modal("hide");
        })
          
        }
      });
    }
    return false;
  });

  $("#booknowForm").submit(function(e){
    e.preventDefault();
    if ( $(this).parsley().isValid() )
    {
      var formData = new FormData(this);
      $.ajax({
        type: 'POST',
        url: './includes/functions.php?action=booknow',
        data: formData,
        cache: false,
        processData: false,
        contentType: false,
        beforeSend: function(){
          $('#booknowForm_status').html('<p class="text-center"><i class="fa fa-spinner fa-spin"></i> Please wait as we process..</p>').fadeIn();
        },
        success: function(res){
          if (res=='0')
          {            
            var postFormStr = "<form method='POST' action='booking'>";
            postFormStr += "<input type='hidden' name='formData' value='"+$("#booknowForm").serialize()+"'></input>";
            postFormStr += "</form>";
            var formElement = $(postFormStr);
            $('body').append(formElement);
            $(formElement).submit();
            $("#booknowForm_status").html("").fadeIn();
            $('#booknowModal').modal('hide');
          }
          else if (res=='1')
          {
            $('#booknowForm_status').html("").fadeIn();
            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: 'Error! Please select atleast one slot!',
            });
          }
          else if (res=='2')
          {
            $('#booknowForm_status').html("").fadeIn();
            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: 'Error! Please select one slot per day!',
            });
          }
          else
          {
            $('#booknowForm_status').html("").fadeIn();
          }
        }
      });
    }
    return false;
  });


});