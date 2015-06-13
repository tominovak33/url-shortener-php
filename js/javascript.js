function notify() {

    if (!Notification) {
        alert('Please get a browser that supports desktop notifications');
        return;
    }

    if (Notification.permission !== "granted")
        Notification.requestPermission();

    var notification = new Notification('Rest Notification', {
        icon: 'http://www.whiteoctober.co.uk/img/logo.png',
        body: "Rest!"
    });


    notification.onclick = function () {
        setTimeout(function(){ notify(); }, 120000 ); //2 min or 1200000 for 20 min
    }
}


Justice.init();