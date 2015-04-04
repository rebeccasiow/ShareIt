<?php

/*
 * Get string of the path to a file given its short path and the user's username
 */
function getFullPath($username,$filename) {
    $fullPath = sprintf("/srv/mod2/%s/%s",$username,$filename);
    return $fullPath;
}

/*
 * Get string of the path to a user's uploads directory
 */
function getUserDir($username) {
    return sprintf("/srv/mod2/%s",$username);
}

/*
 * Get public directory name
 */

function getPublicDir() {
    return "/srv/mod2/_public";
}

/*
 * Get full path of a public file
 */

function getPublicFullPath($filename) {
    return "/srv/mod2/_public/".$filename;
}

/*
 * Return the owner of a file in the public folder, or null if there is no such public file
 */

function getPublicFileOwner($filename) {
    if(!file_exists(getPublicDir()."/".$filename)) {
        // this is a problem
        return null;
    }
    $h = fopen("/srv/mod2/_public_manifest/$filename","r");
    $user = trim(fgets($h));
    return $user;
}

/*
 * Returns boolean value representing whether or not the user already exists.
 */
function isUsernameInSystem($username) {
    // Checking that the username is in our system
    if($username=="") {
        return false;
    }
    
    $h = fopen("/srv/mod2/users.txt","r");
    while(!feof($h)) {
        if(trim(fgets($h)) == $username) {
            fclose($h); // clean up after ourselves
            return true;
        }
    }
    fclose($h);
    return false;
}

?>
