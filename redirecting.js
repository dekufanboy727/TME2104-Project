anime ({
    targets: 'div.box',
    translateY: 
    [
        {value: 200, duration: 400},
        {value:0, duration: 1000}  
    ],
    rotate: 
    {
        value: '2turn',
    },
    borderRadius: 90,
    direction: 'alternate',
    easing: 'easeInOutQuad',
    delay: function() 
    { 
        return anime.random(0, 1000); 
    },
    loop: true,
    elasticity: 200 
}); 
playPause.play();

function redirecting() {
    window.location.href = "myProfile.php";
}
   
function redirecting_logout() {
    window.location.href = "index.php";
}
   