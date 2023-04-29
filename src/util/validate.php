<?php


    function isValidAlphaStringonly($data){
        $reg_exp = "/^[A-Za-z]+$/";
        return preg_match($reg_exp, $data);
        }

    function isValidAlphaNumStringonly($data){
        $reg_exp = "/^[A-Za-z0-9]+$/";
            return preg_match($reg_exp, $data);
        }

    function isValidString($data){
        $reg_exp = "/^[A-Za-z .'-]+$/";
            return preg_match($reg_exp, $data);
        }  

    function isValidAddress($data){
        $reg_exp = "/^[A-Za-z0-9 .'-]+$/";
        return preg_match($reg_exp, $data);
        }

        
    function isValidEmail($data){
        $reg_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
        return preg_match($reg_exp, $data);
            }

    function isValidPhone($data){
        $reg_exp = '/^[0-9]{10}$/';
        return preg_match($reg_exp, $data);
            }

    function isValidNumber($data){
        $reg_exp = "/^[0-9]*$/"; 
        return preg_match($reg_exp, $data);
            }
            
    function isValidPinCode($data){
        $reg_exp = '/^[0-9]{6}/';
        return preg_match($reg_exp, $data);
            }

       


?>            