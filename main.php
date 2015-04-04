<!DOCTYPE html>
<html>
	<link rel="stylesheet" type="text/css" href="style.css" />
    <head><title>File Sharing Site</title></head>
    <body>
        <?php
            include('fileServerFuncts.php');
            session_start();
            
            // If no one is logged in, send back to login screen
            if(!isset($_SESSION['user'])) {
                header("Location: login.html");
                exit;
            }
            
            $user = (string) $_SESSION['user'];
            
            // header w/ welcome message and logout button
            printf("<p>Welcome, %s! <a href=\"logout.php\"> Logout </a></p>",htmlentities($user));
            
            // main body: list of files
            $userDirectory = getUserDir($user);
            $userFiles = scandir($userDirectory);
            
            // remove . and .., which our users don't need to get into
            unset($userFiles[0]);
            unset($userFiles[1]);
            $userFiles = array_values($userFiles); // fix array indices after unset
            
            if($userFiles) {
                echo "<table>\n";
                for($i=0;$i<count($userFiles);++$i) {
                    echo "<tr>";
                    $currentFile = $userFiles[$i];
                    $downloadLink = "downloader.php?filename=$currentFile";
                    $deleteLink = "deleter.php?filename=$currentFile";
                    echo "<td><a href=\"$downloadLink\">$currentFile</a></td>\n";
                    echo "<td><a href=\"$deleteLink\">Delete</a></td>";
                    
                    echo "</tr>";
                }
                echo "</table>\n";
            } else {
                echo "<p> You don't seem to have any files. Would you like to <a href=\"upload/uploadForm.html\"> upload some?</a></p>";
            }
        ?>
        <h2> Public files </h2>
        <?php
        $publicDir = getPublicDir();
        $publicFiles = scandir($publicDir);
        
        // remove . and .., which our users don't need to get into
        unset($publicFiles[0]);
        unset($publicFiles[1]);
        $publicFiles = array_values($publicFiles); // fix array indices after unset
        
        if($publicFiles) {
            echo "<table>\n";
            for($i=0;$i<count($publicFiles);++$i) {
                echo "<tr>";
                $currentFile = $publicFiles[$i];
                $uploader = getPublicFileOwner($currentFile);
                if($uploader==null) {
                    $uploader = "??";
                }
                
                $downloadLink = "downloader.php?filename=$currentFile&public=true";
                $deleteLink = "deleter.php?filename=$currentFile&public=true";
                echo "<td><a href=\"$downloadLink\">$currentFile</a></td>\n";
                echo "<td>Uploaded by $uploader</td>";
                if($uploader == $user) {
                    echo "<td><a href=\"$deleteLink\">Delete</a></td>";
                }
                
                echo "</tr>";
            }
            echo "</table>\n";
        } else {
            echo "<p> There don't seem to be any public files. </p>";
        }
        
        
        ?>
        <!-- upload button -->
        <a href="upload/uploadForm.html"> Upload </a>
        
    </body>
</html>