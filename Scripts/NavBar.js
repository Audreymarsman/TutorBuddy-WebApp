$("#navBar .hamburger").on('click', function () {
    if ($("#navBar .slideOut").is(":visible")) {
        $("#navBar .slideOut").hide("slide", {direction: "left"}, 1000);
        $("#navBar .hamburger").removeClass("change");
    } else {
        $("#navBar .slideOut").show("slide", {direction: "left"}, 1000);
        $("#navBar .hamburger").addClass("change");
    }
});
