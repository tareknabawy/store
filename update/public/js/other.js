// Social media share
function sm_share(url, title, w, h) {
    "use strict";

    var dualScreenLeft = window.screenLeft != undefined ? window.screenLeft : screen.left;
    var dualScreenTop = window.screenTop != undefined ? window.screenTop : screen.top;

    var width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
    var height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;

    var left = ((width / 2) - (w / 2)) + dualScreenLeft;
    var top = ((height / 2) - (h / 2)) + dualScreenTop;
    var newWindow = window.open(url, title, 'scrollbars=yes, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);

    if (window.focus) {
        newWindow.focus();
    }
}

// Fixed share buttons in mobile
jQuery(document).ready(function ($) {
    "use strict";

    var alterClass = function () {
        var ww = document.body.clientWidth;
        if (ww >= 992) {
            $('.smi').removeClass('fixed-bottom');
        } else if (ww <= 991) {
            $('.smi').addClass('fixed-bottom');
        }
    };
    $(window).resize(function () {
        alterClass();
    });
    alterClass();
});

// Search box opener
function SearchBox() {
    "use strict";

    document.getElementById("SearchBox").style.width = "100%";
}

// Search box closer
function closeSearchBox() {
    "use strict";

    document.getElementById("SearchBox").style.width = "0%";
}

// Apps star ratings
$(function () {
    "use strict";
    
    $('.ratings').rating(function (vote, event, data_vote_id) {
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: "/vote/"+data_vote_id+"",
            type: "POST",
            data: {vote: vote},
            success: function (data) {
                $(".voteinfo").fadeIn("slow");
                $(".voteinfo").html(data);
                $('.voteinfo').delay(2000).fadeOut('slow');
            }
        });
    });
});

// Comment & Review form apps star ratings
$(function () {
    "use strict";
    
    $('.user_ratings').rating(function () {
    });
});

$(document).ready(function () {
    "use strict";

$('#terms a').click(function(e) {
    var txt = $(e.target).text();
    $('#term').val(txt);
    return false;
  });
  
});   

// Redirections
$(document).ready(function () {
    "use strict";

    if(window.location.href.indexOf("/redirect/") > -1) {
        var id_data = document.getElementById('redirect');
        var app_id = id_data.getAttribute('data-app-id');
        var app_delay = id_data.getAttribute('data-redirection-delay');

        window.setTimeout(function () {
            window.location.href = '/download/'+app_id+'';
        }, app_delay);
   }
});

// Screenshot slider
$(document).ready(function () {
    "use strict";

    $("#right").click(function () { 
    var leftPos = $('#screenshot-main').scrollLeft();
    $("#screenshot-main").animate({scrollLeft: leftPos + 250}, 600);
});   
             
    $("#left").click(function () { 
    var leftPos2 = $('#screenshot-main').scrollLeft();
    $("#screenshot-main").animate({scrollLeft: leftPos2 - 250}, 600);
});   

var ar=new Array(33,34,35,36,37,38,39,40);

$(document).keydown(function(e) {
     var key = e.which;
      if($.inArray(key,ar) > -1) {
          e.preventDefault();
          return false;
      }
      return true;
});

});

// Smooth Scroll
$(document).ready(function() { 
    "use strict";

    $(".review-title a").click(function() { 
        event.preventDefault();
        document.querySelector(".comment-box").style.display = "block";
        scrollSmoothTo('review-title');
    }); 
}); 

function scrollSmoothTo(elementId) {
    "use strict";

    var element = document.getElementById(elementId);
    element.scrollIntoView({
      block: 'start',
      behavior: 'smooth'
    });
  }

// ReadMoreJS
/**
* @app ReadMoreJS
* @desc Breaks the content of an element to the specified number of words
* @version 1.1.0
* @license The MIT License (MIT)
* @author George Raptis | http://georap.gr 
*/
;(function (win, doc, undef) {
	'use strict';
	
	var RM = {};

	RM.helpers = {
		extendObj: function() {
			for (var i = 1, l = arguments.length; i < l; i++) {
				for (var key in arguments[i]) {
		            if (arguments[i].hasOwnProperty(key)) {
		                if (arguments[i][key] && arguments[i][key].constructor && arguments[i][key].constructor === Object) {
		                	arguments[0][key] = arguments[0][key] || {};
		                	this.extendObj(arguments[0][key], arguments[i][key]);
		                } else {
		                	arguments[0][key] = arguments[i][key];
		                }
		            }
			    }
			}
			return arguments[0];
		}
	};

	RM.countWords = function (str) {
  		return str.split(/\s+/).length;
	};

	RM.generateTrimmed = function (str, wordsNum) {
		return str.split(/\s+/).slice(0, wordsNum).join(' ') + '...';
	};

	RM.init = function (options) {
		var defaults = {
			target: '',
			numOfWords: 50,
			toggle: true,
			moreLink: 'read more...',
			lessLink: 'read less',
			linkClass: 'rm-link', 
			containerClass: false 
		};
		options = RM.helpers.extendObj({}, defaults, options);

		var target = doc.querySelectorAll(options.target),
			targetLen = target.length,
			targetContent,
			trimmedTargetContent,
			targetContentWords,
			initArr = [],
			trimmedArr = [],
			i, j, l, moreContainer, rmLink, moreLinkID, index;

		for (i = 0; i < targetLen; i++) {
			targetContent = target[i].innerHTML;
			trimmedTargetContent = RM.generateTrimmed(targetContent, options.numOfWords);
			targetContentWords = RM.countWords(targetContent);

			initArr.push(targetContent);
			trimmedArr.push(trimmedTargetContent);

			if (options.numOfWords < targetContentWords - 1) {
				target[i].innerHTML = trimmedArr[i];
				
				moreContainer = doc.createElement('div');
				if(options.containerClass) {
					moreContainer.className = options.containerClass;
				}

				moreContainer.innerHTML = '<a id="rm-more_'+ i + '"'
					+ ' class="'+ options.linkClass +'"'
					+ ' style="cursor:pointer;" data-readmore="anchor">'
					+ options.moreLink
					+ '</a>';
				target[i].parentNode.insertBefore(moreContainer, target[i].nextSibling);
			}
		}

		rmLink = doc.querySelectorAll('[data-readmore="anchor"]');

        for (j = 0, l = rmLink.length; j < l; j++) {
			rmLink[j].onclick = function () {
				moreLinkID = this.getAttribute('id');
				index = moreLinkID.split('_')[1];
				
				if (this.getAttribute('data-clicked') !== 'true') {
					target[index].innerHTML = initArr[index];
					if (options.toggle !== false) {
						this.innerHTML = options.lessLink;
						this.setAttribute('data-clicked', true);
					} else {
						this.innerHTML = '';
					}
				} else {
					target[index].innerHTML = trimmedArr[index];
					this.innerHTML = options.moreLink;
					this.setAttribute('data-clicked', false);
				}
			};
		}
	};

	window.$readMoreJS = RM;
}(this, this.document));

// Validate Email
function validateEmail($email) {
    "use strict";

    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    return emailReg.test( $email );
  }

// Comment Form Control
function form_control() {
    "use strict";

    var name = $.trim($('#name').val());
    var email = $.trim($('#email').val());
    var title = $.trim($('#title').val());
    var comment = $.trim($('#comment').val());
    var voting_data = document.getElementById('rating');
    var rating_id = voting_data.getAttribute('data-rating-id');
    var comment_data = document.getElementById('comment-section');
    var fill_all_fields = comment_data.getAttribute('data-fill-all-fields');

    if (validateEmail(email) && name != "" && title != "" && comment != "") {
        comment_send();
    } else {
        $('#comment_result').html('<div class="alert alert-danger show mt-3" role="alert">' +fill_all_fields+ '');
    }
}

// Post Comment
function comment_send() {
    "use strict";

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        url: '/comment',
        data: $('#comment-form').serialize(),
        success: function(msg) {
            $("#comment-section :input").prop("disabled", true);
            $('#comment_result').html(msg);
            $("#comment-form")[0].reset();
        }
    });
}

// Submission Form Control
function submission_form_control() {
    "use strict";

    var name = $.trim($('#name').val());
    var email = $.trim($('#email').val());
    var title = $.trim($('#title').val());
    var description = $.trim($('#description').val());
    var category = $.trim($('#category').val());
    var platform = $.trim($('#platform').val());
    var developer = $.trim($('#developer').val());
    var url = $.trim($('#url').val());
    var license = $.trim($('#license').val());
    var file_size = $.trim($('#file-size').val());
    var detailed_description = $.trim($('#detailed-description').val());
    var image = $.trim($('#image').val());
    var submission_data = document.getElementById('submission-section');
    var fill_all_fields = submission_data.getAttribute('data-fill-all-fields');

    if (validateEmail(email) && name != "" && title != "" && description != "" && category != "" && platform != "" && developer != "" && url != "" && image != "") {
        submission_send();
    } else {
        $('#submission_result').html('<div class="alert alert-danger show mt-3" role="alert">' +fill_all_fields+ '');
    }
}

// Post Submission
function submission_send() {
    "use strict";

    var frm = $('#submission-form');
    var formData = new FormData(frm[0]);
    formData.append('image', $('input[type=file]')[0].files[0]);

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        enctype: 'multipart/form-data',
        url: '/submission',
        data: formData,
        processData: false,
        contentType: false,
        success: function(msg) {
            $("#submission-section :input").prop("disabled", true);
            $('#submission_result').html(msg);
            $("#submission-form")[0].reset();
        }
    });
}

// Change position of elements in the app page
function moveDiv(){
        if($(window).width() < 990 ){ 
            $("#download_section").insertBefore("#description");
            $("#popular_apps").addClass("mt-3");
            $("#download_section").addClass("mt-3");
        }else{
            $("#download_section").insertBefore("#move_item");
            $("#popular_apps").removeClass("mt-3");
            $("#download_section").removeClass("mt-3");
}
    }
    $(document).ready(function () {
        moveDiv();
        $(window).resize(function(){
         moveDiv();
        });
    });
