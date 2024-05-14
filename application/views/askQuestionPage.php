<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Question</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #e7eff6;
            margin: 0;
            padding: 0;
        }
        .main-content {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        #submissionForm {
            background-color: #ffffff;
            width: calc(100% - 40px);
            max-width: 600px;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 6px 10px rgba(0, 0, 0, 0.1);
            border: 1px solid #accbee;
        }
        h2 {
            text-align: center;
            color: #205081;
            margin-bottom: 20px;
        }
        .input-field {
            margin-bottom: 20px;
        }
        label {
            display: block;
            font-size: 16px;
            color: #205081;
            margin-bottom: 8px;
        }
        input[type="text"],
        textarea,
        input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-top: 4px;
            border: 1px solid #accbee;
            border-radius: 4px;
            font-size: 14px;
            background-color: #f4f8fb;
        }
        textarea {
            height: 150px;
            resize: vertical;
        }
        .action-buttons {
            display: flex;
            justify-content: space-between;
        }
        button,
        input[type="submit"] {
            flex-grow: 1;
            padding: 10px 20px;
            margin: 5px;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            background-color: #4a69bd;
            color: white;
            transition: background-color 0.3s;
        }
        button:hover,
        input[type="submit"]:hover {
            background-color: #1e3799;
        }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.13.1/underscore-min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/backbone.js/1.4.0/backbone-min.js"></script>
</head>
<body>
<div class="main-content">
    <form id="submissionForm">
        <div id="alert" style="display: none; color: green;"></div>
        <h2>Post Question</h2>
        <div class="input-field">
            <label for="questionTitle">Question Title</label>
            <input type="text" id="questionTitle" name="title" placeholder="Enter your question title" required>
        </div>
        <div class="input-field">
            <label for="questionDescription">Question Description</label>
            <textarea name="body" id="questionDescription" placeholder="Describe your question" required></textarea>
        </div>
        <div class="input-field">
            <label for="uploadImage">Upload Image (optional)</label>
            <input type="file" id="uploadImage" name="image">
        </div>
        <div class="input-field">
            <label for="questionTags">Tags (comma separated)</label>
            <input type="text" id="questionTags" name="tags" placeholder="e.g., HTML, CSS, JavaScript" required>
        </div>
        <div class="action-buttons">
            <button type="reset">Clear All</button>
            <input type="submit" value="Submit Question">
        </div>
    </form>
</div>

<script>
    var InquiryView = Backbone.View.extend({
        el: '#submissionForm',
        events: {
            'submit': 'processInquiry'
        },
        processInquiry: function(event) {
            event.preventDefault();
            var inquiryData = new FormData(this.el);
            $.ajax({
                url: 'http://localhost/Tech008/index.php/Questions/add_question_test', // Ensure this matches your server URL
                type: 'POST',
                data: inquiryData,
                processData: false,
                contentType: false,
                success: function(response) {
                    var alertMessage = response.condition === 'A' ? 'Successfully submitted your inquiry!' : 'Submission failed. Please try again.';
                    var messageColor = response.condition === 'A' ? 'green' : 'red';
                    $('#alert').text(alertMessage).css('color', messageColor).show();
                    setTimeout(function() { $('#alert').hide(); }, 6000);
                },
                error: function() {
                    console.error('Error processing the inquiry.');
                    $('#alert').text('Error processing the inquiry.').css('color', 'red').show();
                    setTimeout(function() { $('#alert').hide(); }, 6000);
                }
            });
        }
    });

    var inquiryView = new InquiryView();
</script>
</body>
</html>
