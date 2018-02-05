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
            <input type="submit" value="Sign me up" name="sign_up">
            <input type="button" onclick="window.location = 'register.html'" value="Cancel">
        </form>

<?php
     
     if (isset($_POST['sign_up'])) {
        $link = mysqli_connect("127.0.0.1", "root", "Abc@1234!", "pcgames");

        if (!$link) {
            echo "Error: Unable to connect to MySQL." . PHP_EOL;
            echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
            echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
            exit;
        }

        $mail = $_SESSION['email'];
        $user = $_SESSION['user'];
        $pass = password_hash($_SESSION['pass'], PASSWORD_DEFAULT);

        $query = "INSERT INTO users (email, user, passwd) VALUES ('$mail', '$user', '$pass')";
        mysqli_query($link, $query);
        mysqli_close($link);
        session_destroy();

        echo "User registered successfully";
        header('refresh: 2; url=/index.html');
    }
?>