<?php
    session_start();

    foreach ($_SESSION as $field => $value) {
        if ($field != 'pass' && $field != 'pwcheck') {
            echo "Your '$field' is: $value<br>";
        }
    }

    ?>
        <input type="button" onclick='register.php' value="Registrame">
        <input type="button" onclick='register.html' value="No, cancela">
?>