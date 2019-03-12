<?php 
session_name( 'feeds' );
session_start();
include 'includes/feed_inc.php';



//****** C A T E G O R Y   S E L E C T O R ******//

if(isset($_POST['cat'])){
    $myActiveClass = 'active';
}


/*
session_destroy();
echo '<span class="badge badge-pill badge-danger">Success!</span>';
die();
*/

///looks like problem is in functions
echo 'session count before adding a counter ' . $_SESSION['counter'] . '<br>';


if(!isset($_SESSION['counter'])) {
    $_SESSION['counter'] = 0;
}

$_SESSION['counter']++;

if($_SESSION['counter'] < 2){
    //************New session**************/
    
    echo 'Welcome. This is a NEW session<br>';
    
    //get feed and save in session var
    getFeed('science');    
    
    //get htmlView from feed
    $myFeedView = getFeedView();
    
    $myFeedView['feedState'] = 'fresh';
    
    echo 'session count after getFeed ' . $_SESSION['counter'] . '<br>' ;
    
    echo '<pre>';
    //var_dump($myFeed);
    echo '</pre>';
    
    //print a summary of new feed action
    $myWarning = '
    <div class="alert alert-dismissible alert-danger">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      <strong>session was created. The Session created time is: ' . date("h:i:sa", $_SESSION['timestamp']) . ' </strong>
    </div> 
    ';    
}
else{        
    //*******if time is up refresh***********//
    if(time() >= $_SESSION['refreshTime']) 
    {
        $myWarning = '
        <div "alert alert-dismissible alert-warning">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          <strong>Time to refresh!!!!!</strong>
        </div> 
        ';

        $_SESSION['counter'] = 0; // reset counter
        //header("Refresh:0"); // refresh page
        echo '<script>window.location.reload()</script>';
        
    }
   
    //*************echo cached session*****************//
    echo 'This is a cached session<br>';
    echo 'session count after ' . $_SESSION['counter'] . '<br>';
    //get a cached feed
    
    //get html view from raw session var, rawFeed 
    $myFeedView = getFeedView();
    $myFeedView['feedState'] = 'cached';
    
    echo '<br>';
    echo'This is the timestamp ';
    var_dump($_SESSION['timestamp']);
    echo '<br>';    
    
    echo '<br>';
    echo'This is the refresh time ';
    var_dump($_SESSION['refreshTime']);
    echo '<br>';    
    
    echo '<br>';
    echo'This is the current time ';
    var_dump(time());
    echo '<br>';
    
    
    $myWarning = '
    <div class="alert alert-dismissible alert-danger">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      <strong>Session already exists the session was created at '. date("h:i:sa", $_SESSION['timestamp']) . ' seconds. The Session will refresh at: ' . date("h:i:sa", $_SESSION['refreshTime']) . '</strong>
    </div> 
    ';

    
    //var_dump($myFeed);
    
    
}// end else
?>


<!DOCTYPE html>
<html>
    
<head>
  <title>News Aggregator</title>
  <meta charset="UTF-8">
    
<link rel="stylesheet" href="https://bootswatch.com/4/cerulean/bootstrap.min.css">
<link rel="stylesheet" href="https://bootswatch.com/4/cerulean/_bootswatch.scss">
<link rel="stylesheet" href="https://bootswatch.com/4/cerulean/bootstrap.css">
<link rel="stylesheet" href="https://bootswatch.com/4/cerulean/_variables.scss">
</head>
<body>
    
<?php 
//****** helpful feed warnings *******//
//print a summary of new feed action
//echo $myNewWarning;

//print a summary of new feed action
echo $myWarning;

//print a summary of cached feed action
//echo $myCachedWarning;
    
showForm($myFeedView['articleCounter']); // Show category menu
    
?> 

<h1>
    <?php 
    //echo heading
    //var_dump($myFeedView['feedState']);
    echo $myFeedView['feedState'] ;
    
    echo '<br>';
    
    echo $myFeedView['heading'] ;
    ?>
</h1>
    
    <?php //S E S S I O N  D E S T R O Y ////////
    if(isset($_POST['destroy']))//when button is clicked,
    {//destroy session
        echo '<span class="badge badge-pill badge-danger">Success!</span>';
        session_destroy();
        $_SESSION['counter'] = 0;
        
        //refresh to same page        
        echo("<meta http-equiv='refresh' content='1'>"); //Refresh by HTTP META

    }else{//show form
    echo'
    <form action="test.php" method="post">    
    <button class="btn btn-danger" name="destroy" type="submit" value="destroy">session_destroy()</button>
    </form>
    ';
    }
    // E N D  S E S S I O N  D E S T R O Y ////////
    
    //show feed
    echo $myFeedView['result']; 
    ?>


</body>
</html>
