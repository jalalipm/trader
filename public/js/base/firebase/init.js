// Initialize Firebase
const firebaseConfig = {
    apiKey: "AIzaSyAasDBIAxPMaIkQEWCUr97TarIZFCay9ok",
    authDomain: "separesh-trader.firebaseapp.com",
    databaseURL: "https://separesh-trader.firebaseio.com",
    projectId: "separesh-trader",
    storageBucket: "separesh-trader.appspot.com",
    messagingSenderId: "881827006549",
    appId: "1:881827006549:web:fd7cd6eab047ae857a6cdc",
    measurementId: "G-Y71DRFMRWY"
};

var defaultApp = firebase.initializeApp(firebaseConfig);
const messaging = firebase.messaging();
// var mToken = $('meta[name="csrf-token"]').attr('content');
messaging.requestPermission()
    .then(function() {
        console.log("have Permision");
        return messaging.getToken();
    })
    .then(function(token) {
        $(document).ready(function() {
            $(function() {
                var user_id = $('#user-info').val();
                var url = $('#user-info').attr('data-push-route');
                $.ajax({
                    url: url,
                    method: 'POST',
                    data: {
                        _token: mToken,
                        id: user_id,
                        push_id: token
                    },
                    success: function(data) {}
                });
            });
        });
    })
    .catch(function(err) {
        console.log(err);
    });


messaging.onMessage(function(payload) {
    console.log('onMessage :', payload);
    console.log('onMessage :', payload['notification']);
    console.log('onMessage :', payload['data']['json_data']);
    // alert(payload.notification.title);
    var url = window.location.href;
    // alert(1);
    if (payload['data']['type'] == 'support_message') {
        var json_data = JSON.parse(payload['data']['json_data']);
        var json_url = (json_data['url']).replace('\\', '');
        if (url === json_url) {
            var now = new Date(Date.now());
            var comment_time = now.getHours() + ":" + now.getMinutes();
            $('#message_body').append('<div class="chat-avatar ml-1 float-l">' +
                '<img class="rounded-circle" style="width: 40px;height: 40px;"' +
                'src="' + json_data['user_avatar'] + '"' +
                'alt="avatar">' +
                '</div>' +
                '<div class="message-div-user">' +
                '<p class="message-body">' + payload['notification']['body'] + '</p>' +
                '<span class="message-time-user">' + comment_time + '</span></div> <br style="clear: both;">');
            $('#comment').val('');
            $("#comment").focus();
            scroll_move_to_end();
        } else {
            var url = window.location.origin + '/admin/unread_messages';
            $.ajax({
                url: url,
                method: 'GET',
                success: function(response) {
                    $('#badge-tot').text(response.data.length);
                },
                error: function(xhr) {
                    console.log(xhr);
                }
            });
            iziToast.success({
                timeout: false,
                title: payload['notification']['title'],
                message: payload['notification']['body'],
                position: 'bottomRight',
                buttons: [
                    ['<button>صفحه گفتگو</button>', function(instance, toast) {
                        instance.hide({
                            transitionOut: 'fadeOutUp',
                            onClosing: function(instance, toast, closedBy) {
                                console.info('closedBy: ' + closedBy); // The return will be: 'closedBy: buttonName'
                            }
                        }, toast, 'buttonName');
                        window.location.href = (json_data['url']).replace('\\', '');
                    }, true],
                ],
            });
        }
    } else {
        // alert(0);
        // alert(payload['notification']['title']);
        iziToast.success({
            timeout: false,
            title: payload.notification.title,
            message: payload.notification.body,
            position: 'bottomRight',
        });
    }
});