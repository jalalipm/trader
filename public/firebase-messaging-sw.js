importScripts('js/base/firebase/firebase-app.js');
importScripts('js/base/firebase/firebase-messaging.js');

// Initialize Firebase
var config = {
    apiKey: "AIzaSyAU0QeY4Tu0vOguEAw1mRnhWOvHY71qxVY",
    authDomain: "foodorderapp-213311.firebaseapp.com",
    databaseURL: "https://foodorderapp-213311.firebaseio.com",
    projectId: "foodorderapp-213311",
    storageBucket: "foodorderapp-213311.appspot.com",
    messagingSenderId: "119876661208"
};

firebase.initializeApp(config);
const messaging = firebase.messaging();
