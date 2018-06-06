<?php

// run sanitizing and validating flags on email
  check_email($email){
    $sanEmail = filter_var($email, FILTER_SANITIZE_EMAIL);
    $valEmail = filter_var($sanEmail, FILTER_VALIDATE_EMAIL);
    return $valEmail;
  }

// Ensure that the password contains proper characters (Optional)
// possibly need to add an error handler to notify user password does not contain
// required charachters not sure though
  check_password(){
    $pattern = '/^(?=.*[[:digit:]])(?=.*[[:punct:]])[[:print:]]{8,}$/';
    return preg_match($pattern, $password);
  }
