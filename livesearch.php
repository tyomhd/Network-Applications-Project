<?php
// Source: http://www.w3schools.com/php/php_ajax_livesearch.asp
error_reporting(E_PARSE);
$xmlDoc=new DOMDocument();
$xmlDoc->load("links.xml");

$x=$xmlDoc->getElementsByTagName('record');

//get the q parameter from URL
$q=$_GET["q"];

//lookup all links from the xml file if length of q>0
if (strlen($q)>0) {
    $hint="";
    for($i=0; $i<($x->length); $i++) {
        $z=$x->item($i)->getElementsByTagName('ID');
        $y=$x->item($i)->getElementsByTagName('Name-eng');
        if ($y->item(0)->nodeType==1) {
            //find a link matching the search text
            if (stristr($y->item(0)->childNodes->item(0)->nodeValue,$q)) {
                if ($hint=="") {
                    $hint="<a href='http://enos.itcollege.ee/~alikhach/Vorgurakendused1/Project/addrow.php?id=" .
                        $z->item(0)->childNodes->item(0)->nodeValue .
                        "'>" .
                        $y->item(0)->childNodes->item(0)->nodeValue . "</a>";
                } else {
                    $hint=$hint . "<br /><a href='http://enos.itcollege.ee/~alikhach/Vorgurakendused1/Project/addrow.php?id=" .
                        $z->item(0)->childNodes->item(0)->nodeValue .
                        "'>" .
                        $y->item(0)->childNodes->item(0)->nodeValue . "</a>";
                }
            }
        }
    }
}

// Set output to "no suggestion" if no hint was found
// or to the correct values
if ($hint=="") {
    $response="no suggestion";
} else {
    $response=$hint;
}

//output the response
echo $response;
?>