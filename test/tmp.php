<?php

$first_name ='Pradeep';
$unique_id =1;
$form_link='https://www.profrea.com/views/space-info?id='.$unique_id; 
	$email_subject = "You are just a step away from earning revenue from your workspaces!!!";
	$email_message = '
		<html><body>
		<p style="font-size:28px;">  </br>&nbsp; <img src="https://www.profrea.com/img/mail.png" `  height="42" width="82">  <b>&nbsp;&nbsp; Welcome to Profrea</b> </p>
        <p style="font-size:15px;"> Hey <b> '. $first_name . '</b>,</p>
		<p style="font-size:15px;"> We want to take a second and not only thank you, but also congratulate you on making a GREAT decision today! </p>
        <p style="font-size:15px;">So welcome aboard – We know you are going to love <a href="https://www.profrea.com/"><b>Profrea</b></a> .  </p>
        <p style="font-size:15px;">If you are a tenant, don’t be disheartened simply download free  <a href="https://www.profrea.com/datafiles/downloads/noc.pdf"><b> NOC template </b></a> &nbsp; and get it signed from your property owner.   </p>
        <p style="font-size:15px;"> We believe transparency is the key for success, Download our  <a href="https://www.profrea.com/datafiles/downloads/terms-of-use.pdf"><b> terms of use  </b></a> &nbsp; & share your acceptance by signing it.</p>
		<p style="font-size:15px;">Wait no more; follow simple steps here in the link  <a href="'.$form_link.'"><b>Click here to get started</b> </a>.</p>
        <p style="font-size:15px;">If you have ANY comments, questions or feedback. Please don’t hesitate to let us know, you can also refer our <a href="https://www.profrea.com/views/faq"><b>FAQ</b></a>   </p>
		<p style="font-size:15px;">We love hearing from our customers </p>
		<p style="font-size:15px;"> <b>Useful videos : </b> </p>
        <p style="font-size:15px;">&nbsp;&nbsp;&nbsp;&nbsp; <a href="https://youtu.be/xR8yss1IBu8"><b>How to earn revenue from your workspace?</b></a>   </p>
        <p style="font-size:15px;">&nbsp;&nbsp;&nbsp;&nbsp; <a href="https://youtu.be/ZZNiKLfAlHs"><b> Terms of use.  </b></a>   </p>
        <p style="font-size:15px;"><br/><br/><b>To your success</b>, </p>
		<p style="font-size:15px; ">Team Profrea </p>
		<p style="font-size:12px; "> <br/><br/><u>Confidentiality Warning</u>: This message and any attachments are intended only for the use of the intended recipient(s), are confidential and may be privileged. If you are not the intended recipient, you are hereby notified that any review, re-transmission, conversion to hard copy, copying, circulation or other use of this message and any attachments is strictly prohibited. If you are not the intended recipient, please notify the sender immediately by return email and delete this message and any attachments from your system. </p>
		</body></html>
		';

echo $email_message;
?>