$(document).ready(function() {

    $("#log-in").click(function() {
        $(".recitation").remove();
        $(".group").remove();
        $(".active").removeClass("active");

        $("input[name=student]").val($("#student").val());

        var options = {
            action: "student-name",
            student: $("#student").val(),
        };

        $.get("api.php", options, function(name) {
            $(".student-name").text(name);
        }, "json");
    });

    $(document).on("click", ".course", function(event) {
        $(".recitation").remove();
        $(".group").remove();

        $("input[name=course]").val($(this).text());

        var options = {
            action: "recitations",
            course: $(this).text()
        };

        $(".course.active").removeClass("active");
        $(this).addClass("active");

        $.get("api.php", options, function(data) {
            for (var i = 0; i < data.length; i++) {
                $("#recitations").append($("<button>")
                    .attr("type", "button")
                    .addClass("list-group-item")
                    .addClass("recitation")
                    .text(data[i]));
            }
        }, "json");
    });

    $(document).on("click", ".recitation", function(event) {
        $(".group").remove();

        $("input[name=recitation]").val($(this).text());

        var options = {
            action: "groups",
            recitation: $(this).text(),
            course: $(".course.active").text()
        };

        $(".recitation.active").removeClass("active");
        $(this).addClass("active");

        $.get("api.php", options, function(data) {
            for (var i = 0; i < data.length; i++) {
                $("#groups").append($("<button>")
                    .attr("type", "button")
                    .addClass("list-group-item")
                    .addClass("group")
                    .text(data[i]));
            }
        }, "json");

        options = {
            action: "get-selected-group",
            recitation: $(this).text(),
            course: $(".course.active").text(),
            student: $("#student").val()
        };

        $.get("api.php", options, function(group) {
            $(".group").each(function() {
                if ($(this).text() == group)
                    $(this).addClass("active");
            });
        }, "json");

        options = {
            action: "get-problems",
            recitation: $(this).text(),
            course: $(".course.active").text(),
            student: $("#student").val()
        };

        $.get("api.php", options, function(problems) {
            $("#solutions").children().remove();

            for (var i = 0; i < problems.length; i++) {
                var problem = problems[i];

                var checked = "";
                $("#solutions").append('<div class="checkbox"><label class="form-label" style="display: block;"><input type="checkbox" name="'+problem+'" '+checked+'> '+problem+'</label></div>');
            }
        }, "json");

    });

    $(document).on("click", ".group", function() {
        $(".group.active").removeClass("active");

        var options = {
            action: "select-group",
            group: $(this).text(),
            recitation: $(".recitation.active").text(),
            course: $(".course.active").text(),
            student: $("#student").val()
        };

        var that = $(this);

        $.get("api.php", options, function(data) {
            that.addClass("active");
        }, "json");

    });

    $("#submit-solutions").click(function() {
        var options = {
            action: "submit-solutions",
            recitation: $(this).text(),
            course: $(".course.active").text(),
            student: $("#student").val()
        };

        $.get("api.php", options, function(problems) {
            $("#solutions").children().remove();

            for (var i = 0; i < problems.length; i++) {
                var problem = problems[i];

                $("#solutions").append('<div class="checkbox"><label class="form-label" style="display: block;"><input type="checkbox" name="'+problem+'"> '+problem+'</label></div>');
            }
        }, "json");
    });

});