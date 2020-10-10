$(function () {
    $(".wrapper").click(function () {
        visibleWrapper(false);
    });
});

function setSelect(value) {
    $("select").val(value);
}

function link(type) {
    $.get("/handler/account/"+type,function(data) {
        let json = JSON.parse(data);
        if (json.account === "logout") $(".item .right").removeClass("show");
    })
}

function sortBy() {
    let sorting = $("select").val();
    $.get("/handler/sorting",{"sorting":sorting},function (data) {
        window.location.replace("/");
    })
}

function visibleWrapper(status) {
    if (status) $(".wrapper,.dialog").addClass("active");
    else $(".wrapper,.dialog").removeClass("active");
}

function edit(id) {
    let text = $(".item#"+id).find(".text").html();
    $(".dialog input[name=id]").val(id);
    $(".dialog input[name=text]").val(text);
    visibleWrapper(true);
}

function status(current,id) {
    $.get("/handler/status",{"id":id},function (data) {
        console.log(data);
        let json = JSON.parse(data);
        if (json.status == 1) $(current).addClass("active");
        else $(current).removeClass("active");
    });
}

function send(name,url) {
    let form = $('#'+name)[0];
    let formData = new FormData(form);
    let result = protectForm(name);
    if (!result) return false;

    $.ajax({
        url: "/"+url,
        type: "post",
        data: formData,
        contentType: false,
        processData: false,
        cache: false,
        success: function (data) {
            console.log(data);
            let json = JSON.parse(data);
            if (json.message) {
                showMessage(json.message);
            } else {
                if (json.action === "add") {
                    location.reload();
                }
                if (json.action === "edit") {
                    $(".item#"+json.id).find(".text").html(json.text);
                    visibleWrapper(false);
                }
                if (json.account === "login") {
                    $(".item .right").addClass("show");
                }
            }
        }
    });
}

function protectForm(name) {
    let result = true;
    if (name === "add") {
        let email = $("input[name=email]").val();
        let name = $("input[name=name]").val();
        let text = $("input[name=text]").val();

        result = false;
        let regexEmail = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        let regexName = /^([A-zА-я ]{2,10})$/;
        if (!email) showMessage("Напишите email");
        else if (!regexEmail.test(email.toLowerCase())) showMessage("Email введен неверно");
        else if (!name) showMessage("Напишите имя пользователя");
        else if (!regexName.test(name)) showMessage("В имени пользователя только буквы");
        else if (!text) showMessage("Напишите текст задачи");
        else result = true;
    }
    return result;
}

function showMessage(message) {
    let div = $(".message");
    div.html(message).addClass("active");
    setTimeout(function () {
        div.removeClass("active");
    },2000);
}