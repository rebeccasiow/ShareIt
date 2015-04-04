<!DOCTYPE html>
<html>
    <head><title>Registration | File Sharing Site</title></head>
    <body>
        <?php
        include('fileServerFuncts.php');
        // This script assumes a POST variable of "user", which is the username that is requested to be registered
        
        // If no user specified, put bach in login page
        if(!isset($_POST['user'])) {
            header("Location: login.html");
            exit;
        }
        
        // Only allow usernames that don't exist already and are valid
        $user = $_POST['user'];
        if(isUsernameInSystem($user)) {
            printf("<p>The user %s is already registered. <a href=\"login.html\">Login?</a>",htmlentities($user));
            exit;
        }
        
        // TODO: some sort of regex validation?
        
        // It's fine to make user, so setup user in users.txt and make them a directory for their files
        file_put_contents("/srv/mod2/users.txt","\n".$user,FILE_APPEND | LOCK_EX);
        mkdir(getUserDir($user),0775); // reasonably open access mode
        
        printf("<p>The user %s is now registered. <a href=\"login.html\">Login?</a>",htmlentities($user));
        
        ?>
    </body>
</html>