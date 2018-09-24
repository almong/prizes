<?php
    session_start();

    if (!empty($_SESSION)){
        require 'template/prize.php';
    } else {
        require 'template/auth.php';
    }
    