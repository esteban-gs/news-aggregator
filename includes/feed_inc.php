<?php
session_name( 'feeds' );
session_start();

//feed_inc.php
//fetch feed



function getFeed($aTopic)
{   
    //create datestamp in session var and fetch first feed
    $_SESSION['request'] = "https://news.google.com/rss/search?q=" . $aTopic;
    $_SESSION['rawFeed'] = file_get_contents($_SESSION['request']);   
    
    $_SESSION['timestamp'] = time(); // create timestamp
    $_SESSION['refreshTime'] = $_SESSION['timestamp'] + 60; //create refresh time
    //var_dump($_SESSION['request']);
}

function getFeedView()    
{
    $Xml = simplexml_load_string($_SESSION['rawFeed']);

    $myArray['heading'] = $Xml->channel->title;    
   
    $myArray['articleCounter'] = 0; // reset article counter
    
    foreach($Xml->channel->item as $story)
    {
        $myArray['result'] .="
            <div class=\"card border-info mb-3\" style=\" max-width: 20em;\">
          <div class=\"card-header\">$story->source</div>
          <div class=\"card-body\">
            <h4 class=\"card-title\"><a href=\"$story->link\" target=\"_blank\">$story->title</a><br /></h4>
            <p class=\"card-text\">$story->description</p>
          </div>
        </div><!--END Box Format-->

        ";  
        
        $myArray['articleCounter'] ++; //count article iterations
        
    }//end foreach  
    return $myArray; 
}




?>