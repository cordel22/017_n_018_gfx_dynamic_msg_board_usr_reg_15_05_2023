<?php # Script 18.7 - activate.php
//  This page activates the user's account.
require('includes/config.inc.php');
$page_title = 'Activate Your Account';
include('includes/header.html');
/*  sisehoc@hotmail.com activation url
however, add the include!!! folder
http://localhost:3000/activate.php?x=sisehoc%40hotmail.com&y=afd9d1d066b249e401441fdf5e31762e

 */
//  If $x and $y don't exist or aren't of the proper format,
//  redirect the user:      //  $_GET['x'] p 586 line below $trimmed['email']
if (
  isset($_GET['x'], $_GET['y']) && filter_var($_GET['x'], FILTER_VALIDATE_EMAIL)
  && (strlen($_GET['y']) == 32)
) {
  //  Update the database...
  require(MYSQL);
  // $q = "UPDATE users SET active=NULL WHERE (email='" .
  //   mysqli_real_escape_string($dbc, $_GET['x']) . "' AND
  //     active='" . mysqli_real_escape_string($dbc, $_GET['y']) . "') LIMIT 1";
  // $r = mysqli_query($dbc, $q) or trigger_error("Query: 
  //     $q\n<br />MySQL Error: " . mysqli_error($dbc));

  //  bacha!!!
  /*  for this code, you need the active column condition, which you dont have, so skip this
  $sql = "UPDATE users SET active = :name
           WHERE (email = :email  AND active = :active) LIMIT 1";
  $stmt = $pdo->prepare($sql);
  $stmt->execute(array(
    ':name' => NULL,
    ':email' => $_GET['x'],
    ':active' => $_GET['y']
  )); //  or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));
    end bacha!!!  */

  //  Print a customized message:
  //  if (mysqli_affected_rows($dbc) == 1) {
  /*  bacha!!!
  if ($stmt->rowCount() == 1) {  end bacha!!!   */
    echo "<h3>Your account is now active.
      You may now log in.</h3>";
  /*  bacha!!!
  } else {
    echo '<p class="error">Your account could not be activated.
      Plese re-check the link or contact the system administrator.</p>';
  }  end bacha!!!  */
  
  //  mysqli_close($dbc);
  $stmt = null;
} else {
  //  Redirect.
  //  login original url redirect to forum!!!
  $url = BASE_URL . 'index.php';  //  Define the URL.
  //  vlastne asi dobre
  //  $url = '../index.php';  //  Define the URL.
  ob_end_clean(); //  Delete the buffer.
  header("Location: $url");
  exit(); //  Quit the script.
} //  End of main IF-ELSE.

include('includes/footer.html');