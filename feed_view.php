<?php 
session_name( 'feeds' );
session_start();
include 'includes/feed_inc.php';
# '../' works for a sub-folder.  use './' for the root  
require '../inc_0700/config_inc.php'; #provides configuration, pathing, error handling, db credentials
get_header(); #defaults to header_inc.php
/*
session_destroy();
echo '<span class="badge badge-pill badge-danger">Success!</span>';
die();
*/

//process querystring here
if(isset($_GET['id']))
{//process data
    //cast the data to an integer, for security purposes
    $id =  htmlentities($_GET['id']);
    var_dump($id);
}else{//redirect to safe page
    header('Location:feeds_list.php');
}


echo 'is timestamp set? ';
echo isset($_SESSION['timestamp']);
echo '<br>';

if(!isset($_SESSION['timestamp'])){
    //************New session**************/
    
    echo 'Welcome. This is a NEW session<br>';
    
    //get feed and save in session var
    getFeed($id);    
    echo 'is timestamp set? ';
echo isset($_SESSION['timestamp']);
echo '<br>';

    //get htmlView from feed
    $myFeedView = getFeedView();
    
    $myFeedView['feedState'] = 'fresh';
    
    echo '<pre>';
    //var_dump($myFeed);
    echo '</pre>';
    
    //print a summary of new feed action
    $myWarning = '
    <div class="alert alert-dismissible alert-danger">
      <button onclick="this.parentElement.style.display = \'none\';" type="button" class="close" data-dismiss="alert">&times;</button>
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
          <button onclick="this.parentElement.style.display = \'none\';" type="button" class="close" data-dismiss="alert">&times;</button>
          <strong>Time to refresh!!!!!</strong>
        </div> 
        ';
        //force this value to unset
        unset($_SESSION['timestamp']);
        //header("Refresh:0"); // refresh page
        echo '<script>window.location.reload()</script>';
        
    }
   
    //*************echo cached session*****************//
    echo 'This is a cached session<br>';
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
      <button onclick="this.parentElement.style.display = \'none\';" type="button" class="close" data-dismiss="alert">&times;</button>
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


    
//******  ******//

    
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
        //refresh to same page        
        echo '<script>window.location.reload()</script>';
       // unset($_SESSION['timestamp']);

    }else{//show form
    echo'
    <form action="feed_view.php?id=science" method="post">    
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
<?php
get_footer(); #defaults to footer_inc.php
?>