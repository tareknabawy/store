// Delete Prompt
$(document).ready(function() {
    "use strict";

    $('._delete_data').click(function(e) {
        var data_id = $(this).attr('data-id');
        var delete_data = document.getElementById('table');
        var delete_message = delete_data.getAttribute('data-delete-prompt');
        var delete_yes = delete_data.getAttribute('data-yes');
        var delete_cancel = delete_data.getAttribute('data-cancel');

        Swal.fire({
            title: delete_message,
            type: 'error',
            showCancelButton: true,
            confirmButtonText: delete_yes,
            cancelButtonText: delete_cancel,
        }).then((result) => {

            if (result.value) {
                $(document).find('#delete_from_' + data_id).submit();
            }
        })
    });
});

// Comment Approval/Delete Prompt
$(document).ready(function() {
    "use strict";

    $('.show_comment_approved').click(function(e) {
        event.preventDefault()

        var data_id = $(this).attr('data-id');
        var url = this.href;
        var comment_details = $(this).data("comment-details");
        var comment_title = $(this).data("comment-title");
        var delete_data = document.getElementById('table');
        var mark_unapproved = delete_data.getAttribute('data-mark-unapproved');
        var delete_cancel = delete_data.getAttribute('data-cancel');

        Swal.fire({
            title: comment_title,
            text: comment_details,
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: mark_unapproved,
            cancelButtonText: delete_cancel,
        }).then((result) => {
            if (result.value) {
                window.location = url + '?approve=0';
            }
        })
    });
});

// Comment Approval/Delete Prompt
$(document).ready(function() {
    "use strict";

    $('.show_comment_not_approved').click(function(e) {
        event.preventDefault()

        var data_id = $(this).attr('data-id');
        var url = this.href;
        var comment_details = $(this).data("comment-details");
        var comment_title = $(this).data("comment-title");
        var delete_data = document.getElementById('table');
        var delete_cancel = delete_data.getAttribute('data-cancel');
        var approve = delete_data.getAttribute('data-approve');

        Swal.fire({
            title: "" + comment_title + "",
            text: "" + comment_details + "",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: approve,
            cancelButtonText: delete_cancel
        }).then((result) => {
            if (result.value) {
                window.location = url + '?approve=1';
            }
        })
    });
});

// Query Cache Clear Prompt
$(document).ready(function() {
    "use strict";

    $('.clear-cache').click(function(e) {
        event.preventDefault()

        var delete_data = document.getElementById('cache-info');
        var delete_yes = delete_data.getAttribute('data-yes');
        var delete_cancel = delete_data.getAttribute('data-cancel');

        var url = this.href;
        var comment_title = $(this).data("cache-clear");

        Swal.fire({
            title: "" + comment_title + "",
            type: 'question',
            showCancelButton: true,
            confirmButtonText: delete_yes,
            cancelButtonText: delete_cancel
        }).then((result) => {
            if (result.value) {
                window.location = url;
            }
        })
    });
});

$(document).ready(function(){
    "use strict";

    $("#browse-color-image, #browse-color-file").change(function(){
        this.classList.add('sel');
    });
});

// Version Check
$(document).ready(function() {
    "use strict";

    $('.v_control').click(function(e) {
        var version_data = document.getElementById('v_control');
        var version_control = version_data.getAttribute('data-version-control');
        var version_info = version_data.getAttribute('data-version-info');
        var latest_version = version_data.getAttribute('data-latest-version');
        var version_control_fail = version_data.getAttribute('data-version-control-fail');

        const ipAPI = 'https://www.foxart.co/version/app-portal.json.php'

        Swal.queue([{
            title: version_control,
            confirmButtonText: latest_version,
            text: version_info,
            showLoaderOnConfirm: true,
            preConfirm: () => {
                return fetch(ipAPI)
                    .then(response => response.json())
                    .then(data => Swal.insertQueueStep(data.version))
                    .catch(() => {
                        Swal.insertQueueStep({
                            icon: 'error',
                            title: version_control_fail,
                        })
                    })
            }
        }])
    });
});

// Sort items
$(function() {
    "use strict";
    
    $(".sortable-posts").sortable({
        stop: function() {
            var sort_type = $(this).attr('id');
            $.map($(this).find('tr'), function(el) {
                var id = el.id;
                var sort = $(el).index();
                $.ajax({
                    url: '/admin/' + sort_type + '/order',
                    type: 'GET',
                    data: {
                        id: id,
                        sort: sort
                    },
                    success: function(response) {
                        if (response.status == "success") {
                            console.log(response);
                        } else {
                            console.log(response);
                        }
                    }
                });
                $(".sortable-posts").disableSelection();
            });
        }
    });
});

// Sort topics
$(function() {
    "use strict";
    
    $(".sortable-topics").sortable({
    });
});

// Summernote - text editor
$(function() {
    "use strict";

    $('.textarea').summernote({height: 250})
})

// Checkbox style
$(document).ready(function() {
    "use strict";

    $('input').iCheck({
        checkboxClass: 'icheckbox_square-aero'
    });
});

// Remove screenshots
$(document).ready(function() {
    "use strict";

    $(".remove_screenshot").click(function(){
        var screenshots_data = document.getElementById('screenshots');
        var content_deleted = screenshots_data.getAttribute('data-content-deleted');
        var succesfully_deleted = screenshots_data.getAttribute('data-succesfully-deleted');

        $(this).closest(".col-md-2").fadeOut('300');
        var image_name=$(this).data("name");
        var app_id=$(this).data("app-id");
          $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: "/admin/multiple-file-upload/delete",
            type: "POST",
            data:{"image_name":image_name,"app_id":app_id}
          }).done(function(data) {
            Swal.fire(
                content_deleted,
                succesfully_deleted,
                'success'
              )        });
    }); 
});

// Remove screenshots
function bindFunc(){
    "use strict";

    $(".remove_screenshot").click(function(){
        var screenshots_data = document.getElementById('screenshots');
        var content_deleted = screenshots_data.getAttribute('data-content-deleted');
        var succesfully_deleted = screenshots_data.getAttribute('data-succesfully-deleted');

        $(this).closest(".col-md-2").fadeOut('300');
        var image_name=$(this).data("name");
        var app_id=$(this).data("app-id");
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: "/admin/multiple-file-upload/delete",
            type: "POST",
            data:{"image_name":image_name,"app_id":app_id}
          }).done(function(data) {
            Swal.fire(
                content_deleted,
                succesfully_deleted,
                'success'
              )
          });
    }); 
}
  
// Upload screenshots
$(document).ready(function() {
    "use strict";
    
    $('#screenshot_form').ajaxForm({
        beforeSend: function() {
            $('.progress-bar').text('0%');
            $('.progress-bar').css('width', '0%');
        },
        uploadProgress: function(event, position, total, percentComplete) {
            $('.progress-bar').text(percentComplete + '0%');
            $('.progress-bar').css('width', percentComplete + '0%');
        },
        success: function(data) {
            if (data.success) {
                $('#success').html('<div class="text-success text-center"><b>' + data.success +
                    '</b></div><br />');
                $('#success').append(data.image);
                $('.progress-bar').text('Uploaded');
                $('.progress-bar').css('width', '100%');
                bindFunc()

            } else {}
        }
    });
});

// Add/Delete Topic Items
$(document).ready(function() {
    "use strict";

    var data_id = $(this).attr('data-id');
    var delete_data = document.getElementById('table');
    var delete_text = delete_data.getAttribute('data-delete');
    var app_title_text = delete_data.getAttribute('data-app-title');
    
      // Get List of Apps
      $(document).on('keydown', '.topiclist', function() {

        var id = this.id;
        var splitid = id.split('_');
        var index = splitid[1];

        $('#' + id).autocomplete({
            source: function(request, response) {
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: "/admin/topics/details",
                    type: 'post',
                    dataType: "json",
                    data: {
                        search: request.term,
                        request: 1
                    },
                    success: function(data) {
                        response(data);
                    }
                });
            },
            select: function(event, ui) {
                $(this).val(ui.item.label);
                var app_id = ui.item.value;

                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: '/admin/topics/details',
                    type: 'post',
                    data: {
                        app_id: app_id,
                        request: 2
                    },
                    dataType: 'json',
                    success: function(response) {

                        var len = response.length;

                        if (len > 0) {
                            var id = response[0]['id'];
                            var img = response[0]['image'];

                            document.getElementById('appid_' + index).value = id;
                            document.getElementById('img_' + index).src = "/images/" + img; // {{ asset("images") }}
                        }

                    }
                });

                return false;
            }
        });
    });

    // Topic Item Delete Prompt
    $(document).ready(function() {
        "use strict";

        $(".sortable-topics").on('click', '._delete_topic', function(e) {

            var data_id = $(this).attr('data-id');
            var delete_data = document.getElementById('table');
            var delete_message = delete_data.getAttribute('data-delete-prompt');
            var delete_yes = delete_data.getAttribute('data-yes');
            var delete_cancel = delete_data.getAttribute('data-cancel');

            Swal.fire({
                title: delete_message,
                type: 'error',
                showCancelButton: true,
                confirmButtonText: delete_yes,
                cancelButtonText: delete_cancel,
            }).then((result) => {

                if (result.value) {
                    var del_tr = $(this).closest("tr");
                    del_tr.remove();

                    var lastname_id = $('.topic_list input[type=text]:nth-child(1)').last().attr('id');

                    if (lastname_id == null) {
                        $('#addmore').trigger('click');
                    }

                }
            })
        });

    });

    // Add More Topic Item
    $('#addmore').click(function() {
        "use strict";

        var lastname_id = $('.topic_list input[type=text]:nth-child(1)').last().attr('id');

        if (lastname_id != null) {
            var split_id = lastname_id.split('_');
            var index = Number(split_id[1]) + 1;
        } else {
            var index = 1;
        }

        var html = "<tr class='topic_list'><td><img src='/images/no_image.png' id='img_" + index + "' class='img-w100'></td><td><input type='text' onclick='this.focus(); this.select()' class='topiclist form-control' id='topiclist_" + index + "' placeholder='" + app_title_text + "'><input type='button' value='" + delete_text + "' class='btn btn-sm bg-red mt-5 _delete_topic' id='remove'></td><input type='hidden' class='appid' id='appid_" + index + "' name='appid_" + index + "'></tr>";

        $('tbody').append(html);

    });
});