<?php
//This script will handle login
session_start();

// check if the user is already logged in
require_once "config.php";

$username = $password = "";
$err = "";

// if request method is post
if ($_SERVER['REQUEST_METHOD'] == "POST"){
    if(empty(trim($_POST['username'])) || empty(trim($_POST['password'])))
    {
        $err = "Please enter username + password";
    }
    else{
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
    }


    if(empty($err))
    {
        $sql = "SELECT id, username, password FROM sysusers WHERE username = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $param_username);
        $param_username = $username;
    
        // Try to execute this statement
        if(mysqli_stmt_execute($stmt)){
            mysqli_stmt_store_result($stmt);
            if(mysqli_stmt_num_rows($stmt) == 1)
            {
                mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                if(mysqli_stmt_fetch($stmt))
                {
                    if(password_verify($password, $hashed_password))
                    {
                        // Password is correct. Allow user to login
                        session_start();
                        $_SESSION["username"] = $username;
                        $_SESSION["id"] = $id;
                        $_SESSION["loggedin"] = true;
                        echo"<script type= text/javascript> document.getElementById('submit').addEventListener('click',hello); </script>";
    
                        // Redirect user to welcome page
                        header("location: index.html");
                        exit;
                    }
                    else
                    {
                        // Password is incorrect
                        echo"<script type= text/javascript> alert('Incorrect Password') </script>";
                    } 
                }
            }
            else
            {
                // Username not found
                $err = "Username not found";
            }
        }
        else
        {
            // Error executing the statement
            $err = "Oops! Something went wrong. Please try again later.";
        }
    
        // If there was an error, display it
        if(!empty($err))
        {
            echo $err;
        }
    }
     


}


?>

<html>
<head>
<title></title>
<style type="text/css">
    body {
margin: 0;
padding: 0;
font-family: sans-serif;
background: url(interface.jpg);
background-size: cover;
}
.log-box{
background: rgba(0,0,0,.5);
color: #fff;
width: 320px;
height: 460px;
top: 50%;
left: 75%;
transform: translate(-50%, -50%);
box-sizing: border-box;
position: absolute;
padding: 70px 30px;
}
.usrimg {
width: 100px;
height: 100px;
border-radius: 50%;
overflow: hidden;
position: absolute;
top: calc(-100px/2);
left: calc(50% - 50px);
}
h2{
margin: 0;
padding: 0 0 20px;
text-align: center;
}
.log-box p{
margin: 0;
padding: 0;
font-weight: bold;
color: #fff;
}
.log-box input{
width: 100%;
margin-bottom: 20px;
}
.log-box input[type="text"],
.log-box input[type="password"]
{
border: none;
border-bottom: 1px solid #fff;
background: transparent;
outline: none;
height: 40px;
color: #fff;
font-size: 16px;
}
::placeholder {
color: rgba(255,255,255,.5);
}
.log-box input[type="submit"]{
border: none;
outline: none;
height: 40px;
font-size: 18px;
cursor: pointer;
border-radius: 20px;
padding-left:60px;
padding-right:60px;
}
.log-box a{
text-decoration: none;
color: #fff;
}

</style>
</head>
<body>
<div class="log-box">
<img class="usrimg" src="usericon.png" >
<h2>Log In</h2>
<form id="theForm" action="" method="post" style="border-radius:25%;">
<label></label><br />
<input  name="username" placeholder="Enter Username" type="text" />
<label></label><br />
<input name="password" placeholder="Enter Password" type="Password" />
<input name="" id="submit" type="submit" value="Log In" style="margin-top: 18px" />
<br/> 
&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp <br />
<br />
<a href="https://www.facebook.com">Facebook</a>&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp <a href="register.php">Sign up</a>
</form>
</div>
<script type="text/javascript">
    var h="Welcome to Rozgaar.com";
   function hello() {
       alert(h);
   }
</script>
</body>
</html>