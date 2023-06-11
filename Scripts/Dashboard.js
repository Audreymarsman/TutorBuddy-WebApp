
$(document).ready(function () {
    $(".RemoveTutorButton").click(function (event) {
        let tutor = $(this)[0];
        let id = tutor.dataset.id;
        let success = $.ajax({
            type: "DELETE",
            url: "/API/api.php/records/StudentTutors/" + id,
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
        $(tutor).html("Removed!");
    });
    $(".RemoveClassButton").click(function (event) {
        let classElem = $(this)[0];
        let id = classElem.dataset.id;
        let success = $.ajax({
            type: "DELETE",
            url: "/API/api.php/records/StudentClasses/" + id,
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
        $(classElem).html("Removed!");
    });
    $(".ViewAssignmentsButton").click(function (event) {
        let classElem = $(this)[0];
        let id = classElem.dataset.id;
        window.location.href="/Pages/Assignments.php?id="+id;
    });
    
    $(".AddAssignmentButton").click(function (event) {
        let classElem = $(this)[0];
        let id = classElem.dataset.id;
        $("#uploadPopup input[name=classID]").val(id);
        $("#uploadPopup").dialog(
                {
                    title: "Upload An Assignment!",
                    modal: true,
                    buttons: [
                        {
                            text: "Upload!",
                            icon: "ui-icon-heart",
                            click: function () {
                                $.ajax({
                                    xhr: function () {
                                        var progress = $('.progress'),
                                                xhr = $.ajaxSettings.xhr();

                                        progress.show();

                                        xhr.upload.onprogress = function (ev) {
                                            if (ev.lengthComputable) {
                                                var percentComplete = parseInt((ev.loaded / ev.total) * 100);
                                                progress.val(percentComplete);
                                                if (percentComplete === 100) {
                                                    progress.hide().val(0);
                                                }
                                            }
                                        };

                                        return xhr;
                                    },
                                    // Your server script to process the upload
                                    url: '/API/Files/uploadAssignment.php',
                                    type: 'POST',
                                    contentType: false,
                                    cache: false,
                                    processData: false,
                                    async: false,
                                    data: new FormData($('#uploadPopup form')[0]),
                                    
                                    success: function (data) {
                                       
                                        $(classElem).html("Uploaded!");
                                        setTimeout(function () {
                                            $(classElem).html("Upload Assignment!");
                                        }, 3000);
                                    },
                                    error: function (data) {
                                        alert("Upload Failed: " + data);
                                    }
                                });
                                 $(this).dialog("close");
                            }
                        }
                    ]
                }
        );

    });
    $(".RateTutorButton").click(function (event) {
        let user = $(this)[0];
        let name = user.dataset.name;
        let scorerID = user.dataset.scorerid;
        let scoredID = user.dataset.scoredid;
        let score = $.ajax({
            type: "GET",
            url: "/API/api.php/records/Rating/?filter=ScorerID,eq," + scorerID + "&filter=UserID,eq," + scoredID,
            async: false,
            success: function (data) {
                return data;
            },
            error: function (data) {
                return -1;
            }
        });
        if (score["responseJSON"]["records"].length > 0) {
            var scoreVal = score["responseJSON"]["records"][0]["Score"];
            var rowID = score["responseJSON"]["records"][0]["ID"];
        } else {
            var rowID = 0;
        }
        $("input[name=rating]:checked").prop('checked', false);
        if (scoreVal !== null && scoreVal >= 0) {
            $("#ratePopup input[value='" + scoreVal + "']").prop('checked', true);
        }
        $("#ratePopup").dialog(
                {
                    title: "Rate " + name,
                    modal: true,
                    buttons: [
                        {
                            text: "Rate",
                            icon: "ui-icon-heart",
                            click: function () {
                                var newScore = $("input[name=rating]:checked").val();
                                if (rowID === 0) { //not rated yet
                                    $.ajax({
                                        type: "POST",
                                        url: "/API/api.php/records/Rating/",
                                        data: "Score=" + newScore + "&UserID=" + scoredID + "&ScorerID=" + scorerID,
                                        async: false,
                                        success: function (data) {
                                            return data;
                                        },
                                        error: function (data) {
                                            return -1;
                                        }
                                    });
                                } else {
                                    $.ajax({
                                        type: "PUT",
                                        url: "/API/api.php/records/Rating/" + rowID,
                                        data: "Score=" + newScore,
                                        async: false,
                                        success: function (data) {
                                            return data;
                                        },
                                        error: function (data) {
                                            return -1;
                                        }
                                    });
                                }
                                $(this).dialog("close");
                            }
                        }
                    ]
                }
        );
    });
});

