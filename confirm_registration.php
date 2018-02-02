<?php

        session_start();

        foreach ($_SESSION as $field => $value) {
            if ($field != 'pass' && $field != 'pwcheck') {
                echo "Your '$field' is: $value<br>";
            }
        }

        ?>
        <br>
        <form action="#" method="post">
            <input type="submit" value="Registrame" name="Registrame">
            <input type="button" onclick="window.location = 'register.html'" value="Cancela">
        </form>

<?php
     
     if (isset($_POST['Registrame'])) {
        $link = mysqli_connect("127.0.0.1", "root", "Abc@1234!", "pcgames");

        if (!$link) {
            echo "Error: Unable to connect to MySQL." . PHP_EOL;
            echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
            echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
            exit;
        }

        $mail = $_SESSION['mail'];
        $user = $_SESSION['user'];
        $pass = $_SESSION['pass'];

        $query = "INSERT INTO users (email, user, passwd) VALUES ('$mail', '$user', '$pass')";
        mysqli_query($link, $query);
        mysqli_close($link);
        session_destroy();

        echo "Usuario registrado correctamente.";
        header('refresh: 3; url=index.html');
    }
?>