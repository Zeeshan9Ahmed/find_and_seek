$(document).ready(function () {
    $(".alert-dismissible").fadeTo(2000, 500).slideUp(500, function () {
        $(".alert-dismissible").alert('close');
    });
    $("a.del-notification").on("click",function(e){
        e.preventDefault();
        var redirect_url = $(this).attr("href");
        var noti_id = $(this).attr("data-id");
        var url = $(this).attr("data-href");
        if(noti_id > 0){
            // update notification badge
            $.ajax({
                  url: url,
                  method:"POST",
                  dataType: 'json',
                  data:{_token:$('meta[name=token]').attr('content'),id:noti_id},
                  success: function (data) {
                    if (data.success == 1) {
                        console.log("Notification Deleted");
                        window.location = redirect_url;
                    }
                  }
              })
          }
    })
    $("#cover-spin").hide();
    var origin = window.location.origin;

    if (origin == "http://localhost") {
        var APP_PATH = origin + "/faprojects/storylife/";
    } else {
        var APP_PATH = origin + "/";
    }
    // binds form submission and fields to the validation engine
   $(".validation-engine").validationEngine();
   bsCustomFileInput.init();

    $('#example1').DataTable({"pageLength": 50});
     $("a.admin-notification-bell").on("click",function(e){
        var obj = $(this);
        var notification_badge = parseInt($(this).attr("data-count-notification"));
        var url = $(this).attr("data-url");
        if(notification_badge > 0){
          // update notification badge
          $.ajax({
                url: url,
                method:"POST",
                dataType: 'json',
                data:{_token:$('meta[name=token]').attr('content')},
                error: function ()
                {
                    $("#cover-spin").hide();
                    error("Something went wrong. Please try again.");
                },
                success: function (data) {
                    //$("#cover-spin").show();
                    if (data.success == 1) {
                      obj.attr("data-count-notification",0);
                      obj.find(".navbar-badge").text(0);
                      console.log("Notification Read");
                    }
                }
            })
        }
        
      })


    /* show child details on popup*/
    $("body").on("click","a.child-readmore",function(e){
        var about = $(this).closest("li").find(".child-info").text();
        if(about != ""){
            $("#child-details-modal .child-details").text(about);
            $("#child-details-modal").modal('show');
        }
    });
    // delete popup
    $("body").on("click","a.del-post", function (e) {
        e.preventDefault();
        var url = $(this).attr("data-url");
        var uID = $(this).attr("data-id");
        if (uID != "") {
            $("#del-modal input[name=uID]").val(uID);
            $("#del-modal").modal('show');
        }
    });
    // mark edit-category
    $("body").on("click","a.edit-category",function(e){
        e.preventDefault();
        var id = $(this).attr("data-id");
        var name = $(this).attr("data-name");
        var status = $(this).attr("data-status");
        if (id != "" && name != "" && status != "") {
            $("#edit-category-model input[name=cat_name]").val(name);
            $("#edit-category-model input[name=id]").val(id);
            var statusHtml = "";
            if(status == 1){
                statusHtml ="<option value='1'>Active</option><option value='0'>Deactive</option>";
            }else{
                statusHtml ="<option value='0'>Deactive</option><option value='1'>Active</option>";
            }
            $("#edit-category-model select[name=is_active]").html(statusHtml.trim());
        }
    });
   
    $("body").on("click",'a.lock-user',function (e) {
        var uid = $(this).attr('data-uid');
        if (uid != "") {
            $.ajax({
                url: APP_PATH + 'admin/lock-user',
                method:"POST",
                dataType: 'json',
                data:{id:uid,_token:$('meta[name=token]').attr('content')},
                beforeSubmit: function () {
                    var pos = $(document).scrollTop() + 200;
                    $("#cover-spin").show();
                },
                error: function ()
                {
                    $("#cover-spin").hide();
                    error("Something went wrong. Please try again.");

                },
                success: function (data) {
                    $("#cover-spin").show();
                    if (data.success == 1) {
                        toastr.success(data.message, 'Success', {timeOut: 2000,onHidden: function () {
                                window.location.reload();
                            }})
                    }else{
                        $("#cover-spin").hide();
                        toastr.error(data.message, 'Error!', {timeOut: 2000});
                    }
                }
            })
        }else{
            toastr.error("Something went wrong please try again", 'Error!', {timeOut: 2000});
        }
    });
    
    $("a.change-logo-btn").on("click", function () {
        $(".logo-div").toggle();
    })

    // file check
    $('input.sizetype-validate:file').change(function () {
        var file = this.files[0];
        var name = file.name;
        var size = (file.size / (1024)).toFixed(2); // byte into KB
        var type = file.type;
        var maxSize = (4 * 1024 * 1024);
        var allowedType = Array("image/png", "image/PNG", "image/jpg", "image/JPG", "image/jpeg", "image/JPEG");
        //your validation
        if (size > maxSize) {
            $(this).val("");
            toastr.error('File Size exceed from 4MB', 'Error!', {timeOut: 2000});
        }
        if ($.inArray(type, allowedType) === -1) {
            $(this).val("");
            toastr.error('File format not supported', 'Error!', {timeOut: 2000});
        } else {
            $(".custom-msg").html("").hide();
        }
    });
});


function mapme(){

    setTimeout(function() {
        var address =  document.getElementById("location").value;
        var geocoder = new google.maps.Geocoder();

        geocoder.geocode( { 'address': address}, function(results, status) {
            if (status === google.maps.GeocoderStatus.OK) {
                var latitude = results[0].geometry.location.lat();
                var longitude = results[0].geometry.location.lng();

                document.getElementById('latitude').value = latitude;
                document.getElementById('longitude').value = longitude;
            }
        });
    }, 300);
}

function timeSince(date) {

    var seconds = Math.floor((new Date() - date) / 1000);

    var interval = Math.floor(seconds / 31536000);

    if (interval > 1) {
        return interval + " years ago";
    }
    interval = Math.floor(seconds / 2592000);
    if (interval > 1) {
        return interval + " months ago";
    }
    interval = Math.floor(seconds / 86400);
    if (interval > 1) {
        return interval + " days ago";
    }
    interval = Math.floor(seconds / 3600);
    if (interval >= 1) {
        return interval + " hours ago";
    }
    interval = Math.floor(seconds / 60);
    if (interval >= 1) {
        return interval + " minutes ago";
    }
    return Math.floor(seconds) + " seconds ago";
}

function timeConvert(timestamp) {
    var date = new Date(timestamp);
    return date.toLocaleDateString() + " " + date.toLocaleTimeString();
}

function getThumbImage(image_name){
    return   "http://localhost/faprojects/storylife/public/assets/uploads/thumbnails/"+image_name;
}
//var aDay = 24 * 60 * 60 * 1000
//console.log(timeSince(new Date(Date.now() - aDay)));
//console.log(timeSince(new Date(Date.now() - aDay * 2)));
