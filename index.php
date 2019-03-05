<?php
//read-feed-simpleXML.php
//our simplest example of consuming an RSS feed
session_start();

//default button class values
$myScienceButtonClass = 'class="list-group-item list-group-item-action"';



$mySportsButtonClass = 'class="list-group-item list-group-item-action"';



$myPoliticsButtonClass = 'class="list-group-item list-group-item-action"';



//session_destroy();
//die;
//save feed in session

if(isset($_SESSION['cachedTime']))
{//if cachedTime is set, compare
    $mins = ((time() - $_SESSION["cachedTime"]) / 60);
    echo'<b style="color:green;">cashedTime</b> is set and it hase been ' . $mins . ' minutes since the last cache was refreshed<br>';
}

if(session_id() == '')
{
    $_SESSION['cachedTime'] = time();
    $request = "https://news.google.com/rss/search?q=science";
    $response = file_get_contents($request);
    $_SESSION["scienceXML"] = simplexml_load_string($response);
    echo'<p style ="color:red;">this is a brand new session and it was set at ' . date("h:i:sa", $_SESSION["cachedTime"]) . '</P>';
}



//get rss feed after choosing category
if($mins > 1)
{//If more than 10 minutes have passed fetch fresh feed
    echo '<h1>This is a <em>FRESH</em> feed</h1>';
    echo '<h1>' . $_SESSION["scienceXML"]->channel->title . '</h1>';
    foreach($_SESSION["scienceXML"]->channel->item as $story)
    {
        $myResult .="
            <div class=\"card border-light mb-3\" style=\" max-width: 20em;\">
          <div class=\"card-header\">$story->source</div>
          <div class=\"card-body\">
            <h4 class=\"card-title\"><a href=\"$story->link\" target=\"_blank\">$story->title</a><br /></h4>
            <p class=\"card-text\">$story->description</p>
          </div>
        </div><!--END Box Format-->


        ";  
        /*"

    <a href=\"$story->link\">$story->title</a><br />
    <p>$story->description</p><br /><br />";*/
    }// end foreach    
   
} // End if
elseif($mins < 1)
{//echo feed from cache   
    echo $mins;
    echo '<h1>This is a cached feed</h1><br>';
    print '<h1>' . $_SESSION["scienceXML"]->channel->title . '</h1>';
    foreach($_SESSION["scienceXML"]->channel->item as $story)
    {
        $myResult .="
            <div class=\"card border-light mb-3\" style=\" max-width: 20em;\">
          <div class=\"card-header\">$story->source</div>
          <div class=\"card-body\">
            <h4 class=\"card-title\"><a href=\"$story->link\" target=\"_blank\">$story->title</a><br /></h4>
            <p class=\"card-text\">$story->description</p>
          </div>
        </div><!--END Box Format-->


        ";  
        /*"

    <a href=\"$story->link\">$story->title</a><br />
    <p>$story->description</p><br /><br />";*/
    }// end foreach    
    
    
}//END else
else{
    echo 'There is an error with the $min value';
}


//switch handles the class passed for active buttons
switch ($_POST['cat']){
    case 'science':
        $myScienceButtonClass = 'class="list-group-item list-group-item-action active"';
        break;    
        
    case 'sports':
        $mySportsButtonClass = 'class="list-group-item list-group-item-action active"';
        break; 
        
    case 'politics':
        $myPoliticsButtonClass = 'class="list-group-item list-group-item-action active"';
        break;
        
}
    
    

?>


<!DOCTYPE html>
<html>
    
<head>
  <title>News Aggregator</title>
  <meta charset="UTF-8">
    
<link rel="stylesheet" href="https://bootswatch.com/4/cerulean/bootstrap.min.css">
    
</head>
<body>

<h1>My First Heading</h1>

    <form action="index.php" method="post">
        <ul class="list-group" style="max-width: 20%;">
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <button <? echo $myScienceButtonClass?> name="cat" type="submit" value="science">Science</button>
                    <span class="badge badge-primary badge-pill">14</span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <button <? echo $mySportsButtonClass?>  name="cat" type="submit" value="sports">Sports</button>
                    <span class="badge badge-primary badge-pill">14</span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">                
                <button <? echo $myPoliticsButtonClass?> name="cat" type="submit" value="politics">Polictics</button>        
                <span class="badge badge-primary badge-pill">14</span>
            </li>
        </ul>
    </form>

    
    <?php echo $myResult?>



</body>
</html>
