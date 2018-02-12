<?php
    define('DB_DSN','mysql:host=localhost;dbname=yodeling_zack');
    define('DB_USER','yodeling_zack');
    define('DB_PASS','Plan3t3arth');   
    
    try {
        $db = new PDO(DB_DSN, DB_USER, DB_PASS);
    } catch (PDOException $e) {
        print "Error: " . $e->getMessage();
        die(); // Force execution to stop on errors.
    }
?>