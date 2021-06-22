
        function getStandardByBoard() {
            var board_id = $("#board_id").val();
            $.post("ajax.php", {
                getStandardByBoard: 'getStandardByBoard',
                board_id: board_id
            }, function(data) {
                $("#standard_id").html(data);
            });
        }

        function getSubjectByStandard() {
            var board_id = $("#board_id").val();
			var board = $("#board_id option:selected").html();
            var standard_id = $("#standard_id").val();
			var standard = $("#standard_id option:selected").html();
            $.post("ajax.php", {
                getSubjectByStandard: 'getSubjectByStandard',
                board_id: board_id,
                board: board,
                standard_id: standard_id,
                standard: standard
            }, function(data) {
                $("#subject_id").html(data);
            });
        }

        function getChapterBySubject() {
            var board_id = $("#board_id").val();
			var board = $("#board_id option:selected").html();
            var standard_id = $("#standard_id").val();
			var standard = $("#standard_id option:selected").html();
            var subject_id = $("#subject_id").val();
			var subject = $("#subject_id option:selected").html();
            $.post("ajax.php", {
                getChapterBySubject: 'getChapterBySubject',
                board_id: board_id,
                board: board,
                standard_id: standard_id,
                standard: standard,
                subject_id: subject_id,
                subject: subject
            }, function(data) {
                $(".response").html(data);
            });
        }