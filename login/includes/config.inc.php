<?php # Script 18.3 - config.inc.php
/*  This script:
 * - define constants and settings
 * - dictates how errors are handled
 * - defines useful functions
 */

// Created by Don Double C, 19/12/2021 

// ************************************************** //
// *******************SETTINGS*********************** //

// Flag vaariable for site status: 
define('LIVE', FALSE);

//  Admin contact address:
define('EMAIL', 'cordelfenevall@gmail.com');

// Site URL (base for all redirections):
define('BASE_URL', 'http://localhost:3000/');   //  when online 'http://www.example.com/'

//  modify next lines!!!

// Absolute location of the MySQL connection script:
//  define('MYSQL', 'C:\Users\Sisi\Desktop\akcia_14_07_21\php-14-07-21\gfx_dynamic_php_mysql\018_gfx_dynamic_usr_reg_pdo\pdo.php');    //  where '/path/to/mysqli_connect.php'
//  define('MYSQL', 'C:/Users/Sisi/Desktop/akcia_14_07_21/php-14-07-21/gfx_dynamic_php_mysql/018_gfx_dynamic_usr_reg/mysqli_connect.php');
//  define('MYSQL', 'C:\wamp\www\018_gfx_dynamic_usr_reg_pdo\pdo.php');    //  where '/path/to/mysqli_connect.php'
//  define('MYSQL', 'C:\wamp\www\018_gfx_dynamic_usr_reg_pdo_09_03_2023\pdo.php');
define('MYSQL', 'C:\wamp\www\017_n_018_gfx_dynamic_msg_board_usr_reg_11_05_2023\pdo.php');

// Adjust the time zone for PHP 5.1 and greater:
date_default_timezone_set('US/Eastern');


// *******************SETTINGS*********************** //
// ************************************************** //

// ************************************************** //
// ****************ERROR MANAGEMENT****************** //

// Create the error handler:
function my_error_handler($e_number = null, $e_message = null, $e_file = null, $e_line = null, $e_vars = null)
{
  //  Build the error message:
  $message = "An error occured in script 
    '$e_file' on line $e_line: $e_message\n";

  //  Add the date and time:
  $message .= "Date/Time: " . date('n-j-Y H:i:s') . "\n";

  if (!LIVE) {
    //  Development (print the error).

    //  Show the error message:
    echo '<div class="error">' . nl2br($message);

    //  add the variables and a backtrace:
    echo '<pre>' . print_r($e_vars, 1) . "\n";
    debug_print_backtrace();
    echo '</pre></div>';
  } else {
    //  Don't show the error:
    //  Send an email to the admin:
    $body = $message . "\n" . print_r($e_vars, 1);
    mail(EMAIL, 'Site Error!', $body, 'From: email@example.com');

    //  Only print an error mesage if the error isn't a notice:
    if ($e_number != E_NOTICE) {
      echo '<div class="error">A system error occurred. 
        We apologize for the inconvenience.</div><br />';
    }
  } //  End of !LIVE IF.
} //  End of my_error_handler() definition.

//  Use my_error_handler:
set_error_handler('my_error_handler');  //  chaper 8 s pozri jak ten error handling funguje
  
  
  
  // ****************ERROR MANAGEMENT****************** //
  // ************************************************** //