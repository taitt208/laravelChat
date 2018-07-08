$("div.messages").scroll(function () {
    if ($(this).scrollTop() < 1) {
        var currentMsgNumbers = $(this).find("ul").children().length;
        loadMoreMessages(currentMsgNumbers);
        var first_message = $("div.messages ul li:first");
        $("div.messages").scrollTop(first_message.position().top - 50);
    }
});

function loadMoreMessages (currentMsgNumbers) {
    if (currentMsgNumbers % 15 == 0) {
        var type;
        var partner_id;
        var chatting_li = $("li.contact.active");
        if (chatting_li[0].hasAttribute("user_id")) {
            type = "user";
            partner_id = chatting_li.attr("user_id");
        } else {
            type = "group";
            partner_id = chatting_li.attr("group_id");
        }
        ajaxLoadMessages(partner_id, type, currentMsgNumbers, false);
    }
}