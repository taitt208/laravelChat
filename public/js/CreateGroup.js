$("button#create_group").click(function (e) {
    e.preventDefault();
    if (!validateInput()) {
        return;
    }
    callAjax();
});

function validateInput() {
    if ($("#enter_group_name").val().replace(/\s/g, '') == '' || $("#enter_group_image").val() == '') {
        alert("Bạn hãy nhập đủ thông tin!");
        return false;
    }

    if ($("#myModal").find("input[type='checkbox']:checked").length == 0) {
        alert("Bạn chưa chọn người để tạo nhóm!");
        return false;
    }
    return true;
}

function callAjax() {
    var users = [];
    $("#myModal").find("input[type='checkbox']:checked").each(function (i, obj) {
        users.push($(obj).val());
    });
    laravelToken();

    var group_name = $("#enter_group_name").val().replace(/\s/g, '');
    var group_image = $("#enter_group_image").val();
    $.ajax({
        url: '/create_group',
        method: "post",
        data: {
            group_name: group_name,
            group_image: group_image,
            users: users
        },
        success: function (result) {
            if (result == "exist") {
                alert("Tên nhóm đã tồn tại");
                return;
            }
            $("div#myModal").modal("hide");
            alert("Tạo nhóm thành công");
            appendContact(group_name, group_image, result.group_id);
        }
    });
}

function appendContact(group_name, group_image, group_id) {
    var contact = `<li class="contact" group_id="${group_id}">
                        <div class="wrap">
                            <span class="contact-status online"></span>
                            <img src="${group_image}" alt="Ảnh đại diện của {{ $contact->name }}" />
                            <div class="meta">
                                <p class="name">${group_name}</p>
                                <p class="preview">Ready to chat</p>
                            </div>
                        </div>
                    </li>`;
    $("div#contacts ul").append(contact);
}