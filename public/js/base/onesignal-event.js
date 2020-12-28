


function showHideContentOnSubscriptionChange() {
    OneSignal.on('subscriptionChange', showHideContent);
}

function oneSignalStuff() {
    OneSignal.push(function() {
        showHideContent();
        showHideContentOnSubscriptionChange();
    });
}

function showHideContent() {
    Promise.all([
        OneSignal.isPushNotificationsEnabled(),
        OneSignal.isOptedOut()
    ]).then(function(results) {
        var isEnabled = results[0];
        var isOptedOut = results[1];
        if (isEnabled) {
            var elements = document.querySelectorAll('.show-when-subscribed');
            elements.forEach(function(element) {
                element.classList.remove("hidden");
            });
            var elements = document.querySelectorAll('.show-when-unsubscribed');
            elements.forEach(function(element) {
                element.classList.add("hidden");
            });
            var elements = document.querySelectorAll('.show-when-subscribed-and-opted-out');
            elements.forEach(function(element) {
                element.classList.add("hidden");
            });
        } else {
            if (isOptedOut) {
                var elements = document.querySelectorAll('.show-when-subscribed-and-opted-out');
                elements.forEach(function(element) {
                    element.classList.remove("hidden");
                });
                var elements = document.querySelectorAll('.show-when-unsubscribed');
                elements.forEach(function(element) {
                    element.classList.add("hidden");
                });
                var elements = document.querySelectorAll('.show-when-subscribed');
                elements.forEach(function(element) {
                    element.classList.add("hidden");
                });
            } else {
                var elements = document.querySelectorAll('.show-when-unsubscribed');
                elements.forEach(function(element) {
                    element.classList.remove("hidden");
                });
                var elements = document.querySelectorAll('.show-when-subscribed');
                elements.forEach(function(element) {
                    element.classList.add("hidden");
                });
                var elements = document.querySelectorAll('.show-when-subscribed-and-opted-out');
                elements.forEach(function(element) {
                    element.classList.add("hidden");
                });
            }
        }
    });
}

function run() {
    oneSignalStuff();
}

if (document.readyState === "interactive" || document.readyState === "complete") {
    console.log(123);
    run();
} else {
    window.addEventListener('DOMContentLoaded', run);
}