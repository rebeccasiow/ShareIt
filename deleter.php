<!DOCTYPE HTML>

<html>
<head>
<title>File Deleted!</title>
<meta charset="utf-8"/>
</head>
<body>
<?php

/*
 * Delete the path to a file and the file.
 */
 
session_start();

include('fileServerFuncts.php');

// If no one is logged in, send back to login screen
if(!isset($_SESSION['user'])) {
    header("Location: login.html");
    exit;
}

//get filename and username for a session
$user = (string) $_SESSION['user'];
$filename = (string)$_GET['filename'];

if(isset($_GET['public']) && $_GET['public']==true) { // public file
    
    $deleteFile = getPublicFullPath($filename);
    if(getPublicFileOwner($filename) != $user) {
        echo "<p>You do not own ".htmlentities($filename).". It cannot be deleted.</p>";
    }
    
} else { // private file
    
    $deleteFile = getFullPath($user,$filename);
}

$h = @fopen($deleteFile,"r");
@fclose($h);
@unlink($deleteFile);
// TODO: is just ignoring these errors ok?

if(!file_exists($deleteFile)) {
        echo "File successfully deleted. <a href=\"main.php\"> Go home <\a>";
        exit;
}

?>

</body>

</html>
