<?php

$is_localhost = $_SERVER['REMOTE_ADDR'];
if ($is_localhost == '127.0.0.1' || $is_localhost == '::1') {
    define('DB_DBNAME', 'hospitale2n');
    define('DB_USER', 'root');
    define('DB_PWD', '');
} else {
    define('DB_DBNAME', 'vahu6104_hopitalE2N');
    define('DB_USER', 'vahu6104_adminHopitalE2N');
    define('DB_PWD', 'jesuislemedcin');
}
class database {

    private static $instance = null;
    public $db = null;

    public function __construct() {
        try {
            $this->db = new PDO('mysql:dbname=' . DB_DBNAME .';host=localhost;charset=UTF8', DB_USER, DB_PWD, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        } catch (Exception $ex) {
            die('Une erreur au niveau de la base de donnée s\'est produite !');
        }
    }

    public static function getInstance() {
        if (is_null(self::$instance)) {
            self::$instance = new database();
        }
        return self::$instance->db;
    }
}
