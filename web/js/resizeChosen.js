$(document).ready(function(){
    resizeChosen();
    jQuery(window).on('resize', resizeChosen);
});

function resizeChosen() {
    $(".chosen-container").each(function() {
        $(this).attr('style', 'width: 100%');
    });
}