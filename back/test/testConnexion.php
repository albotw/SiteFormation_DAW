<?php
require_once(__DIR__ . "./../controllers/connexion.php");
session_start();
//createAccount("IAN", "TRUE", "aaa@gmail.com", "aaa"); OK

login("aaa@gmail.com", "aaa");