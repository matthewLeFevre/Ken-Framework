<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/src/include.php';

use ReallySimpleJWT\Token;
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
            echo json_encode(Response::err("Username or Password is incorrect"));
            exit;
        }
    }

    /**
     * Check Role and privilage of requestor
     * -------------------------------------
     * 
     * Allows the api author to restrict endpoints
     * to rolls or even rols with specific privillages
     * or just privallages
     * 
     * @todo check privillages
     */
    public static function checkRole($options = ['token' => null, 'role' => null, 'priviledge' => null])
    {
        try {
            $id = Token::getPayload($options['token'], $_ENV['KEN_SECRET'])['user_id'];
            $accountData = AccountModel::getOne(['id' => $id]);
            if ($accountData['role'] != $options['role']) {
                echo json_encode(Response::err("Access denied"));
                exit;
            }
        } catch (Exception $e) {
            echo json_encode(Response::err($e->getMessage()));
            exit;
        }
    }

    /**
     * Check Id of requestor
     * ---------------------
     * 
     * Ensures that the id of the user being updated
     * is the id of the user sending the request
     */
    public static function checkId($token, $compareId)
    {
        try {
            $id = Token::getPayload($token, $_ENV['KEN_SECRET'])['user_id'];
            if ($id != $compareId) {
                echo json_encode(Response::err("Access denied"));
                exit;
            }
        } catch (Exception $e) {
            echo json_encode(Response::err($e->getMessage()));
            exit;
        }
    }

    /**
     * Check Email So There are no duplicates
     * --------------------------------------
     * 
     * Ensures that when an account is updated
     * or created no duplicates are made.
     */
    public static function checkEmail($email)
    {
        if (!Controller::isEmail($email)) {
            echo json_encode(Response::err("Invalid Email"));
            exit;
        }
        $email = Controller::filterEmail($email);
        $accountData = AccountModel::getByEmail(['email' => $email]);
        if (isset($accountData['id'])) {
            echo json_encode(Response::err('That email address is already in use. Please try to log in with a current account or try a new email address.'));
            exit;
        }
    }
}
