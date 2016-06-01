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



