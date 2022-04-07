<?php

    function email_check($email,$conn){

        $sql = "SELECT * FROM admin WHERE email='$email'";
        $data = $conn -> query($sql);
        $num_data = $data -> num_rows;
        if ($num_data > 0) {
            return false;
        }else{
            return true;
        }
        
    }








?>