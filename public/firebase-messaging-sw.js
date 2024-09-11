// Give the service worker access to Firebase Messaging.
// Note that you can only use Firebase Messaging here. Other Firebase libraries
// are not available in the service worker.importScripts('https://www.gstatic.com/firebasejs/7.23.0/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js');
/*
Initialize the Firebase app in the service worker by passing in the messagingSenderId.
*/
firebase.initializeApp({
    apiKey: "AIzaSyDUKuF1WynErzM7skzA3CL06-xHtLyY7Qs",
  authDomain: "workout-3f2ed.firebaseapp.com",
  databaseURL: 'https://project-id.firebaseio.com',
  projectId: "workout-3f2ed",
  storageBucket: "workout-3f2ed.appspot.com",
  messagingSenderId: "1050077797091",
  appId: "1:1050077797091:web:8dbfbd22ddf7cc06a2c3d6",
  measurementId: "G-6RB18H8N4W"
});

// Retrieve an instance of Firebase Messaging so that it can handle background
// messages.
const messaging = firebase.messaging();
messaging.setBackgroundMessageHandler(function (payload) {
    console.log("Message received.", payload);
    const title = "Reminder notifications";
    const options = {
        body: "It is time to start your training",
        icon: "/firebase-logo.png",
    };
    return self.registration.showNotification(
        title,
        options,
    );
});
