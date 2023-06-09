
$(document).ready(function () {
    loadClasses();

    $(".AddTutorButton").click(function (event) {
        let tutor = $(this)[0];
        let id = tutor.dataset.id;
        let studentID = tutor.dataset.studentid;
        let success = $.ajax({
            type: "POST",
            url: "/API/api.php/records/StudentTutors",
            data: "StudentID=" + studentID + "&TutorID=" + id + "",
            async: false,
            success: function (data) {
                return true;
            },
            error: function (data) {
                return false;
            }
        });
        $(tutor).attr("disabled", true);
        $(tutor).addClass("disabled");
        $(tutor).html("Added!");
    });

    $("#studentClasses").on("change", function (event) {
        let myID = $("input[name=myID").val();
        let classID = $("#studentClasses").val();
        if (classID < 0) {
            return;
            l
        }
        $.ajax({
            type: "GET",
            url: "/API/api.php/records/TutorAutoRecommendation?filter=ClassID,eq," + classID,
            async: false,
            success: function (data) {
                $.ajax({
                    type: "GET",
                    url: "/API/api.php/records/StudentTutors?filter=StudentID,eq," + myID,
                    async: false,
                    success: function (data2) {
                        for (var i = 0; i < data2["records"].length; i++) {
                            if (data2["records"][i]["TutorID"] === data["records"][0]["TutorID"]) {
                                $(".recommendedTutor").html("It looks like you already have the best tutor for that class! " + data["records"][0]["Name"] + " is excellent!");
                                return;
                            }
                        }

                        $(".recommendedTutor").html("We found a tutor for you! 🎉🎉<br><a href='javascript:focusTutor(\"" + data["records"][0]["TutorID"] + "\")'>" + data["records"][0]["Name"] + "</a> looks like a great fit!");
                    },
                    error: function (data) {
                        $(".recommendedTutor").html("Sorry, we can't recommend a tutor for that class at this time 😟");
                    }
                });

            },
            error: function (data) {
                $(".recommendedTutor").html("Sorry, we can't recommend a tutor for that class at this time 😟");
            }
        });

    });


    $(".RecommendTutorButton").click(function (event) {

    });


});

function loadClasses() {
    let myID = $("input[name=myID").val();
    $("#studentClasses").append("<option value='-1'>--Select--</option>");
    $.ajax({
        type: "GET",
        url: "/API/api.php/records/StudentClassesView?filter=StudentID,eq," + myID,
        async: false,
        success: function (data) {
            $(data["records"]).each(function (i) {
                $("#studentClasses").append("<option value='" + data["records"][i]["ClassID"] + "'>" + data["records"][i]["ClassName"] + " (" + data["records"][i]["ClassNumber"] + "-" + data["records"][i]["University"] + ")</option>");
            });
        },
        error: function (data) {
            return false;
        }
    });
}


function focusTutor(tutorID) {
    let tutorCard = $('.tutorCard[data-tutorid="' + tutorID + '"]')[0];
    tutorCard.scrollIntoView({behavior: 'smooth'});
}