<?php

require_once '.' . DIRECTORY_SEPARATOR . 'functions.php';
$pages = require_once '.' . DIRECTORY_SEPARATOR . 'pages.php';

const BASE_DIR = __DIR__;
$feedback = array();

if(isset($_GET['show'])){
    if(array_key_exists($_GET['show'], $pages)){
        $page = $_GET['show'];
    }
    else{
        $page = 'notfound';
    }
}
else{
    $page = 'home';
}

session_start();
if(!isset($_SESSION['uID']) && isset($_COOKIE[session_name()]) && is_numeric($_COOKIE[session_name()])){
        $_SESSION['uID'] = $_COOKIE[session_name()];
}
elseif(isset($pages[$page]['login']) && !isset($_SESSION['uID'])){
    /**
     * if no session is registered and 'remember me' was not checked
     * and still the page needs authentication
     */
    $page = 'login';
}

if(isset($pages[$page]['preprocess'])){
    foreach($pages[$page]['preprocess'] as $preprocessName => $preprocessFile){
        $feedback[$preprocessName] = require BASE_DIR . DIRECTORY_SEPARATOR . 'pages' . DIRECTORY_SEPARATOR . $preprocessFile;
    }
}

render('layout.php', compact('page', 'feedback', 'pages'));
