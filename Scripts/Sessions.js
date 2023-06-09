
$(document).ready(function () {
    $(".joinLink").click(function (event) {
        let session = $(this)[0];
        let id = session.dataset.id;
        let studentID = session.dataset.studentid;
        let success =$.ajax({
            type: "POST",
            url: "/API/api.php/records/StudentSchedules",
            data: "StudentID=" + studentID + "&ScheduleID=" + id + "",
            async: false,
            success: function (data) {
                return true;
            },
            error: function (data) {
                return false;
            }
        });
        $(session).attr("disabled", true);
        $(session).addClass("disabled");
        $(session).html("Joined!");
    });
});

function joinClass() {

}

