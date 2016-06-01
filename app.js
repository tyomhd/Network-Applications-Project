particlesJS.load('sisse', 'particles.json', function() {
    console.log('callback - particles.js config loaded');
});

window.onload =  function(){
    var menulogin = document.getElementById("menulogin");
    var mainlogin = document.getElementById("sissebutton");
    menulogin.onclick = function() {
        if (window.location.href == "http://enos.itcollege.ee/~alikhach/Vorgurakendused1/Project/project.php") {
            mainlogin.style.visibility = "hidden";
            document.getElementById("login").style.visibility = "visible";
        } else {
            window.location.href ="http://enos.itcollege.ee/~alikhach/Vorgurakendused1/Project/project.php";
            document.getElementById("menulogin").style.visibility = "hidden";
            document.getElementById("login").style.visibility = "visible";
        }
    }
    mainlogin.onclick = function(){
        mainlogin.style.visibility = "hidden";
        document.getElementById("login").style.visibility = "visible";
    }
}
// source: http://www.w3schools.com/php/php_ajax_livesearch.asp
function showResult(str) {
    if (str.length==0) {
        document.getElementById("livesearch").innerHTML="";
        document.getElementById("livesearch").style.border="0px";
        return;
    }
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    } else {  // code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function() {
        if (xmlhttp.readyState==4 && xmlhttp.status==200) {
            document.getElementById("livesearch").innerHTML=xmlhttp.responseText;
            document.getElementById("livesearch").style.border="1px solid #A5ACB2";
        }
    }
    xmlhttp.open("GET","livesearch.php?q="+str,true);
    xmlhttp.send();
}


