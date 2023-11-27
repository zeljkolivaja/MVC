<?php

namespace App\Models;

class Seed extends Model
{

    public function read()
    {
        $sql = "show Tables";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $data = $stmt->fetchAll(\PDO::FETCH_ASSOC);


        $tables = [];
        foreach ($data as $index => $array) {
            foreach ($array as $key => $value) {
                $tables[] = $value;
            }
        }

        if (
            in_array("user", $tables) && in_array("token", $tables)
            && in_array("image", $tables)
        ) {
            return false;
        }

        try {
            if (!in_array("user", $tables)) {

                $sql = "CREATE TABLE `user` (
                    `id` int(11) UNSIGNED NOT NULL primary key auto_increment,
                    `username` varchar(255) NOT NULL,
                    `email` varchar(255) NOT NULL UNIQUE,
                    `password` varchar(255) NOT NULL,
                    `city` varchar(50) DEFAULT NULL,
                    `street` varchar(150) DEFAULT NULL
                  )";
                $stmt = $this->db->prepare($sql);
                $stmt->execute();

                $password = password_hash("12345678", PASSWORD_BCRYPT);

                $sql = "INSERT INTO user (username, email, password, city, street) VALUES (:username, :email, :password, :city, :street)";
                $stmt = $this->db->prepare($sql);
                $stmt->bindValue(':username', "Test");
                $stmt->bindValue(':email', "test@gmail.com");
                $stmt->bindValue(':password', $password);
                $stmt->bindValue(':city', "Osijek");
                $stmt->bindValue(':street', "Osjecka 21");
                $stmt->execute();
            }

            if (!in_array("token", $tables)) {

                $sql = "CREATE TABLE `token` (
                    `id` int(11) NOT NULL primary key auto_increment,
                    `selector` char(12) NOT NULL,
                    `token` char(64) NOT NULL,
                    `user_id` int(11) UNSIGNED NOT NULL,
                    `expires` datetime NOT NULL
                  )";
                $stmt = $this->db->prepare($sql);
                $stmt->execute();
            }

            if (!in_array("image", $tables)) {

                $sql = "CREATE TABLE `image` (
                    `id` int(11) NOT NULL primary key auto_increment,
                    `name` varchar(200) NOT NULL,
                    `path` longtext NOT NULL,
                    `user_id` int(11) UNSIGNED NOT NULL,
                    `file_path` longtext NOT NULL
                  )";
                $stmt = $this->db->prepare($sql);
                $stmt->execute();
            }

            $sql = "ALTER TABLE `image` 
        ADD FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) 
        ON DELETE CASCADE";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();

            $sql = "ALTER TABLE `token`
        ADD FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) 
        ON DELETE CASCADE";

            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return true;
        } catch (\Throwable $th) {
            $message = "Something went wrong,
             make sure your database " . DB_NAME . " is empty and try again " . $th;
            \App\Controllers\ErrorController::logError($message);
        }
    }
}
