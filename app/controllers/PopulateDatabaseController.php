<?php

class PopulateDatabaseController
{

    public function read()
    {
        $db = DB::getInstance();
        $sql = "show Tables";
        $stmt = $db->prepare($sql);
        $stmt->execute();

        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $tables = [];
        foreach ($data as $index => $array) {
            foreach ($array as $key => $value) {
                $tables[] = $value;
            }
        }

        if ($data != NULL) {

            if (!in_array("user", $tables)) {
                //call sql script to populate db;

                $sql = "CREATE TABLE `user` (
                `id` int(11) UNSIGNED NOT NULL primary key auto_increment,
                `username` varchar(255) NOT NULL,
                `email` varchar(255) NOT NULL,
                `password` varchar(255) NOT NULL,
                `city` varchar(50) DEFAULT NULL,
                `street` varchar(150) DEFAULT NULL
              )";
                $stmt = $db->prepare($sql);
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
                $stmt = $db->prepare($sql);
                $stmt->execute();
            }

            if (!in_array("image", $tables)) {

                $sql = "CREATE TABLE `image` (
                `id` int(11) NOT NULL primary key auto_increment,
                `name` varchar(200) NOT NULL,
                `path` longtext NOT NULL,
                `user_id` int(11) UNSIGNED NOT NULL
              )";
                $stmt = $db->prepare($sql);
                $stmt->execute();
            }

            $sql = "ALTER TABLE `image` 
    ADD FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) 
    ON DELETE CASCADE";
            $stmt = $db->prepare($sql);
            $stmt->execute();

            $sql = "ALTER TABLE `token`
    ADD FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) 
    ON DELETE CASCADE";
            $stmt = $db->prepare($sql);
            $stmt->execute();
        }
    }
}
