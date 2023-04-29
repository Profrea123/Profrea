<?php
function sendMail($email_subject,$email_message,$email_to,$email_from='info@profrea.com',$fromName='Profrea'){
   if($email_to === 'info@profrea.com'){
      $email_subject = 'ProfreaWeb: '.$email_subject;
   }
   // Set content-type header for sending HTML email
   $headers = "MIME-Version: 1.0" . "\r\n";
   $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
   // Additional headers
   $headers .= 'From: '.$fromName.'<'.$email_from.'>' . "\r\n";
   //$headers .= 'Cc: welcome@example.com' . "\r\n";
   //$headers .= 'Bcc: welcome2@example.com' . "\r\n";
   // send email
   try {
      @mail($email_to, $email_subject, $email_message, $headers, 'info@profrea.com');
      return true;
   } catch (\Exception $e) {
      return $e->getMessage();
   }
   
}
?>