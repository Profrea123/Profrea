<?php
session_start();
session_destroy();
unset($_SESSION['ap_profrea_login_id']);
header('Location: login');
?>