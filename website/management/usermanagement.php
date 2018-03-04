<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="usermanagement.css">
</head>
<body>
    <?php
        session_start();

        if (!$_SESSION["id"]) {
            echo "<span>You're not logged in. Please <a href='/modules/login/login.php'>log in.</a></span>";
            echo "\n\t</body>";
            echo "\n</html>";
            exit;

        }

        if (strcmp($_SESSION["roles"], "admin") != 0 && strcmp($_SESSION["roles"], "shopadmin") != 0) {
            echo "<span>You are not allowed to be here.</span>";
            echo "\n\t</body>";
            echo "\n</html>";
            exit;
        }

        $adduser = $_GET["adduser"];

        if (empty($adduser)) {
            echo "<div class='choose'>";
            echo "<div class='searchbar'>";
            echo "<form action='#' method='GET' target='body_frame'>";
            echo "<input type='text' name='search' placeholder='Manage users'>";
            echo "</form>";
            echo "</div>";
            echo "<div class='add'>";
            echo "<a href='usermanagement.php?adduser=yes'><input type='button' value='Add user'></a>";
            echo "</div>";
            echo "</div>";

        }
        else if (strcmp("yes", $adduser) == 0) {
            ?>
                <div class="addform">
                    <form action="#" method="POST">
                        <input type="text" name="email" placeholder="EMAIL" required>
                        <input type="text" name="user" placeholder="USER" required>
                        <input type="password" name="passwd" placeholder="PASSWORD" required>
                        <select name="role" required>
                            <option value="user" selected>USER</option>
                            <option value="shopadmin">SHOPADMIN</option>
                            <option value="admin">ADMIN</option>
                        </select>
                        <input type="submit" name="submituser" value="Add user">
                    </form>
                </div>
            <?php
            if (isset($_POST["submituser"])) {
                $connect = mysqli_connect("localhost", "root", "Abc@1234!", "pcgames");

                $hashed_pass = password_hash($_POST["passwd"], PASSWORD_DEFAULT);

                $query = "INSERT INTO users (email, user, passwd, roles) VALUES ('$_POST[email]', '$_POST[user]', '$hashed_pass', '$_POST[role]')";
                $result = mysqli_query($connect, $query);

                mysqli_close($connect);
                header("refresh: 0; url=usermanagement.php");
            }
        }

        $search = $_GET["search"];
        
        if ($search && !$_GET["userid"]) { 

            $connect = mysqli_connect("localhost", "root", "Abc@1234!", "pcgames");

            $query = "SELECT * FROM users WHERE Match(user, email) AGAINST ('$search*' IN BOOLEAN MODE) ORDER BY user";
            $result = mysqli_query($connect, $query);

            ?>
            
            <table class="usertable" align="center">
            <?php echo "<tr><th colspan='5'><center>FOUND USERS IN DB MATCHING '$search'</center></th></tr>" ?>
            <tr>
                <th>Email</th>
                <th>User</th>
            <?php
            while ($row = mysqli_fetch_array($result)) {
                echo '<tr><td>'."<a href='usermanagement.php?userid=$row[id]'>".$row["email"].'</a></td>';
                echo '<td>'.$row["user"].'</td></tr>';
            }

            echo "</table>";
            mysqli_close($connect);
        }
        else if ($_GET["userid"]) {
            $connect = mysqli_connect("localhost", "root", "Abc@1234!", "pcgames");

            $query = "SELECT * FROM users WHERE id = $_GET[userid]";
            $result = mysqli_query($connect, $query);

            $re = mysqli_fetch_assoc($result);

            echo "\t<div class='centro'>\n";
            echo "\t\t\t<form action='#' method='POST'>\n";
            echo "\t\t\t\t<input type='text' name='EMAIL' placeholder='EMAIL: $re[email]'>\n";
            echo "\t\t\t\t<input type='password' name='USER' placeholder='USER: $re[user]'>\n";
            echo "\t\t\t\t<select name='ROLES'>\n";
            echo "\t\t\t\t\t\<option value='user'>USER</option>";
            echo "\t\t\t\t\t\<option value='shopadmin'>SHOPADMIN</option>";
            echo "\t\t\t\t\t\<option value='admin'>ADMIN</option>";
            echo "\t\t\t\t</select>\n";
            echo "\t\t\t\t<input type='password' name='PASSWD' placeholder='PASSWORD'>\n";
            echo "\t\t\t\t<input type='submit' value='ABORT' name='abort'>\n";
            echo "\t\t\t\t<input type='submit' value='UPDATE' name='update'>\n";
            echo "\t\t\t</form>\n";
            echo "\t</div>\n";

            if (isset($_POST['update'])) {
                if (empty($_POST["EMAIL"])) {
                    $_POST["EMAIL"] = $re["email"];
                }
                if (empty($_POST["USER"])) {
                    $_POST["USER"] = $re["user"];
                }
                if (empty($_POST["PASSWD"])) {
                    $_POST["PASSWD"] = $re["passwd"];
                }
                if (empty($_POST["ROLES"])) {
                    $_POST["ROLES"] = $re["roles"];
                }

                $hashed_pass = password_hash($_POST["PASSWD"], PASSWORD_DEFAULT);

                $uquery = "UPDATE users SET email = '$_POST[EMAIL]', user = '$_POST[USER]', passwd = '$hashed_pass', roles = '$_POST[ROLES]' WHERE id = $re[id]";
                
                mysqli_query($connect, $uquery);

                unset($_GET["userid"]);
                unset($search);
                mysqli_close($connect);

                header("refresh: 0; url=usermanagement.php");
            }
            else if (isset($_POST['abort'])) {
                unset($_GET["userid"]);
                unset($search);
                mysqli_close($connect);
                header("refresh: 0; url=usermanagement.php");
            }
        }
    ?>
</body>
</html>