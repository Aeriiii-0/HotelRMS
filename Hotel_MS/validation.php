<?php
    function is_word($data) {
        if (empty(trim($data))) {
            return false;
        }
        
        if (preg_match("/^[a-zA-Z\s]+$/", $data)) {
            return true;
        } else {
            return false;
        }
    }

    function is_email($data) {
    
        if (filter_var($data, FILTER_VALIDATE_EMAIL)) {
            return true;
        } else {
            return false;
        }
    }
    function is_valid_room($data) {
        if (!is_numeric($data)) {
            return false;
        }

        $roomNum = (int)$data;

        if ($roomNum >= 100 && $roomNum <= 999) {
            return true;
        } else {
            return false;
        }
    }
?>