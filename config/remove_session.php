<?php

function remove_session($notify){
        $session_list = ['notification','donate'];
        for($i=0;$i<count($session_list);$i++){
            if($notify != $session_list[$i] && isset($session_list[$i])){
                unset($_SESSION[$session_list[$i]]);
            }
        }
    }
?>