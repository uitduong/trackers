$(function() {
    bindSearchOnPasteNav();
//    bindNotification();
});

function bindSearchOnPasteNav(){
    $('#nav-search-product').on('paste', function(){
        $('#search-product-btn').click();
    });
}

function bindConfirm(message){
    $(document).on('click', '.need-confirm', function(e){
        var f = confirm(message);
        if(!f){
            e.preventDefault();
        }
    });
}

function bindNotification(){
    if (!Notification) {
        console.log('Desktop notifications not available in your browser. Try Chromium.'); 
        return;
    }
    if (Notification.permission !== "granted"){
        Notification.requestPermission();
    } else {
//        notifyMe();
    }
}

function notifyMe() {
    // Let's check if the browser supports notifications
    if (!("Notification" in window)) {
        console.log("This browser does not support system notifications");
    }

    // Let's check whether notification permissions have already been granted
    else if (Notification.permission === "granted") {
        // If it's okay let's create a notification
        var notification = new Notification('Notification title', {
            icon: 'http://cdn.sstatic.net/stackexchange/img/logos/so/so-icon.png',
            body: "Hey there! You've been notified!",
        });
    }
    
    notification.onclick = function () {
        window.open("http://stackoverflow.com/a/13328397/1269037");      
    };
    
    // Otherwise, we need to ask the user for permission
//    else if (Notification.permission !== 'denied') {
//        Notification.requestPermission(function (permission) {
//            // If the user accepts, let's create a notification
//            if (permission === "granted") {
//                var notification = new Notification("Hi there!");
//            }
//        });
//    }
}