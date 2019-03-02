<?php
//read-feed-simpleXML.php
//our simplest example of consuming an RSS feed

//default button class values
$myScienceButtonClass = 'class="list-group-item list-group-item-action"';



$mySportsButtonClass = 'class="list-group-item list-group-item-action"';



$myPoliticsButtonClass = 'class="list-group-item list-group-item-action"';



//get rss feed after choosing category
if(isset($_POST['cat'])){
  $request = "https://news.google.com/rss/search?q=" . $_POST['cat'];
  $response = file_get_contents($request);
  $xml = simplexml_load_string($response);
  print '<h1>' . $xml->channel->title . '</h1>';
    
    /*
    //This could be sued to count the number of articles available in particular feed
    $scienceCount = count($xml->channel->item);
    echo $scienceCount;
    */
    
  foreach($xml->channel->item as $story)
  {
    $myResult .="
        <div class=\"card border-primary mb-3\" style=\"max-width: 20rem;\">
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
        <ul class="list-group">
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
