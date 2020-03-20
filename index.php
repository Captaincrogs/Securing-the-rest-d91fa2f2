<?php

require_once 'connection.php';

session_start();

if (isset($_SESSION["user_login"])) //check condition user login not direct back to index.php page
{
    header("location: welcome.php");
}

if (isset($_REQUEST['btn_login'])) //button name is "btn_login"
{
    $username = strip_tags($_REQUEST["txt_username_email"]); //textbox name "txt_username_email"
    $email = strip_tags($_REQUEST["txt_username_email"]); //textbox name "txt_username_email"
    $password = strip_tags($_REQUEST["txt_password"]); //textbox name "txt_password"

    if (empty($username)) {
        $errorMsg[] = "Username is nodig"; //checkt of username leeg is
    } else if (empty($email)) {
        $errorMsg[] = "Email is nodig"; //checkt of username en email leeg zijn
    } else if (empty($password)) {
        $errorMsg[] = "Wat is je wachtwoord"; //checkt als password box leeg is
    } else {
        try
        {
            $select_stmt = $db->prepare("SELECT * FROM tbl_user WHERE username=:uname OR email=:uemail"); //sql select query
            $select_stmt->execute(array(':uname' => $username, ':uemail' => $email)); //execute query with bind parameter
            $row = $select_stmt->fetch(PDO::FETCH_ASSOC);

            if ($select_stmt->rowCount() > 0) //check condition database record greater zero after continue
            {
                if ($username == $row["username"] or $email == $row["email"]) //check condition user taypable "username or email" are both match from database "username or email" after continue
                {
                    if (password_verify($password, $row["password"])) //check condition user taypable "password" are match from database "password" using password_verify() after continue
                    {
                        $_SESSION["user_login"] = $row["user_id"]; //session name is user_login
                        $loginMsg = "Successfully Login..."; //login is succesvol
                        header("refresh:2; welcome.php"); //refresht in 2 seconden naat welcome.php bestand
                    } else {
                        $errorMsg[] = "Onjuist Wachtwoord";

                    }
                } else {
                    $errorMsg[] = "Onjuite username of email";
                }
            } else {
                $errorMsg[] = "Onjuiste username of email";
            }
        } catch (PDOException $e) {
            $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="initial-scale=1.0, maximum-scale=2.0">
<link rel="stylesheet" href="background.css">

<title>Maak een account aan!</title>
<header>
<header>

<div class="lettertype">
<ul>
<li><a href="welcome.php"target="_blank">Home pagina</a></li>
<li><a href="register.php">Registreer</a></li>
<li><a href=index.php>Inloggen</a></li>
<li><a href="logout.php"target="_blank">Uitloggen</a><li>
<li><a href="blog/Blog.html"target="_blank">Blog</a></li>
<li><a href="nieuws/Nieuws.html"target="_blank">Nieuws</a></li>
<li><a href="mijn projecten/Mijnprojecten.html">Mijn projecten</a></li>

</ul>


</div>
<script>
var msg = "onjuist wachtwoord";
</script>
</header>


	<body>


		<?php
if (isset($errorMsg)) {
    foreach ($errorMsg as $error) {
        ?>
				<div class="alert alert-danger">
					<strong><?php echo $error; ?></strong>
				</div>
            <?php
}
}
if (isset($loginMsg)) {
    ?>
			<div class="alert alert-success">
				<strong><?php echo $loginMsg; ?></strong>
			</div>
        <?php
}
?>
			<center><h2>Login Page</h2></center>
            <div class="sign-up-form">
			<form method="post" class="form-horizontal">

				<div class="form-group">
				<label class="col-sm-3 control-label">Username or Email</label>
				<div class="col-sm-6">
				<input type="text" name="txt_username_email" class="form-control" placeholder="enter username or email" />
				</div>
				</div>

				<div class="form-group">
				<label class="col-sm-3 control-label">Password</label>
				<div class="col-sm-6">
				<input type="password" name="txt_password" class="form-control" placeholder="enter passowrd" />
				</div>
				</div>

				<div class="form-group">
				<div class="col-sm-offset-3 col-sm-9 m-t-15">
				<input type="submit" name="btn_login" class="btn btn-success" value="Login">
				</div>
				</div>

				<div class="form-group">
				<div class="col-sm-offset-3 col-sm-9 m-t-15">
				Heb je nog geen account? <a href="register.php"><p class="text-info">Register Account</p></a>
				</div>
				</div>
                </div>

			</form>

		</div>

	</div>

	</div>

	</body>
</html>