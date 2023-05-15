<?php # Script 18.6 - register.php
//  This is the registration page for the site.

//  Include the configuration file:
require('includes/config.inc.php');

//  Set the page title and include the HTML header:
$page_title = 'Register';
include('includes/header.html');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  //  Handle the form.

  //  Need the database connection:
  require(MYSQL);

  //  Trim all the incoming data:
  $trimmed = array_map('trim', $_POST);

  //  Assume invalid values:
  $fn = $ln = $e = $p = FALSE;

  //  Check for a first name:
  /*  careful, you dont put into ch18 but forum2!!! there is only name!!!!
  if (preg_match('/^[A-Z \'.-]{2,20}$/i', $trimmed['first_name'])) {
    //  $fn = mysqli_real_escape_string($dbc, $trimmed['first_name']);  //  not necessary when using PDO  https://stackoverflow.com/questions/15648228/how-to-use-write-mysql-real-escape-string-in-pdo
    $fn = $trimmed['first_name'];
  } else {
    echo '<p class="error">Please enter your first name!</p>';
    echo 'lets see, you put in : ' . $trimmed['first_name'];    //  this line aint in book
  }


  //  Check for a last name:
  if (preg_match('/^[A-Z \'.-]{2,40}$/i', $trimmed['last_name'])) {
    //  $ln = mysqli_real_escape_string($dbc, $trimmed['last_name']);   //  not necessary when using PDO  https://stackoverflow.com/questions/15648228/how-to-use-write-mysql-real-escape-string-in-pdo
    $ln = $trimmed['last_name'];
  } else {
    echo '<p class="error">Please enter your last name!</p>';
    //  echo 'lets see, you put in : ' . $trimmed['last_name'];
  }
  */
  //  Check for a name:
    if (preg_match('/^[A-Z \'.-]{2,40}$/i', $trimmed['name'])) {
      $n = $trimmed['name'];
    } else {
      echo '<p class="error">Please enter your name!</p>';

    }

  //  Check for an email address:
  if (filter_var($trimmed['email'], FILTER_VALIDATE_EMAIL)) {
    //  $e = mysqli_real_escape_string($dbc, $trimmed['email']);    //  not necessary when using PDO  https://stackoverflow.com/questions/15648228/how-to-use-write-mysql-real-escape-string-in-pdo
    $e = $trimmed['email'];
  } else {
    echo '<p class="error">Please enter a valid email address!</p>';
    //  echo 'lets see, you put in : ' . $trimmed['email'];
  }

  //  Check for a password and match aginst the confirmed password:
  if (preg_match('/^\w{4,20}$/', $trimmed['password1'])) {
    if ($trimmed['password1'] == $trimmed['password2']) {
      //  $p = mysqli_real_escape_string($dbc,  $trimmed['password1']);   //  //  not necessary when using PDO  https://stackoverflow.com/questions/15648228/how-to-use-write-mysql-real-escape-string-in-pdo
      $p = $trimmed['password1'];
    } else {
      //  echo '<p class="error">Your password did not match the confirmed password!</p>';
    }
  } else {
    echo '<p class="error">Please enter a valid password!</p>';
    //  echo 'lets see, you put in : ' . $trimmed['password1'];
  }

  if ($n && $e && $p) {
    //  If everything's OK...
    //  Make sure the email address is available:
    //  $q = "SELECT user_id FROM users WHERE email='$e'";
    //  $r = mysqli_query($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));

    $q = "SELECT user_id FROM users WHERE email='$e'";
    $stmt = $pdo->query($q); //  or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));;
    $row_count = $stmt->rowCount();

    //  if (mysqli_num_rows($r) == 0) {
    if ($row_count == 0) {
      //  Available.

      //  Create the activation code:
      $a = md5(uniqid(rand(), true));

      //  Add the user to the database:
      // $q = "INSERT INTO users (email, pass, first_name, last_name, active,
      // registration_date) VALUES ('$e', SHA1('$p'), '$fn', '$ln', '$a', NOW() )";
      // $r = mysqli_query($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));
//  WATCH OUT!!!  forum2 users can not activatte, so register here, and you are good to go!!!
      $sql = "INSERT INTO users (lang_id, time_zone, email, pass, username/*, active,
      registration_date*/) VALUES (:lang_id,:time_zone, :email, :pass, :username/*, :active, NOW() */)";
      //  $r = mysqli_query($dbc, $q);
      $stmt = $pdo->prepare($sql);
      $r = $stmt->execute(array(
        ':lang_id' => 1,
        ':time_zone' => 'America/New_York',
        ':email' => $e,
        //  ':pass' => SHA1('$p'),  //  todo, u sure bout the string quotes''?
        ':pass' => SHA1($p),
        ':username' => $n,
        /*  ':active' => $a,  */
        //  ':registration_date' => $subject
      ));


      //  if (mysqli_affected_rows($dbc) == 1) {
      if ($stmt->rowCount() == 1) {
        //  If it ran OK.

        /* 
        // configure smtp server
        ini_set('SMTP', 'tls://smtp.gmail.com');
        //  ini_set('smtp_port', '465');
        ini_set('smtp_port', '587');
        ini_set("sendmail_from", "cordelfenevall@gmail.com");
 */

        //  Send the email:
        $body = "Thank you for registering at <thiswebsite.com>.
        To activate your account, please click on this link:\n\n";
        //  add the login folder into url!!!
        //  $body .= BASE_URL . 'activate.php?x=' . urlencode($e) . "&y=$a";  //  tento urlencode hodi vzdy stejny output?
        $body .= BASE_URL . 'login/activate.php?x=' . urlencode($e) . "&y=$a";  //  tento urlencode hodi vzdy stejny output?
        /* 
        //  don't send it now, u dont have the mail server setup, in demo, 
        //  just show the link to his login on the same page
        mail($trimmed['email'], 'Registration Confirmation', $body, 'From: cordelfenevall@gmail.com ');
 */
        //  Finish the page:
        echo '<h3>Thank you for registering! A confirmation email has been sent to your address.
        Please click on the link in that email in order to activate your account.</h3>';


        //  if the mail server doesnt work, just in demo, login from this page
        $nosmtp = "<div>
              By the way, since we re on localhost and smtp has not been set up, \n\n
              won't you try the following link cause aint none in your mailbox:\n\n";
        //  $nosmtp .=  BASE_URL . 'activate.php?x=' . urlencode($e) . "&y=$a";     //  mas stejny urlencode outputnuty ak v dB..?
        $nosmtp .=  BASE_URL . 'login/activate.php?x=' . urlencode($e) . "&y=$a";     //  mas stejny urlencode outputnuty ak v dB..?
        $nosmtp .=  "</div>";

        echo $nosmtp;

        include('includes/footer.html'); //  Include the HTML footer.
        exit(); //  Stop the page.
      } else {
        //  If it did not run OK.
        echo '<p class="error">You could not be registered due to a system error.
        We apologie for any inconvenience.</p>';
      }
    } else {
      //  The email address is not available.
      echo '<p class="error">
        That email address has already been registered.
        If you have forgotten your password, 
        use the link at right to have your password sent to you.
        </p>';
    }
  } else {
    //  If one of the data tests failed.
    echo '<p class="error">Plese try again.</p>';
  }

  //  mysqli_close($dbc);
  //  https://stackoverflow.com/questions/18277233/pdo-closing-connection
  $stmt = null;
} //  End of the main Submit conditional.
?>

<h1>Register</h1>
<form action="register.php" method="post">
  <fieldset>
    <!--
    <p><b>First Name:</b>
      <input type="text" name="first_name" size="20" maxlength="20" value="
          <?php
    /*      if (isset($trimmed['first_name']))
            echo $trimmed['first_name'];  */
          ?>
        " />
    </p>

    <p><b>Last Name:</b>
      <input type="text" name="last_name" size="20" maxlength="40" value="
          <?php
    /*      if (isset($trimmed['last_name']))
            echo $trimmed['last_name'];  */
          ?>
        " />
    </p>
-->
    <p><b>Name:</b>
      <input type="text" name="name" size="20" maxlength="40" value="
          <?php
          if (isset($trimmed['name']))
            echo $trimmed['name'];
          ?>
        " />
    </p>

    <p><b>Email Address:</b>
      <input type="text" name="email" size="30" maxlength="60" value="
          <?php
          if (isset($trimmed['email']))
            echo $trimmed['email'];
          ?>
        " />
    </p>

    <p><b>Password:</b>
      <input type="password" name="password1" size="20" maxlength="20" value="
          <?php
          if (isset($trimmed['password1']))
            echo $trimmed['password1'];
          ?>
        " />
      <small>
        Use only letters, numbers, and the underscore.
        Must be between 4 and 20 charactes long.
      </small>
    </p>

    <p><b>Confirm Password:</b>
      <input type="password" name="password2" size="20" maxlength="20" value="
          <?php
          if (isset($trimmed['password2']))
            echo $trimmed['password2'];
          ?>
        " />
    </p>
  </fieldset>

  <div align="center">
    <input type="submit" name="submit" value="Register" />
  </div>
</form>

<?php include('includes/footer.html'); ?>