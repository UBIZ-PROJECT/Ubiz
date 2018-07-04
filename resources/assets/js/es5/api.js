function goToInputPage(self) {
    $("#o-put").hide();
    $("#i-put").fadeIn("slow");
    jQuery('#nicescroll-oput').getNiceScroll().remove();
    jQuery('#nicescroll-iput').getNiceScroll().remove();
    jQuery('#nicescroll-iput').niceScroll({
        cursorcolor: "#9fa8b0",
        cursorwidth: "5px",
        cursorborder: "none",
        cursorborderradius: 5,
        cursoropacitymin: 0.4,
        autohidemode: 'leave',
        horizrailenabled: false
    });
}

function goBackToOutputPage(self) {
    $("#o-put").fadeIn("slow");
    $("#i-put").hide();
    jQuery('#nicescroll-iput').getNiceScroll().remove();
    jQuery('#nicescroll-oput').getNiceScroll().remove();
    jQuery('#nicescroll-oput').niceScroll({
        cursorcolor: "#9fa8b0",
        cursorwidth: "5px",
        cursorborder: "none",
        cursorborderradius: 5,
        cursoropacitymin: 0.4,
        autohidemode: 'leave',
        horizrailenabled: false
    });
}

function refreshOutputPage(self) {

}

jQuery(document).ready(function () {
    jQuery('#nicescroll-sidebar').niceScroll({
        cursorcolor: "#9fa8b0",
        cursorwidth: "5px",
        cursorborder: "none",
        cursorborderradius: 5,
        cursoropacitymin: 0.4,
        autohidemode: 'leave',
        horizrailenabled: false
    });
    jQuery('#nicescroll-oput').niceScroll({
        cursorcolor: "#9fa8b0",
        cursorwidth: "5px",
        cursorborder: "none",
        cursorborderradius: 5,
        cursoropacitymin: 0.4,
        autohidemode: 'leave',
        horizrailenabled: false
    });
    $('.utooltip').tooltipster({
        side: 'top', theme: 'tooltipster-ubiz', animation: 'swing', delay: 100
    });
});