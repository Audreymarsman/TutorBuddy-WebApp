
$(document).ready(function () {
    $(".addClass").click(function (event) {
        let classElem = $(this)[0];
        let id = classElem.dataset.id;
        let studentID = classElem.dataset.studentid;
        let success =$.ajax({
            type: "POST",
            url: "/API/api.php/records/StudentClasses",
            data: "StudentID=" + studentID + "&ClassID=" + id + "",
            async: false,
            success: function (data) {
                return true;
            },
            error: function (data) {
                return false;
            }
        });
        $(classElem).attr("disabled", true);
        $(classElem).addClass("disabled");
        $(classElem).html("Joined!");
    });
});

function joinClass() {

}

