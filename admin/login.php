<?php
session_start();
      include "db_conn.php";
      include "../fuc.php";
?>

<!DOCTYPE HTML>
<html lang="en" >
<html>
<head>
  <title>Login</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="../style.css">
  <link rel="stylesheet" type="text/css" href="../main.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href='https://fonts.googleapis.com/css?family=Titillium+Web:400,300,600' rel='stylesheet' type='text/css'>  
  <link href='https://fonts.googleapis.com/css?family=Titillium+Web:400,300,600' rel='stylesheet' type='text/css'> 
  <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css" integrity="sha384-vp86vTRFVJgpjF9jiIGPEEqYqlDwgyBgEF109VFjmqGmIY/Y4HV4d3Gp2irVfcrp" crossorigin="anonymous">
</head>

<body class="body">
<?php
 

   if($_SERVER["REQUEST_METHOD"] == "POST"){

    $email=mysqli_real_escape_string($con,$_POST['email']);

    $password = mysqli_real_escape_string($con,$_POST['pass']); 
    $pass=encryptthis($password, $key);

  $showquery = "SELECT * FROM admin_login  where email='$email' ";
  $showdata = mysqli_query($con , $showquery);
  $arrdata = mysqli_fetch_array($showdata);

  $p = $arrdata['password'];
  $enc=decryptthis($p, $key);
  if($enc == $password){
    //  $pass1=encryptthis($password, $key);
    
    //  $pass=decryptthis($pass1, $key);
    //  $password = base64_encode($password);
    // $password = md5($password);  
    $sql = "SELECT * FROM admin_login  WHERE email = '$email' ";

    $query = mysqli_query($con , $sql);

    $email_count = mysqli_num_rows($query);
  


    if ($email_count > 0 ){
        $email_pass = mysqli_fetch_array($query);

        $_SESSION["email"] = $email_pass['email'];
        $_SESSION["name"] = $email_pass['name'];
        $_SESSION["phone"] = $email_pass['phone'];
        $_SESSION["pass"] = $email_pass['password'];

        header ("location: admin.php");

    }
    else{
      echo "Invalid Credentials " ;
      echo $enc;
     
  }
}else{
  echo "password not match";
}
   }



?>

<div class="login-page">
  <div class="form">

    
      <lottie-player src="https://assets4.lottiefiles.com/datafiles/XRVoUu3IX4sGWtiC3MPpFnJvZNq7lVWDCa8LSqgS/profile.json"  background="transparent"  speed="3"  style="justify-content: center;" loop  autoplay></lottie-player>
      
      <form  method="POST" action = "<?php echo htmlentities($_SERVER['PHP_SELF']);?>">
      <input type="email" name = "email" placeholder="&#xf007;  Email"/>
      <input type="password" name = "pass" id="password" placeholder="&#xf023;  password"/>
      <i class="fas fa-eye" onclick="show()"></i> 
      <br>
      <br>
      <button name = "SUBMIT" >LOGIN</button>
      <p class="message"></p>
    </form>

    <form class="login-form">
      <button type="button" onclick="window.location.href='signup.php'">SIGN UP</button>
    </form>
  </div>
</div>

  <script>
    function show(){
      var password = document.getElementById("password");
      var icon = document.querySelector(".fas")

      // ========== Checking type of password ===========
      if(password.type === "password"){
        password.type = "text";
      }
      else {
        password.type = "password";
      }
    };
  </script>
</body>
</html>