<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="profile.css">
</head>
<body>
        <?php
            session_start();

            if (empty($_SESSION["id"])) {
                echo "<span class='err'>I don't know how you got here, but you definitely are not allowed here, go back where you belong!</span>";
                echo "<a href='/index.php'<span>Return to main page</span></a></body></html>";
                exit;
            }
            
            $connect = mysqli_connect("localhost", "root", "Abc@1234!", "pcgames");

            $query = "SELECT email, user, passwd FROM users WHERE id = $_SESSION[id]";
            $result = mysqli_query($connect, $query);
            $user_data = mysqli_fetch_assoc($result);

            echo "<div class='center'>\n";
            
            if (isset($_POST["submit"])) {
                $hashed_pw = $user_data["passwd"];
                
                
                if (empty($_POST["email"])) {
                    $newemail = $user_data["email"];
                }
                else {
                    $newemail = $_POST["email"];
                }

                if (empty($_POST["user"])) {
                    $newuser = $user_data["user"];
                }
                else {
                    $newuser = $_POST["user"];
                }

                if (empty($_POST["newpw"])) {
                    $newpass = $user_data["passwd"];
                }

                $pass = $_POST["oldpw"];
                if (password_verify($pass, $hashed_pw)) {
                    if (!empty($_POST["newpw"])) {
                        if (strcmp($_POST["newpw"], $_POST["chkpw"]) == 0) {
                            $newpass = password_hash($_POST["newpw"], PASSWORD_DEFAULT);                            
                        }
                        else {
                            echo "<span class='err'>Passwords do not match!</span>";
                            exit;
                        }
                    }
                    
                    $uquery = "UPDATE users SET email = '$newemail', user = '$newuser', passwd = '$newpass' WHERE id = $_SESSION[id]";

                    mysqli_query($connect, $uquery);
                    echo "<span>Your profile was updated successfully!</span>";
                    header("refresh: 2, ../cpanel/cpanel.php");
                }
                else {
                    echo "<span class='err'>The current password is not correct!</span>";
                }
            }
            mysqli_close($connect);
            unset($_POST["submit"]);
            

            echo "\t<form action='#' method='post'>\n";
            echo "\t\t<input type='text' name='email' placeholder='CHANGE CURRENT EMAIL: $user_data[email]'>\n";
            echo "\t\t<input type='text' name='user' placeholder='CHANGE CURRENT USER: $user_data[user]'>\n";
            echo "\t\t<input type='password' name='newpw' placeholder='NEW PASSWOWRD'>\n";
            echo "\t\t<input type='password' name='chkpw' placeholder='REPEAT PASSOWRD'>\n";
            echo "\t\t<input type='password' name='oldpw' placeholder='CURRENT PASSWORD' required>\n";
            echo "\t\t<input type='submit' name='submit' value='UPDATE MY PROFILE!'>\n";
            echo "\t</form>\n";
            echo "</div>\n"

        ?>
</body>
</html>