<?php

namespace App\Models;

class Token extends Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function create($userId)
    {
        $selector = base64_encode(random_bytes(9));
        $authenticator = random_bytes(33);

        $token = hash('sha256', $authenticator);

        $sql = "INSERT INTO token (selector, token, user_id, expires) VALUES (:selector, :token, :userid, :expires)";
        $stmt = $this->db->prepare($sql);

        $stmt->bindValue(':selector', $selector);
        $stmt->bindValue(':token', $token);
        $stmt->bindValue(':userid', $userId);
        $stmt->bindValue(':expires', date('Y-m-d\TH:i:s', time() + 864000));
        $stmt->execute();


        setcookie(
            'remember',
            $selector . ':' . base64_encode($authenticator),
            [
                'expires' => time() + 864000,
                'path' => '/',
                //'secure' => true, enable this with https
                'httponly' => true, //prevents JS from accessing cookie
                'samesite' => 'Lax', //prevent cookie being sent to other websites
            ]
        );
    }


    public function regenerate()
    {

        //take the selector and authenticator from cookie, find the token with the selector
        //try to match the token from the database with the token from the cookie
        //if they match set the session and make the new token and cookie
        list($selector, $authenticator) = explode(':', $_COOKIE['remember']);
        $sql = "SELECT * FROM token WHERE selector = :selector";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':selector', $selector);
        $stmt->execute();
        $row = $stmt->fetchAll(\PDO::FETCH_ASSOC);


        if (hash_equals($row[0]['token'], hash('sha256', base64_decode($authenticator)))) {

            //we find the user with the id we get from token, then we fill the session with his data
            //and create new token
            $userModel = new User;
            $user = $userModel->read($row[0]['user_id']);

            $session = \App\Controllers\SessionController::getInstance();
            \App\Controllers\SessionController::generateCSRF();
            $session->setSession($row[0]['user_id'], $user['username'], $user['email']);

            $this->create($row[0]['user_id']);
        }
    }
}
