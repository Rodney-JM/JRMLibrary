<?php

class Connection
{
    public static function connect($set)
    {
        $settings = parse_ini_file($set);

        $dns = "mysql:host={$settings['host']};dbname={$settings['dbname']}";

        $pdo = new PDO(
            $dns,
            $settings["user"],
            $settings["password"],
        );

        return $pdo;
    }
}