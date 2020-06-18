<?php

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

        // $db = DB::getInstance();
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
            time() + 864000,
            '/'
            // false,
            // true // TLS-only
        );
    }


    public function regenerate()
    {

        list($selector, $authenticator) = explode(':', $_COOKIE['remember']);
        $sql = "SELECT * FROM token WHERE selector = :selector";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':selector', $selector);
        $stmt->execute();
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);


        if (hash_equals($row[0]['token'], hash('sha256', base64_decode($authenticator)))) {

            //NAPRAVITI READ IZ BAZE PREMA ID.u I POPUNITI SESSION SVIM PODACIMA
            $_SESSION['userid'] = $row[0]['user_id'];
            // Then regenerate login token as above
            $this->create($row[0]['user_id']);
        }
    }
}
