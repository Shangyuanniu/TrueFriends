<?php
ini_set('display_errors',1);
//connect to MongoClient 
$m = new MongoClient;

//select a database
$db = $m->selectDB('fbapp-DB');

//select a collection 
$collection = new MongoCollection($db,'fb-users');

//get pairwise interactions
//$user_interactions = new MongoCollection($db,'fb-interactions');

//get the user id from url
$userId = (isset($_GET['user'])? $_GET['user']:null);

//Plug user id to get user's json from the collection
$json = $collection->findOne(array('user id' => $userId));

//get the user's name
//$name = $json["name"];

//get the interactions of this user
//$interactions = $user_interactions->find(array('source' => $name));

//Put the interactions of th euser into a readable dictionary format
//$return = array();
//$i=0;
//while( $interactions->hasNext() )
  //  {
//       $x  = $interactions->getNext();
  //     $target = $x['target'];
    //   $data = [];
    //   if(array_key_exists('data',$x)){
    //    $data = $x['data']; 
    //    }
       
   //    $return[$target] = $data;
    //   $i++;
//  }
//$inter = $return;

?>

<!DOCTYPE html>
<html>
<meta charset="utf-8">
<head>
<link rel="stylesheet" type ="text/css" href="Woo10/css/animate.css">
<link rel="stylesheet" type ="text/css" href="Woo10/css/default.css">
<link rel="stylesheet" type ="text/css" href="Woo10/css/font-awesome/css/font-awesome.css">
<link rel="stylesheet" type ="text/css" href="Woo10/css/font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" type ="text/css" href="Woo10/css/fontello/css/animation.css">
<link rel="stylesheet" type ="text/css" href="Woo10/css/fontello/css/fontello-codes.css">
<link rel="stylesheet" type ="text/css"  href="Woo10/css/fontello/css/fontello-embedded.css"> 
<link rel="stylesheet" type ="text/css"  href="Woo10/css/fontello/css/fontello.css">
<link rel="stylesheet" type ="text/css" href="Woo10/css/fonts.css">
<link rel="stylesheet" type ="text/css"  href="Woo10/css/layout.css">
<link rel="stylesheet" type ="text/css"  href="Woo10/css/media-queries.css">
<link rel="stylesheet" type ="text/css" href="Woo10/css/prettyPhoto.css">
</head>

<style>
.popover{
max-width:320px;
padding-top:5px;
padding-left:5px;
padding-right:5px;
padding-bottom:5px;
position:relative;
border-radius:50px;
}

.popover-title { 
background-color:#FFFFFF;
font-size:16px;
color : #000000;
padding-left:10px;
padding-top : 10px;
padding-bottom : 10px;
font-weight:bold;
border-top-left-radius:20px;
border-top-right-radius:20px;
}
.popover-content{
overflow:auto; max-width=300px;max-height:300px;
background-color: #AE2B22 ;
font-size:17px;
padding-left : 10px;
padding-top:10px;
padding-right:10px;
padding-bottom : 10px;
border-bottom-left-radius:15px;
border-bottom-right-radius:15px;
color:#FFFFFF;
}
.popover.right{
margin-left:25px;
}

.popover.right:before {
        content: ' ';
	height: 0;
	position: absolute;
	width: 0;
        left:-32px;
        top:50%;
	margin-top:-18px;
        border: 20px solid transparent;
	border-right-color: #AE2B22;
}

.link {
stroke:#999;
       stroke-width: 0.5px;
       stroke-opacity: 0.5px;}

</style>

<body>
<script language="JavaScript" type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/d3/3.5.5/d3.min.js"></script> 
<script language="JavaScript" type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.6.2/modernizr.min.js"></script>
<script language="JavaScript" type="text/javascript" src="https:////cdnjs.cloudflare.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script language="JavaScript" type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script language="Javascript" type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/URI.js/1.15.2/URI.min.js"></script>
<div id="fb-root"></div>
<div id="hero" style="width:2500px;">
<h1 style="color:#FFFFFF; display:inline; float:left; margin:0 80px 20px 20px">This is what your <i>TRUE</i> friend network looks like</h1>
<button id = "return" style = "display:inline; float:left;">Return to Fun Facts</button>
<script>
window.fbAsyncInit = function() {
    FB.init({
      appId      : '1582658458614337', // App ID
      status     : true,    // check login status
      cookie     : true,    // enable cookies to allow the
                            // server to access the session
      xfbml      : true,     // parse page for xfbml or html5
                            // social plugins like login button below
      version		 : 'v2.7',  // Specify an API version
    });

    // Put additional init code here
};

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));


function getParamByName(name){
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
    results = regex.exec(window.location.search);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}
 document.getElementById("return").onclick = function(){
                window.top.location.href="https://eltanin.cis.cornell.edu/fbprojectb/initViz.php?resp="+getParamByName('resp')+"&user="+getParamByName('user');
                //window.top.location.href="https://apps.facebook.com/1582658458614337/initViz.php?resp="+getParamByName('resp')+"&user="+getParamByName('user');
};

var ac = getParamByName("resp");
var uid = getParamByName("user");

var sharefun = function(t){
FB.ui({
  method: 'share_open_graph',
  action_type: 'pages.saves',
  action_properties: JSON.stringify({
	  object:'https://eltanin.cis.cornell.edu/fbprojectb/',
	  tags:t,
	  access_token: ac
  })
}, function(response){});

};

</script>
</div>
<script>

var width = 2000,
    height = 2000;

var force = d3.layout.force()
    .charge(-5000)
    .size([width, height]);

var toggle = 0; //Stores whether the highlighting is on
var tog=0;  //Stores the state of the popup, 1 for visible, 0 for hidden
var htm =0;  //Stores whether user clicks anywhere on the div
var selection; //Stores the selected node at any point
var thisNode; 
var lastClickedCirc, lastClickedNode, lastClickedNeighborCirc,lastClickedNeighborNode;
var selectionBuffer = [];
var X=0, Y=0;
var DELAY = 500, clicks = 0, timer = null;
var linkedByIndex = {};  //Create an array logging what is connected to what
var json = <?php echo json_encode($json); ?>;  //echo user's json to this document
var nodes = json['json']['nodes'];  //List of nodes from the json
var links = json['json']['links']; //List of links from the json
var main = nodes[0];  // The current user's node
var dragging = 0;
var neighborSelection;
var neighborNode;
var togNeighbor =0;
var k = Math.sqrt(nodes.length/ (width * height));

force
    .theta(1.0)
    .charge(function(d){ if(nodes.length < 200 ){return -3*d.weight/k;} return -(5*d.weight/k);})
    .gravity(100 * k);
force.linkDistance(function(d){
      return 30*k/(d.value);
});

//NODE HIGHLIGHTING
for (i = 0; i < nodes.length; i++) {
    linkedByIndex[i + "," + i] = 1;
};

links.forEach(function (d) {
    linkedByIndex[d.source + "," + d.target] = 1;
});

//This function looks up whether a pair are neighbours
function neighboring(a, b) {
    return linkedByIndex[a.index + "," + b.index];
}

//NODE DRAGGING
var node_drag = force.drag()
        //.origin(function(d) { return d; })
        .on("dragstart", function(d,i){if (selection != d) {dstart.call(this,d,i)}  else {d.fixed=true;}})
        //.on("dragstart",drastart)
        .on("drag",function(d,i){if (selection != d) {dmove.call(this,d,i)}  else {d.fixed=true;}})
        .on("dragend",function(d,i){if (selection != d) {dend.call(this,d,i)}  else {d.fixed=true;}});

function dstart(d,i){d3.event.sourceEvent.stopPropagation(); dragging = 1; }

function dmove(d,i){
    // d.px += d3.event.dx;
    // d.py += d3.event.dy;
    // d.x += d3.event.dx;
    // d.y += d3.event.dy;
    d3.select(this)['dragged'] = 1;
    d3.select(this).style("fill","#FFCC66").attr("r",15);
}

function dend(d,i){
    d3.select(this).classed("fixed", d.fixed = true);
//    force.resume();
}

function releasenode(d) {
      // d.fixed = false; // of course set the node to fixed so the force doesn't include the node in its auto positioning stuff
     //   force.resume();
       d3.select(this).classed("fixed", d.fixed = false);
       d3.select(this)['dragged'] = 0;
       force.resume();
       d3.select(this).style("fill",function(d) {if (d.name === main['name']) { return "#339966" ; } else { return "#0099CC"; }}).style("r",function(d) { if (d.name === main['name']) { return 15; } else { return 9; } });
    }

//PAN 
var drag= d3.behavior.drag().on("drag",dragmove);
     function dragmove(d, i) {
       dragging = 1;
       X -= d3.event.dx;
    Y -= d3.event.dy;
    svg.select('g.node-area').attr('transform', 'translate(' + (-X) + ',' + (-Y) + ')');
   }
   

//Functions to fetch the message on clicking a node
function popMsg(A,name,interactions){
    console.log("ppmsg start");
    var content = "";
    console.log(A);
    console.log(name);
    console.log(interactions);
    if (interactions != [] && interactions != null){
    for (var i=0; i<interactions.length;i++){
          var interaction=interactions[i];
          if(i != 0){
            content = content.concat(i);
            content= content.concat(") ");
          }
          if (interaction[0] == "photo"){
            var onlyUrl = interaction[2];
            var myImg = '<img src="'+onlyUrl+'" />';
            if (interaction[1] == "large_likes_small_action"){
              content = content.concat(A+" liked "+name+"'s photo:<br/> "+myImg+"<br /> on "+interaction[3]);
              }
            if (interaction[1] == "small_likes_large_action"){
              content = content.concat(name+" liked the photo "+A+" posted to his wall<br/> "+myImg+"<br/> on "+interaction[3]);
              }
            if (interaction[1] == "large_likes_small_timeline"){
              content = content.concat(A+" liked the photo "+name+" posted to his wall<br/>"+myImg+"<br/> on "+interaction[3]);
              }
            if (interaction[1] == "small_likes_large_timeline"){
              content = content.concat(name+" liked "+A+"'s photo:<br/> "+myImg+"<br/> on "+interaction[3]);
              }

            if (interaction[1] == "large_comments_on_small_action"){
              content = content.concat(A+" commented on "+name+"'s photo:<br/> "+myImg+"<br/> on "+interaction[3]);
             }
            if (interaction[1] == "small_comments_on_large_action"){
              content = content.concat(name+" commented on the photo "+A+" posted to his wall<br/> "+myImg+"<br/> on "+interaction[3]);
             }
            if (interaction[1] == "large_comments_on_small_timeline"){
              content = content.concat(A+" commented on the photo "+name+" posted to his wall<br/>"+myImg+"<br/> on "+interaction[3]);
             }
            if (interaction[1] == "small_comments_on_large_timeline"){
              content = content.concat(name+" commented on "+A+"'s photo:<br/> "+myImg+"<br/> on "+interaction[3]);
              }

            if (interaction[1] == "large_tagged_in_small_action"){
              content = content.concat(A+" was tagged in this photo on "+name+"'s timeline:<br/> "+myImg+"<br/> on "+interaction[3]);
             }
            if (interaction[1] == "small_tagged_in_large_action"){
              content = content.concat(A+" tagged "+name+" in this photo:<br/> "+myImg+"<br/> on "+interaction[3]);
             }
            if (interaction[1] == "large_tagged_in_small_timeline"){
              content = content.concat(name+" tagged "+A+" in this photo:<br/> "+myImg+"<br/> on "+interaction[3]);
             }
            if (interaction[1] == "small_tagged_in_large_timeline"){
              content = content.concat(name+" was tagged in this photo on "+A+"'s timeline:<br/> "+myImg+"<br/> on "+interaction[3]);
              }

            if (interaction[1] == "CoLike"){
              content = content.concat(A+" and "+name+" liked the same photo<br/> "+myImg+"<br/> on "+interaction[3]);
            }
            if (interaction[1] == "CoCommented"){
              content = content.concat(A+" and "+name+" commented on the same photo<br/> "+myImg+"<br/> on "+interaction[3]);
            }
            if (interaction[1] == "CoTagged"){
              content = content.concat(A+" and "+name+" were tagged in the same photo<br/> "+myImg+"<br/> on "+interaction[3]);
            }
              content = content.concat("<br />"); 
           }
           
         if (interaction[0] == "post"){
           if (interaction[2] == "Bday"){
                 content = content.concat(name+" wished you on your Birthday");
           }
          else {
          if (interaction[1] == "large_likes_small_action"){
              content = content.concat(A+" liked "+name+"'s post on "+interaction[9]);
              }
            if (interaction[1] == "small_likes_large_action"){
              content = content.concat(name+" liked the post "+A+" published to his wall on "+interaction[9]);
              }
            if (interaction[1] == "large_likes_small_timeline"){
              content = content.concat(A+" liked the post "+name+" published to his wall on "+interaction[9]);
              }
            if (interaction[1] == "small_likes_large_timeline"){
              content = content.concat(name+" liked "+A+"'s post on "+interaction[9]);
              }

            if (interaction[1] == "large_comments_on_small_action"){
              content = content.concat(A+" commented on "+name+"'s post on "+interaction[9]);
             }
            if (interaction[1] == "small_comments_on_large_action"){
              content = content.concat(name+" commented on the post "+A+" published to his wall on "+interaction[9]);
             }
            if (interaction[1] == "large_comments_on_small_timeline"){
              content = content.concat(A+" commented on the post "+name+" published to his wall on "+interaction[9]);
             }
            if (interaction[1] == "small_comments_on_large_timeline"){
              content = content.concat(name+" commented on "+A+"'s post on "+interaction[9]);
              }

            if (interaction[1] == "large_tagged_in_small_action"){
              content = content.concat(A+" was tagged in this post on "+name+"'s timeline on "+interaction[9]);
             }
            if (interaction[1] == "small_tagged_in_large_action"){
              content = content.concat(A+" tagged "+name+" in this post on "+interaction[9]);
             }
            if (interaction[1] == "large_tagged_in_small_timeline"){
              content = content.concat(name+" tagged "+A+" in this post on "+interaction[9]);
             }
            if (interaction[1] == "small_tagged_in_large_timeline"){
              content = content.concat(name+" was tagged in this post on "+A+"'s timeline on "+interaction[9]);
              }

            if (interaction[1] == "CoLike"){
              content = content.concat(A+" and "+name+" liked the same post on "+interaction[9]);
            }
            if (interaction[1] == "CoCommented"){
              content = content.concat(A+" and "+name+" commented on the same post on "+interaction[9]);
            }
            if (interaction[1] == "CoTagged"){
              content = content.concat(A+" and "+name+" were tagged in the same post on "+interaction[9]);
            }
            if (interaction[1] == "large_posts_to_small"){
              content = content.concat(A+" posted this to "+name+"'s timeline on "+interaction[9]);
            }
            if (interaction[1] == "small_posts_to_large"){
              content = content.concat(name+" posted this to "+A+"'s timeline on "+interaction[9]);
            }
          s = getMyMsg(interaction);
          content = content.concat(s);
       }
       content = content.concat("<br />");
}
        
        if (interaction[0]=="event"){
          content = content.concat(A+" and "+name+" attended this event together on "+interaction[4]);
          s = getEvent(interaction,0);
          content = content.concat(s);
          content.concat("<br />");
        }
       
       if (interaction[0]=="book"){
          content = content.concat(A+" and "+name+" liked the following book: ");
          s = getEvent(interaction,1);
          content = content.concat(s);
          content.concat("<br />");
        }
   
        if (interaction[0]=="music"){
          content = content.concat(A+" and "+name+" liked the following music: ");
          s = getEvent(interaction,1);
          content = content.concat(s);
          content.concat("<br />");
        }

}       

         return content;
}


function getMyMsg(interaction){
   var connect='<div style="background:#191919 ; font-size:14px; padding-left : 10px; padding-top:10px; padding-right:10px; padding-bottom : 10px; border-bottom-left-radius:15px; border-bottom-right-radius:15px; border-top-left-radius:15px ; border-top-right-radius:15px">';
   if (interaction[7] != "") {
       connect = connect.concat('<img style="vertical-align:middle" src="'+interaction[7]+'" />');
}
   connect = connect.concat('<span>');
   if (interaction[3] != ""){
        connect = connect.concat('Story:'+interaction[3]);
} 
   if (interaction[4] != ""){
      connect = connect.concat('Message:'+interaction[4]);
}
   if (interaction[5] != ""){
       connect = connect.concat(interaction[5]);
}
   connect = connect.concat("</span></div>");
 
      return connect;
}
}

function getEvent(interaction,x){
  var connect='<div style="background:#191919 ; font-size:14px; padding-left : 10px; padding-top:10px; padding-right:10px; padding-bottom : 10px; border-bottom-left-radius:15px; border-bottom-right-radius:15px; border-top-left-radius:15px ; border-top-right-radius:15px">';
  if (x == 0){
  if (interaction[3] != "") {
       connect = connect.concat('<img style="vertical-align:middle" src="'+interaction[4]+'" />');
}
}
  if (x == 1){
  if (interaction[4] != "") {
       connect = connect.concat('<img style="vertical-align:middle" src="'+interaction[4]+'" />');
}
}
  connect = connect.concat('<span>');
    if (x==1 && interaction[3] != ""){
     connect.concat(interaction[3]);
}
   if (interaction[1] != ""){
        connect = connect.concat(interaction[1]);
} 
   if (interaction[2] != ""){
      connect = connect.concat(interaction[2]);
}
   connect = connect.concat("</span></div>");
 
      return connect;
}

//Function to display Popover
function selectNode(d){
  lastClickedCirc = $(this);
  lastClickedNode = d;
 if (toggle == 0) {
        //Change color of selected node 
        circle.style("fill", function(o){if(d.index == o.index){ return "#FF0000";} else {if (o.index == 0){return "#339966" ;} else {return "#0099CC";}}});
        //Reduce the opacity of all but the neighbouring nodes
        node.style("opacity", function (o) {
              if (neighboring(d, o) | neighboring(o, d)) {
                  selectionBuffer.push(o);
                  return 1;
              }
              else{
                return 0.07;
              }
        });
        //Reduce opacity of all but neighboring links
        link.style("opacity", function (o) {
          if (d.index==o.source.index | d.index==o.target.index){
               return 1;
          }
          else{
            return 0.2;
          }
        });
        //change stroke-width of all but neighboring links
        link.style("stroke-width", function (o) {
           return d.index==o.source.index | d.index==o.target.index ? 0.7 : 0.4;
        });
        //change stroke color of links
        link.style("stroke",function (o) {
           if(d.index==o.source.index | d.index==o.target.index) {
             if (d.index != 0){
             return "#FF9933" ;
        }
            else {return "#66FF99";}}

});
          
        //set toggle to 1 
        toggle = 1;
    } 
else {
        //Put them back to opacity=1
        node.style("opacity", 1);
        link.style("opacity", 1);
        circle.style("fill", function(o) {if (o.index == 0) { return "#339966" ; } else { 
           if (d.index == o.index){
              if ('dragged' in o){
                if (o.dragged == 1){
                  return "#FFCC66";
                }
                else{
                  return "#0099CC";
                }
              }
           }
            return "#0099CC"; }});
        circle.style("border", function (o) {
            if (neighboring(d, o) | neighboring(o, d)) {
               return "0px";
            }
        });
        link.style("stroke",function (o) {
            if (o.source.index == 0 | o.target.index==0){return "#66FF99";} else {return "#336699";}
       
});
        link.style("stroke-width", function (o) {
           if(d.index==o.source.index | d.index==o.target.index) {
            if (o.source.index == 0 | o.target.index==0){return 0.5;} else {return 0.4;}
        }});
        toggle = 0;
        selectionBuffer = [];
    }
  }

function nodePop(d){
console.log("Popping Node");
console.log(main['name']);
var interactions;
var circ = $(this);
console.log($('.popover'));
$.post('backendData.php', { A : main['name'],B:d.name },function(result){interactions = $.parseJSON(result);
   console.log("This seems right");    
   console.log(main['name']);
   console.log(interactions); 
   circ.popover({title:d.name+" & "+main['name'], content:
    function()
       {  
          console.log("running content fuction");
          if (d.name != main['name']){
          var content= popMsg.call(this,main['name'],d.name,interactions['data']);
           console.log(interactions['data']);
           console.log(content);
           if (content === undefined){
              console.log("content undefined");
              content = "You have no interactions with this person";
           }
           if (content == ""){
             content = content.concat("You have no interactions with this person"); 
           }
	   content = content.concat("<br/><button id = 'share' onclick = \"sharefun('"+interactions["tag"]+"')\">Share to Facebook</button>");
          }
	  console.log(content);
          return content;
          //return '<div class="fb-video" data-href=https://www.facebook.com/10205816450603289/videos/10205695820187604 data-width="50"></div>'      
}
,html:true,container:'body',trigger:"manual", template:'<div class="popover" role="tooltip"><div class="popover-title"></div><div class="popover-content"></div></div>'});
console.log("Popped");
circ.popover('show');
console.log("Done");
selection = d;
thisNode = circ;
tog =1 ;
});

}


function popNeighbor(d){
console.log("boom");
lastClickedNeighborCirc = $(this);
lastClickedNeighborNode = d;
if (togNeighbor == 0){
var interactions;
var circ = $(this);
console.log(d);
$.post('backendData.php', { A :lastClickedNode.name,B:d.name },function(result){ interactions = $.parseJSON(result); 
circ.popover({title:d.name+" & "+lastClickedNode.name, content:
    function()
       {
          if (d.name != main['name']){
          var content;
            content = popMsg.call(this,interactions['source'],interactions['target'],interactions['data']);
           if (content == ""){
             content = content.concat("There was a problem finding interactions between these two people"); 
           }
	console.log("checking content");
	 console.log(content);
	  content.concat("<iframe src='https://www.facebook.com/plugins/share_button.php?href=https%3A%2F%2Feltanin.cis.cornell.edu%2Ffbprojectb&layout=button&size=small&mobile_iframe=true&width=59&height=20&appId' width='59' height='20' style='border:none;overflow:hidden' scrolling='no' frameborder='0' allowTransparency='true'></iframe>");
          }
	  console.log(content);
          return content;
          //return '<div class="fb-video" data-href=https://www.facebook.com/10205816450603289/videos/10205695820187604 data-width="50"></div>'      
},html:true,container:'body',trigger:"manual", template:'<div class="popover" role="tooltip"><div class="popover-title"></div><button id = "share" onclick = "sharefun()">Share to Facebook</button><div class="popover-content"></div></div>'});
circ.popover('toggle');
neighborSelection = circ;
neighborNode = d;
togNeighbor =1 ;
});
}
else {
console.log("Yo");
$(this).popover('toggle');  
  $('.popover').each(function() {
     $(this).remove();
    });
$(this).popover('destroy');
  togNeighbor = 0;
}
}



function closePop(d){
$(this).popover('toggle');  
  $('.popover').each(function() {
     $(this).remove();
    });
$(this).popover('destroy');
  tog = 0;
}

var zoom= d3.behavior.zoom()
           .on("zoom",redraw);
         

function redraw(){
svg.attr("transform","translate("+d3.event.translate+")"+" scale("+d3.event.scale+")");
}

//Build graph object
var svg = d3.select("body").append("svg").attr("width",width).attr("height",height).append('svg:g').classed('node-area', true).call(zoom).on("dblclick.zoom",null).append('svg:g');
svg.append("svg:rect")
   .attr("width",width)
   .attr("height",height)
   .attr("fill","#181d21").attr('x',0).attr('y',0).call(drag);

force.nodes(nodes)
     .links(links);

var link =svg.selectAll(".link")
.data(links)
	.enter().append("line")
	.attr("class","link")
	.style("stroke", function(d) { if (d.source === 0){return "#66FF99";} else {return "#336699";}})
	.style("stroke-opacity", function(d){if (d.source != 0 ){ return "0.4px";} else {return "0.5px";}})
	.style("stroke-width", function(d) {if (d.source===0){return "0.5px";} else { return "0.4px";}});

var node = svg.selectAll(".node")
        .data(nodes)
	.enter().append("svg:g");

var circle =node.append("circle")           
	.attr("class","node")
	.attr("r",function(d) { if (d.name === main['name']) { return 15; } else { return 9; } })
	.style("fill", function(d) {if (d.name === main['name']) { return "#339966" ; } else { return "#0099CC"; }})
        .call(force.drag)
       .on('click', function (d) {
        if (d.name != main['name']){
      circ = this;
      clicks++;  //count clicks

        if(clicks === 1) {

            timer = setTimeout(function() {
                selectNode.call(circ,d); //just select the node on a single click  
                console.log(d);
                console.log(circ);
                nodePop.call(circ,d);
                console.log("Step1");
                clicks++ ; 
            }, DELAY);

        } 
        else if (clicks == 3){
            timer = setTimeout(function() {
               if (toggle == 1 && lastClickedNode == d && tog==0){
                 
                if (togNeighbor == 1 && lastClickedNeighborNode != undefined){
                    popNeighbor.call(lastClickedNeighborCirc,lastClickedNeighborNode);
}
                console.log("Step2");
                nodePop.call(circ,d); //just select the node on a single click 
                clicks = 2; 
                }
                else{
                   console.log(tog);
                   if (tog == 1){
                   console.log("Step3");
                   closePop.call(lastClickedCirc,lastClickedNode);
                   } 
                  
                   if (selectionBuffer.indexOf(d) == -1){
                   selectNode.call(lastClickedCirc,lastClickedNode);
                   selectNode.call(circ,d);
                   }
                   else {
                    if (lastClickedNeighborNode != undefined && togNeighbor == 1){
                     console.log("Step4");
                    popNeighbor.call(lastClickedNeighborCirc,lastClickedNeighborNode);
                     }
                    console.log("Step5");
                    popNeighbor.call(circ,d); 
                      
                   }
                   
                   clicks = 2;
                }
            }, DELAY);

        } 
        else {
            clearTimeout(timer);    //prevent single-click action
            releasenode.call(circ,d);  //perform double-click action
            clicks = 0;             //after action performed, reset counter
        }

    } 
          else {
               if (toggle == 1){
                if (tog == 1){
                 nodePop.call(lastClickedCirc,lastClickedNode); 
              }
                selectNode.call(lastClickedCirc,lastClickedNode);
                clicks = 0;
            }
          }}).on("zoom",null);

$('html').on('click', function(e){
htm = 0;
if (dragging != 1){
var s = $(e.target).attr('class');
if (s != "node fixed"){
if (tog==1){
closePop.call(thisNode,selection);
console.log("Rem1");
htm = 1;
}
if (togNeighbor == 1){
  popNeighbor.call(neighborSelection,neighborNode);
console.log("Rem2");
htm = 1;
}
if (htm == 0 && tog == 0 && toggle == 1){
   selectNode.call(lastClickedCirc,lastClickedNode);
   console.log("Rem3");
   clicks = 0 ;
} 
}
} dragging = 0;   })

var label = node.append("svg:text")
	.attr("class", "nodetext")
	.attr("dx", 12)
	.attr("dy", ".35em")
        .text(function(d) { return d.name })
	.style("fill", function(d){
			if (d.name === main['name']) { return "#FF9933" ; } else { return "#CCCCFF"; }
			})
.style("font-size", function(d){
		if (d.name === main['name']) { return "30px" ; } 
		})
;


force.on("tick", function(){
		link.attr("x1", function(d) { return d.source.x;})
		.attr("y1", function(d) {return d.source.y;})
		.attr("x2", function(d) {return d.target.x; }) 
		.attr("y2", function(d) { return d.target.y;});
		// node.attr("cx", function(d) {return d.x;})
		//  .attr("cy", function(d) {return d.y;}) ;
		//circle.attr("transform", function(d) { return "translate(" + d.x + "," + d.y + ")"; });
		// label.attr("transform", function(d) { return "translate(" + d.x + "," + d.y + ")"; });
		//node.attr("transform", function(d) { return "translate(" + d.x + "," + d.y + ")"; });
                //node.attr("cx", function(d) { return d.x = Math.max(15, Math.min(width - 15, d.x)); })
                  //   .attr("cy", function(d) { return d.y = Math.max(15, Math.min(height - 15, d.y)); });
    node.attr("transform", function(d) { return "translate(" + d.x + "," + d.y + ")"; });
});
force.start();
if (json["doneViz"] == 0){
   document.write("First Post on timeline:");
   document.write(json["tempJson"]["first"][0]);
   document.write("on");
   document.write(json["tempJson"]["first"][1]);
   document.write("Last post on timeline:");
    document.write(json["tempJson"]["last"][0]);
   document.write("on");
   document.write(json["tempJson"]["last"][1]);
   document.write("No. of events you have attended so far : ");
   document.write(json["tempJson"]["events"]);
   document.write("We will be back with your visualization soon");
}
   

</script>
<body>

