const firebaseConfig = {
  apiKey: "AIzaSyA4DccCSjzGYKzgjaujjwre3pArmOOQQyU",
  // authDomain: "realtime-chat-57589.firebaseapp.com",
  projectId: "monster-breaks",
  // storageBucket: "realtime-chat-57589.appspot.com",
  messagingSenderId: "503353431463",
  databaseURL: "https://monster-breaks.firebaseio.com",
  storageBucket: "monster-breaks.appspot.com",
};
firebase.initializeApp(firebaseConfig);
const db = firebase.database();

//   fetchChat.on("child_added", function (snapshot) {
//     const messages = snapshot.val();
//     const msg = "<li>" + messages.usr + " : " + messages.msg + "</li>";
//     document.getElementById("messages").innerHTML += msg;
//   });