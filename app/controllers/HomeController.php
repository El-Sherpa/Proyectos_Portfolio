<?php
class HomeController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function index() {
        session_start();
        require_once '../app/views/home/index.php';
    }
}
?>
