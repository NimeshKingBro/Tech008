<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Question Details Tech008</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            background-color: #fafafa;
            margin: 0;
            padding: 0;
        }

        .question-container, .answers-container, .submit-answer-section {
            background-color: #ffffff;
            padding: 25px;
            margin: 25px auto;
            max-width: 850px;
            border: 1px solid #e1e1e1;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.12);
        }

        h1, h2 {
            color: #4a4a4a;
        }

        .question-container img {
            width: 100%;
            height: auto;
            border-radius: 8px;
            margin-top: 20px;
        }

        .answer-item {
            border-top: 1px solid #f0f0f0;
            padding-top: 20px;
            margin-top: 20px;
        }

        .input-field {
            margin-bottom: 25px;
        }

        .input-field label {
            display: block;
            margin-bottom: 10px;
        }

        .input-field textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #d7d7d7;
            border-radius: 6px;
            resize: vertical;
            box-sizing: border-box;
        }

        .submit-button {
            background-color: #007bff;
            color: #ffffff;
            padding: 12px 18px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
        }

        .submit-button:hover {
            background-color: #0056b3;
        }

        .notification {
            color: green;
            margin: 10px 20px;
            text-align: center;
            display: none;
        }
    </style>
</head>
<body>
<div class="question-container">
    <div class="voting-controls">
        <button onclick="voteQuestion(<?= $question['question_id'] ?>, 'up')">👍 Upvote</button>
        <span id="vote-count"><?= $question['votes'] ?></span>
        <button onclick="voteQuestion(<?= $question['question_id'] ?>, 'down')">👎 Downvote</button>
    </div>
    <h1><?= htmlspecialchars($question['title'], ENT_QUOTES, 'UTF-8') ?></h1>
    <p>Asked by: <?= htmlspecialchars($question['fName'] . ' ' . $question['LName'], ENT_QUOTES, 'UTF-8') ?></p>
    <p><?= nl2br(htmlspecialchars($question['body'], ENT_QUOTES, 'UTF-8')) ?></p>
    <?php if (!empty($question['image'])): ?>
        <img src="<?= base_url($question['image']) ?>" alt="Detailed Image">
    <?php endif; ?>
</div>

<section class="answers-container">
    <h2>Responses</h2>
    <?php foreach ($answers as $answer): ?>
        <article class="answer-item">
            <div class="voting-controls">
                <button onclick="voteAnswer(<?= $answer['answer_id'] ?>, 'up')">👍 Upvote</button>
                <span id="vote-count-<?= $answer['answer_id'] ?>"><?= $answer['votes'] ?></span>
                <button onclick="voteAnswer(<?= $answer['answer_id'] ?>, 'down')">👎 Downvote</button>
            </div>
            <p>Answered by: <?= htmlspecialchars($answer['fName'] . ' ' . $answer['LName'], ENT_QUOTES, 'UTF-8') ?></p>
            <p><?= nl2br(htmlspecialchars($answer['body'], ENT_QUOTES, 'UTF-8')) ?></p>
        </article>
    <?php endforeach; ?>
</section>

<div class="notification" id="answer-notification"></div>

<section class="submit-answer-section">
    <h2>Provide Your Answer</h2>
    <form id="submitAnswerForm">
        <div class="input-field">
            <label for="response-text">Your Answer:</label>
            <textarea id="response-text" name="body" rows="6" required></textarea>
        </div>
        <input type="hidden" name="question_id" value="<?= $question['question_id'] ?>" />
        <button type="submit" class="submit-button">Submit Your Answer</button>
    </form>
</section>

<script>
    document.getElementById('submitAnswerForm').onsubmit = function(event) {
        event.preventDefault();
        var formData = new FormData(this);
        var messageBox = document.getElementById('answer-notification');

        fetch('<?= site_url('answers/add_answer') ?>', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            messageBox.textContent = data.message;
            messageBox.style.display = 'block';
            if (data.status === 'success') {
                messageBox.style.color = 'green';
            } else {
                messageBox.style.color = 'red';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            messageBox.textContent = 'Error posting answer.';
            messageBox.style.display = 'block';
            messageBox.style.color = 'red';
        });
    };

    function voteQuestion(questionId, direction) {
        fetch(`<?= site_url('questions/change_vote_question/') ?>${questionId}/${direction}`, {
            method: 'POST'
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
            document.getElementById('vote-count').textContent = data.newVoteCount;
        })
        .catch(error => console.error('Error:', error));
    }

    function voteAnswer(answerId, direction) {
        fetch(`<?= site_url('answers/change_vote_answer/') ?>${answerId}/${direction}`, {
            method: 'POST'
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
            document.getElementById('vote-count-' + answerId).textContent = data.newVoteCount;
        })
        .catch(error => console.error('Error:', error));
    }
</script>
</body>
</html>
