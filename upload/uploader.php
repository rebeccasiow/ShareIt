<?php
// based on example in class wiki
include('../fileServerFuncts.php');

session_start();

if(!isset($_FILES['uploadedFile'])) {
    echo "No file recieved from form. <a href=\"uploadForm.html\">Try again?</a>";
}


$filename = basename($_FILES['uploadedFile']['name']);

// If no one is logged in, send back to login screen
if(!isset($_SESSION['user'])) {
    header("Location: login.html");
    exit;
}

$username = $_SESSION['user'];
 
if(isset($_POST['make_file_public']) && $_POST['make_file_public']==true) { // public file
    
    $fullPath = getPublicFullPath($filename);
    
} else {
    $fullPath = getFullPath($username, $filename);
}
 
if(move_uploaded_file($_FILES['uploadedFile']['tmp_name'], $fullPath)) {
    // must make manifest file connected to user before we can duck out
    file_put_contents("/srv/mod2/_public_manifest/".$filename,$username);
    
    header("Location: upload_success.html");
    exit;
} else {
    header("Location: upload_failure.html");
    exit;
}
 
?>