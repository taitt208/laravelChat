function laravelToken() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
}

function scrollToBottom() {
    $('div.messages').animate({ scrollTop: $('.messages')[0].scrollHeight}, 1000);
}

(function(){
    var conn = new WebSocket(`ws://localhost:8090?user_id=${$("#current_user").attr("user_id")}`);

    conn.onopen = function (e) {
    };

    conn.onmessage = function(e) {
        var msg = JSON.parse(e.data);
        updateMessages(msg, "receiver");
    };

    function updateLastMessageSender(msg) {
        if (msg.type == "user") {
            $(`li.contact[user_id='${msg.receiver_id}'] p.preview`).text("Bạn: " + msg.text);
        } else {
            $(`li.contact[group_id='${msg.receiver_id}'] p.preview`).text("Bạn: " + msg.text);
        }
    }

    function updateLastMessageReceiver(msg) {
        if (msg.type == "user") {
            $(`li.contact[user_id='${msg.sender_id}'] p.preview`).text(msg.text);
        } else {
            var sender_name = $(`li.contact[user_id='${msg.sender_id}'] p.name`).text();
            $(`li.contact[group_id='${msg.receiver_id}'] p.preview`).text(sender_name + ": " + msg.text);
        }
    }

    function updateMessages(msg, user_type){
        var messages_html = `<li class="${(user_type == "sender") ? "sent" : "replies"}">
                    <img src="${msg.image}" alt="" />
                    <p>${msg.text}</p>
                </li>`;
        if (user_type == "sender") {
            $("div.messages ul").append(messages_html);
            updateLastMessageSender(msg);
        } else {
            // Ở phía người nhận nếu đang chat với người gửi thì thêm tin nhắn vào khung chát, ko thì thôi
            if ($("#contacts ul li.active").attr("user_id") == msg.sender_id || $("#contacts ul li.active").attr("group_id") == msg.receiver_id) {
                $("div.messages ul").append(messages_html);
            }
            updateLastMessageReceiver(msg);
        }
        scrollToBottom();
    }

    function isGroupMessage() {
        return $("li.contact.active")[0].hasAttribute("group_id");
    }

    function newMessage() {
        var type = "user";
        var receiver_id;
        if (isGroupMessage()) {
            type = "group";
            $("div#contacts li").each(function (i, obj) {
                if ($(obj).hasClass("active")) {
                    receiver_id = $(obj).attr("group_id");
                }
            });
        } else {
            $("#contacts li").each(function (i, obj) {
                if ($(obj).hasClass("active")) {
                    receiver_id = $(obj).attr("user_id");
                }
            });
        }
        var text = $('.message-input input').val();
        var msg = {
            'text': text,
            'sender_id': $("#current_user").attr("user_id"),
            'receiver_id': receiver_id,
            'image': $("#current_user img").attr("src"),
            'time': moment().format('hh:mm a'),
            'type': type
        };
        updateMessages(msg, "sender");
        conn.send(JSON.stringify(msg));
        $('.message-input input').val(null);
    };

    $(document).on('click', '.submit', function() {
        newMessage();
    });

    $(document).on('keydown', '.message-input input', function(e) {
        if (e.which == 13) {
            newMessage();
            return false;
        }
    });

    $("#logout").click(function () {
        event.preventDefault();
        document.getElementById('logout-form').submit();
        conn.close();
    });
})();