particlesJS.load('sisse', 'particles.json', function() {
    console.log('callback - particles.js config loaded');
});

window.onload =  function(){
    var menulogin = document.getElementById("menulogin");
    var mainlogin = document.getElementById("sissebutton");
    menulogin.onclick = function(){
        mainlogin.style.visibility = "hidden";
        document.getElementById("login").style.visibility = "visible";
    }
    mainlogin.onclick = function(){
        mainlogin.style.visibility = "hidden";
        document.getElementById("login").style.visibility = "visible";
    }
}
