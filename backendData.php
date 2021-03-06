<?php
ini_set('display_errors',1);
//connect to MongoClient 
$m = new MongoClient;

//select a database
$db = $m->selectDB('fbapp-DB');
$db2 = $m->selectDB('fb_nonuse_Nov_20');

//get pairwise interactions
$user_interactions = new MongoCollection($db,'fb-interactions');
$taggable = new MongoCollection($db2,'taggable_friends');
//get the user's name
$name1 = $_POST["A"];
$name2 = $_POST["B"]; 

//get the interactions of this user
$interactions = $user_interactions->findOne(array('source' => $name1,'target' => $name2 ));
if (empty($interactions)){
   $interactions = $user_interactions->findOne(array('source' => $name2,'target' => $name1 ));
}
$tagid = $taggable -> findOne(array('name'=>$name2));
$tag = $tagid["id"];
$result = $interactions;
$result["tag"] = $tag;
echo json_encode($result);



?>
