//* Country Code/
var input = document.querySelector("#phone");
// window.intlTelInput(input, {
//     preferredCountries: ['in'],
//     // utilsScript: baseUrl + "/public/assets/js/utils.js",
// });

// Firebase
var config = {
    apiKey: "AIzaSyAg2dGE9d1YmeF7fuN_ozysIRA9V3z3xQo",
    authDomain: "boat-basin-lightening-9fd20.firebaseapp.com",
    projectId: "boat-basin-lightening-9fd20",
    storageBucket: "boat-basin-lightening-9fd20.appspot.com",
    messagingSenderId: "97104820937",
    appId: "1:97104820937:web:6d460e11857fcab439eb18"
};
firebase.initializeApp(config);

window.onload = function () {
    // render();
};

// function render() {
//     window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier('recaptcha-container');
//     recaptchaVerifier.render();
// }

function sendOTP() {
    var number = $("#phone").val();

    if(number == null || number == ''){
        $("#phone").focus();
        not('Phone number is required.', 'error');
    }
    else{
        console.log('number *-* ', number);


        firebase.auth().signInWithPhoneNumber(number, window.recaptchaVerifier).then(function (confirmationResult) {
            window.confirmationResult = confirmationResult;
            coderesult = confirmationResult;

            console.log('coderesult *-* ', coderesult);

            $('#phone-div').hide();
            $('#phone-verify-div').show();
            not('Message sent', 'success');
        }).catch(function (error) {
            console.log('error *-* ', error.message);
            not(error.message, 'error');
        });
    }
}

function verify() {
    var code1 = $("#digit1").val();
    var code2 = $("#digit2").val();
    var code3 = $("#digit3").val();
    var code4 = $("#digit4").val();
    var code5 = $("#digit5").val();
    var code6 = $("#digit6").val();

    var code = code1+code2+code3+code4+code5+code6;

    coderesult.confirm(code).then(function (result) {
        var user = result.user;
        document.getElementById('social-login-form').action = baseUrl + '/login/phone/callback';
        document.getElementById('social-login-tokenId').value = user.uid;
        document.getElementById('social-login-form').submit();
        // not('Auth is successful', 'success');
    }).catch(function (error) {
        not(error.message, 'error');
    });
}




// var facebookProvider = new firebase.auth.FacebookAuthProvider();
// var googleProvider = new firebase.auth.GoogleAuthProvider();
// var twitterProvider = new firebase.auth.TwitterAuthProvider();

// var facebookCallbackLink = baseUrl + '/login/facebook/callback';
// var googleCallbackLink = baseUrl + '/login/google/callback';
// var twitterCallbackLink = baseUrl + '/login/twitter/callback';



// async function socialSignin(provider) {
//     var socialProvider = null;
//     if (provider == "facebook") {
//         socialProvider = facebookProvider;
//         document.getElementById('social-login-form').action = facebookCallbackLink;
//     } else if (provider == "google") {
//         socialProvider = googleProvider;
//         document.getElementById('social-login-form').action = googleCallbackLink;
//     } else if (provider == "twitter") {
//         socialProvider = twitterProvider;
//         document.getElementById('social-login-form').action = twitterCallbackLink;
//     } else {
//         return;
//     }

//     firebase.auth()
//         .signInWithPopup(socialProvider)
//         .then((result) => {
//             /** @type {firebase.auth.OAuthCredential} */
//             var credential = result.credential;
//             var token = credential.accessToken;
//             var user = result.user;

//             document.getElementById('social-login-tokenId').value = user.providerData[0].uid;
//             document.getElementById('social-login-form').submit();
//         }).catch((error) => {
//             console.log(error);
//         });
// }
// End Firebase


// $(".social-login").click(function (event) {
//     event.preventDefault();
//     var socialTitle = $(this).attr('socialTitle');
//     socialSignin(socialTitle);
// });

/** Get token */
// firebase.initializeApp(config);
const messaging = firebase.messaging();
function initFirebaseMessagingRegistration() {
    
    messaging
        .requestPermission()
        .then(function () {
            return messaging.getToken()
        })
        .then(function (token) {
            $('#device_token').val(token);
        }).catch(function (err) {
            console.log('User Chat Token Error *** ' + err);
        });
}
messaging.onMessage(function (payload) {
    const noteTitle = payload.notification.title;
    const noteOptions = {
        body: payload.notification.body,
        icon: payload.notification.icon,
    };
    new Notification(noteTitle, noteOptions);
});
initFirebaseMessagingRegistration();