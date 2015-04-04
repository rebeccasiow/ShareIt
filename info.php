<!DOCTYPE html>
	<link rel="stylesheet" type="text/css" href="style.css" />
<html>
<head>
    <title>Finishing login | File Sharing Site</title>
</head>
<body>
    <?php
        include('fileServerFuncts.php');
        // This page is supposed to be reached during login, with a 'user' POST variable incoming.
        echo "<p>We are logging you in\n</p>";
        
        if (isset($_POST['user'])) {
            $user = $_POST['user'];
            
            $foundUser = isUsernameInSystem($user);
            
            if($foundUser) {
                printf("<p>welcome, %s!</p>",htmlentities($user));
                session_start();
                $_SESSION['user'] = $user;
                
                header( "refresh:5; url=main.php" );
                echo 'You\'ll be redirected in about 5 secs. If not, click <a href="main.php">here</a>.';
            } else { // !$foundUser
                printf("<p>There is no user \"%s\" in the system.</p>",htmlentities($user));
                
                header( "refresh:5; url=login.html" );
                echo 'You\'ll be redirected in about 5 secs. If not, click <a href="login.html">here</a>.';
                //exit; // don't need anymore for this format, I think. Check with TAs.
            }
            
        } else {  // !isset($_POST['user'])
            echo "<p>No username entered. Redirecting to login page.</p>";
            header( "refresh:5; url=login.html" );
            echo 'You\'ll be redirected in about 5 secs. If not, click <a href="login.html">here</a>.';
        }
    ?>
</body>
</html>