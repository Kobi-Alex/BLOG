<?php
    require_once 'pdo_ini.php';

    function checkingCorrecDataMigrations($pdo, $sql){
        try {
            $pdo->exec($sql);
            echo("success");
            echo PHP_EOL;
        } catch (PDOException $ex) {
            die("ERROR: " . $ex->getMessage());
        }
    };