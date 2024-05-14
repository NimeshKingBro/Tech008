<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tech008 User Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #eef1f5;
            margin: 0;
            padding: 0;
        }

        #user-details-section {
            background-color: #fff;
            border: 2px solid #4a69bd;
            padding: 20px;
            margin: 20px auto;
            max-width: 1200px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .user-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .user-header h1, .user-header h5 {
            color: #333;
            margin-bottom: 5px;
        }

        .content-panel {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .queries-panel, .responses-panel {
            width: 48%;
            background-color: #fff;
            border: 1px solid #ccc;
            padding: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .query-item, .response-item {
            background-color: #f7f7f7;
            border: 1px solid #ddd;
            padding: 10px;
            margin-top: 10px;
        }

        .query-title, .response-text {
            font-size: 18px;
            color: #2c3e50;
        }

        .verification-status {
            color: #27ae60;
            font-weight: bold;
        }

        .interaction-button {
            background-color: #4a69bd;
            color: red;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 10px;
        }

        .interaction-button:hover {
            background-color: #1e3799;
        }


    </style>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.13.1/underscore-min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/backbone.js/1.4.0/backbone-min.js"></script>
</head>
<body>
    <div id="user-details-section">
        <div class="user-header">
            <h1>User Profile</h1>
            <h5><?php echo $user['fName'] . ' ' . $user['LName']; ?></h5>
            <h5><?php echo $user['email'] ?></h5>
        </div>

        <div class="content-panel">
            <div class="queries-panel">
                <h3>Submitted Questions</h3>
                <?php foreach ($questions as $question): ?>
                    <div class="query-item" data-query-id="<?php echo $question['question_id']; ?>">
                        <h4 class="query-title"><?php echo $question['title']; ?></h4>
                        <p><?php echo $question['body']; ?></p>
                        <p><?php echo $question['answer_count']; ?> Answers, <?php echo $question['views']; ?> Views, Posted on <?php echo $question['Date_posted']; ?></p>
                        <button class="remove-query">Remove</button>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="responses-panel">
                <h3>Provided Answers</h3>
                <?php foreach ($answers as $answer): ?>
                    <div class="response-item" data-response-id="<?php echo $answer['answer_id']; ?>">
                        <p class="response-text"><?php echo $answer['body']; ?></p>
                        <p>Answered on <?php echo $answer['Date_answered']; ?></p>
                        <button class="remove-answer">Remove</button>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $(".remove-query").click(function () {
                var queryBlock = $(this).closest(".query-item");
                var queryId = queryBlock.data("query-id");
                $.ajax({
                    url: "<?php echo site_url('profile/delete_question'); ?>/" + queryId,
                    type: "DELETE",
                    success: function (response) {
                        queryBlock.remove();
                    }
                });
            });

            $(".remove-answer").click(function () {
                var responseBlock = $(this).closest(".response-item");
                var responseId = responseBlock.data("response-id");
                $.ajax({
                    url: "<?php echo site_url('profile/delete_answer'); ?>/" + responseId,
                    type: "DELETE",
                    success: function (response) {
                        responseBlock.remove();
                    }
                });
            });
        });
    </script>
</body>
</html>
