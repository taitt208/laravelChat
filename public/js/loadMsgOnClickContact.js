$(document).on("click", "li.contact", function () {
    $("li.contact").removeClass("active");
    $(this).addClass("active");
    if (this.hasAttribute("user_id")) {
        ajaxLoadMessages($(this).attr("user_id"), "user", 0, true);
    } else {
        ajaxLoadMessages($(this).attr("group_id"), "group", 0, true);
    }
    $(".message-input input").focus();
    $("div.contact-profile").find("img").remove();
    $("div.contact-profile").find("p").remove();
    var img = `<img src="${$(this).find("img").attr("src")}">`;
    var p = `<p>${$(this).find("p.name").text()}</p>`;
    $("div.contact-profile").prepend(img, p);
    scrollToBottom();
});

function ajaxLoadMessages(partner_id, type, currentMsgNumbers, isContactChanged) {
    laravelToken();
    $.ajax({
        beforeSend: function() {
            $('#ajax-loader').css("display", "block");
        },
        complete: function () {
            $("#ajax-loader").css("display", "none");
        },
        url: "/get_messages",
        method: "post",
        data: {
            partner_id: partner_id,
            type: type,
            offset: currentMsgNumbers
        },
        success: function (result) {
            if (result) {
                result = JSON.parse(result);
                showMessages(result, isContactChanged);
            } else {
                console.log(123);
            }
        }
    });
}

function showMessages(messages, isContactChanged) {
    var message_rows = "";
    $.each(messages.reverse(), function (i, obj) {
        if (obj.from == $("#current_user").attr("user_id")) {
            message_rows += `<li class="sent">
                                <img src="${$('div#current_user img:first').attr('src')}">
                                <p>${obj.content}</p>            
                            </li>`;
        } else {
            message_rows += `<li class="replies">
                                <img src="${(obj.image == undefined) ? $('li.contact.active img').attr('src') : obj.image}">
                                <p>${obj.content}</p>            
                            </li>`;
        }
    });
    if (isContactChanged) {
        $(".messages ul").empty();
    }
    $(".messages ul").prepend(message_rows);
}