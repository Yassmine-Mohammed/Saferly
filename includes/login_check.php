<?php
function checklogin (){
    if (empty($_SESSION ['user']) && empty($_SESSION ['company'])) {
        header("location:login.php");
        exit;
    }
}
