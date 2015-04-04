<?php
    // given that a user is logged in, uses their username and a filename supplied by GET to retrieve the file
    include('fileServerFuncts.php');
    session_start();
    
    // If no one is logged in, send back to login screen
    if(!isset($_SESSION['user'])) {
        header("Location: login.html");
        exit;
    }
    
    $user = (string) $_SESSION['user'];
    
    if(!isset($_GET['filename'])) {
        echo "No file given. <a href=\"main.php\"> Go home <\a>";
        exit;
    }

    $filename = (string)$_GET['filename'];
    
    if(isset($_GET['public']) && $_GET['public']==true) { // public file
        
        $fullPath = getPublicFullPath($filename);
        
    } else { // file is private
        
        $fullPath = getFullPath($user,$filename);
        
    }
    
    if(!file_exists($fullPath)) {
        echo "File does not exist. <a href=\"main.php\"> Go home <\a>";
        exit;
    }
    
    // Now we know that everything is valid
    
    // get the file's MIME type and read it as such
    
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->file($fullPath);
    header("Content-Type: $mime");
    readfile($fullPath);
?>
