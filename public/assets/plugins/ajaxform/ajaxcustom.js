var delay;
$(document).ready(function () {
    initComp();

});
function initComp()
{

    $("form:not(.novalidate)").validationEngine({promptPosition: "centerTop", scroll: false});
    $("form.ajaxForm").ajaxForm({
        dataType: "json",
        beforeSubmit: function () {
            $("input[type=submit],button[type=submit]").prop('disabled', true);
            var pos = $(document).scrollTop() + 200;
            // $("#cover-spin").css({"top": pos});
            $("#cover-spin").show();

            faction = $("form").attr("action");
            if (faction == undefined)
            {
               r = confirm("Are you sure?");
               if (r)
               {

               }
               else
               {
                   $("#cover-spin").hide();
                   return false;
               }
            }
        },
        error: function ()
        {
            $("#cover-spin").hide();
            $("input[type=submit],button[type=submit]").prop('disabled',false);
            error("Something went wrong. Please try again.");

        },
        success: function (data) {

            console.log(data['success']);
            if (data == null || data == "")
            {
                window.location.reload(true);
            } else if (data['success'] == 0)
            {

                error(data['message']);
                $("input[type=submit],button[type=submit]").prop('disabled', false);
                $("#cover-spin").hide();
            } else if (data['success'] == 1)
            {
                success(data['message']);
            }
            else if (data['info'] == 1)
            {
                info(data['message']);
            }
            if (data['reload'] !== undefined && data['reload'] == true)
            {
                setTimeout(function () {
                    window.location.reload(true);
                }, 1000);
            }
            if (data['redirect'] !== undefined && data['redirect'] != '')
            {
                setTimeout(function () {
                    window.location = data['redirect'];
                    ;
                }, 1000);
            }

//            resetForm();
        }
    });


    delay = function (ms, func) {
        return setTimeout(func, ms);
    };

    toastr.options = {
        positionClass: 'toast-middle-center'
    };


    $(".add_more").click(function () {
        data = $("#add_more_trade").html();
        $("#trade_div").append(data);
    })
    $(".Removediv").click(function () {
        $(this).parent().remove();
    });
    $("body").on("click",'.ajax',function () {
        $("#cover-spin").show();
        var href = $(this).attr("href");
        var rel = $(this).attr("rel");
        ele = $(this);
        if (rel === "delete")
        {
            var r = confirm("Do you want to perform this action?")
            if (r === true)
            {
                $.ajax({
                    url: href,
                    dataType: "json",
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        $("#cover-spin").hide();
                        error("Request not completed.Please try Again");
                    },
                    success: function (data) {
                        if (data == null || data == "")
                        {
                            window.location.reload(true);
                        } else if (data['success'] == 0)
                        {
                            error(data['message']);
                            $("#cover-spin").hide();
                        } else if (data['success'] == 1)
                        {
                            success(data['message']);
                        }
                        if (data['reload'] !== undefined && data['reload'] == true)
                        {
                            setTimeout(function () {
                                window.location.reload(true);
                            }, 1000);
                        }
                        if (data['redirect'] !== undefined && data['redirect'] != '')
                        {
                            setTimeout(function () {
                                window.location = data['redirect'];
                                ;
                            }, 1000);
                        }
                        if (data['deleteRow'] !== undefined)
                        {
                            ele.closest("tr").remove();
                        }
                    }
                });
            } else {
                $("#cover-spin").hide();
            }
        } else
        {
            $.ajax({
                url: href,
                dataType: "json",
                error: function (jqXHR, textStatus, errorThrown)
                {
                    $("#cover-spin").hide();
                    error("Request not completed.Please try Again");
                },
                success: function (data) {
                    $("#cover-spin").hide();
                    if (data == null || data == "")
                    {
                        window.location.reload(true);
                    } else if (data['success'] == 0)
                    {
                        error(data['message']);
                        $("#cover-spin").hide();
                    } else if (data['success'] == 1)
                    {
                        success(data['message']);
                    }
                    if (data['reload'] !== undefined && data['reload'] == true)
                    {
                        setTimeout(function () {
                            window.location.reload(true);
                        }, 1000);
                    }
                    if (data['redirect'] !== undefined && data['redirect'] != '')
                    {
                        setTimeout(function () {
                            window.location = data['redirect'];
                        }, 1000);
                    }
                    if (data['deleteRow'] !== undefined)
                    {
                        $(this).closest("tr").remove();
                    }
                }
            });
        }
        return false;
    });
    $(".ajaxselect").change(function () {
        surl = $(this).attr("data-url");
        target_id = $(this).attr("data-target");
        val = $(this).val();
        $.ajax({
            url: surl + "/" + val,
            success: function (data)
            {
                $("#" + target_id).html(data);
            }
        });
    });
}

function setSelected(id, value)
{
    $("#" + id + " option").each(function () {
        val = $(this).val();
        if (value == val)
        {
            $(this).attr("selected", "selected");
        }

    });
}
function deleteP(url)
{
    var r = confirm("Would you like to delete?")
    if (r == true)
    {
        window.location = url;
    }
}

function error(message)
{
    delay(200, function () {
        return toastr.error(message, 'Error');
    });
}
function success(message)
{
    delay(200, function () {
        return toastr.success(message, 'Success');
    });
}
function info(message)
{

    delay(200, function () {
        return toastr.info(message, 'Info');
    });
}

function Removediv(val)
{
    $(val).parent().parent().parent().remove();
}
function resetForm()
{
    $("form input[type=text]").val("");
    $("form input[type=password]").val("");
    $("form select").val("");
}
function ajaxRequest(href)
{
    $.ajax({
        url: href,
        dataType: "json",
        error: function (jqXHR, textStatus, errorThrown)
        {
            $("#cover-spin").hide();
            error("Request not completed.Please try Again");
        },
        success: function (data) {
            $("#cover-spin").hide();
            if (data == null || data == "")
            {
                window.location.reload(true);
            } else if (data['error'] !== undefined)
            {
                error(data['error']);
            } else if (data['success'] !== undefined)
            {
                success(data['success']);
            } else if (data['redirect'] !== undefined)
            {
                window.location = data['redirect'];
            }
            if (data['deleteRow'] !== undefined)
            {
                $(this).closest("tr").remove();
            }
        }
    });
}
function encode(name) {
    for (a = 0; a < 2; a++) {
        name = window.btoa(name);
        for (b = 0; b < 3; b++) {
            name = window.btoa(name);
        }
    }
    return name;
}
