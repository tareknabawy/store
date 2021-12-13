// Show more/less content
$(document).ready(function () {
	"use strict";

	var pagination_data = document.getElementById('description');
	var show_more = pagination_data.getAttribute('data-show-more');
	var show_less = pagination_data.getAttribute('data-show-less');

	$readMoreJS.init({
	target: '.description',
	numOfWords: 75,
	toggle: true,
	moreLink: show_more,
	lessLink: show_less
});
});

// Show more/less reviews
$(document).ready(function () {
	"use strict";

	var pagination_data = document.getElementById('description');
	var show_more = pagination_data.getAttribute('data-show-more');
	var show_less = pagination_data.getAttribute('data-show-less');

if ($('.review').length > 3) {
    $('.review:gt(2)').hide();
    $('.show-more').show();
}

$('.show-more').on('click', function() {
	"use strict";

    $('.review:gt(2)').toggle();
    $(this).text() === show_less ? $(this).text(show_more) : $(this).text(show_less);
});
});

// Show progress bar using data attributes
$(document).ready(function () {
	"use strict";

$('.progress > div').css('width', function(){
    return $(this).parent().data('bar-width') + '%'
});
});

// Main Slider
$(document).ready(function () {
	"use strict";
var swiper = new Swiper('.swiper-main', {
    loop: true,
    autoplay: {
        delay: 3500
    },
    pagination: {
        el: '.swiper-pagination-main',
        clickable: true,
        renderBullet: function (index, className) {
            return '<span class="' + className + '">' + (index + 1) + '</span>';
        }
    },

    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',

    },
});
$('.swiper-pagination-bullet').hover(function () {
    "use strict";

    $(this).trigger("click");
});
});

// Tooltips
$(function () {
    "use strict";

    $('[data-toggle="tooltip"]').tooltip()
})

// SimpleLightbox
$(function () {
    "use strict";

    $('#screenshot-main a').simpleLightbox();
})