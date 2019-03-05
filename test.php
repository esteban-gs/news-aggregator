<?php
//place feeds into session vars
session_start();

//set caching time by minutes
$maxCacheMinutes = 1;


//
if(!isset($_SESSION['begin']))
{//create datestamp in session var
    $_SESSION['begin'] = date("h:i:sa", time());
    echo 'session was created. The Session created time is:<br>';
    var_dump($_SESSION['begin']);
    
}elseif(isset($_SESSION['begin']))
{//provide some helpful info
    //echo '<p>This is the time in php format ';
    //echo strtotime($_SESSION['begin']);
    //echo '</P>';
    
    //how long since session was last cached
    $_SESSION['timeDiff'] = (time() - strtotime($_SESSION['begin'])) / 60;
    
}


//Time difference actions
if($_SESSION['timeDiff'] <= $maxCacheMinutes)
{
    echo 'Session already exists the session was created at <b>';
    echo $_SESSION['begin'] . '</b>';
    
    //when session will be refreshed
    $willCache = strtotime($_SESSION['begin']) + 60;
    
    echo'<p>Session will be refreshed at ' . date("h:i:sa", $willCache) . '</p>';
    
    echo '<p>It has been ' . $_SESSION['timeDiff'] . ' minutes since the session started</p>';
    
    
}elseif($_SESSION['timeDiff'] > $maxCacheMinutes )
{//If session has been cashed for longer than..
    $_SESSION['begin'] = date("h:i:sa", time());
    echo 'session was created again because data was cashed for over '.$maxCacheMinutes.' minutes. The Session was cashed again at:<br>';
    var_dump($_SESSION['begin']);
}//end elseif




//session_destroy();
