<?php

function pr($arr)
{
    echo '<pro>';
    print_r($arr);
}
;



function prx($arr)
{
    echo '<pre>';
    print_r($arr);
    die();
}
;

function checkError()
{
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);


}





function get_safe_value($conn, $str)
{
    if ($str != '') {
        $str = trim($str);
        return strip_tags(mysqli_real_escape_string($conn, $str));
    }
    ;
}
;



function check_login()
{
    if (!isset($_SESSION['LOGIN'])) {
        echo "<script>window.location.href='../login.php'</script>";

        exit;
    }
}






?>