<?php
function checklogin() {
    if (empty($_SESSION['user']) && empty($_SESSION['company'])) {
        echo "<script>
            alert('You must Login/Register First');
            window.location.href = '../auth/login.php';
        </script>";
        exit;
    }
}
?>