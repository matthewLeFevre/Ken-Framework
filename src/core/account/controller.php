<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/src/include.php';


use ReallySimpleJWT\Jwt;
use ReallySimpleJWT\Parse;
use ReallySimpleJWT\Validate;
use ReallySimpleJWT\Encode;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

/**
 * Instantiat a new controller
 * and specify endpoints
 */

class Account extends Controller
{
    public $mail;

    public function __construct()
    {
        $this->mail = new PHPMailer(true);
        // $this->mail->SMTPDebug = SMTP::DEBUG_SERVER; comment back in if you want debug information
        $this->mail->isSMTP();
        $this->mail->Host = $_ENV['KEN_MAIL_HOST'];
        $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $this->mail->SMTPAuth = true;
        $this->mail->Username = $_ENV['KEN_MAIL_USERNAME'];  // SMTP username (your email account)
        $this->mail->Password = $_ENV['KEN_MAIL_PASSWORD'];          // SMTP password
        $this->mail->Port = $_ENV['KEN_MAIL_PORT'];
        $this->mail->IsHTML(true);                     // set email format to HTML
    }
    /**
     * Check Password Hash
     * --------------------
     * 
     * Supply the password hash of the account
     * if and the password sent by the client.
     * When the hashes match authenticate the user.
     */
    public static function checkPass($pass, $hash)
    {
        if (!password_verify($pass, $hash)) {
            echo Response::err("Username or Password is incorrect");
            exit;
        }
    }
}
