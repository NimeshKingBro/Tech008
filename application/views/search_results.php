<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results Tech008</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f4f8;
        }

        .search-results-section {
            background-color: #ffffff;
            border: 1px solid #ccc;
            padding: 20px;
            margin: 20px auto;
            max-width: 800px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .result {
            border-bottom: 1px solid #eee;
            padding: 15px;
            margin-top: 10px;
        }

        .result:last-child {
            border-bottom: none;
        }

        .result-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .result-title {
            font-size: 18px;
            color: #333;
        }

        .result-content {
            color: #666;
        }

        .result-footer {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
            font-size: 14px;
            color: #999;
        }

        h2 {
            color: #333;
            margin-bottom: 20px;
        }

        a {
            text-decoration: none;
            color: #007BFF;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="search-results-section">
        <h2>Search Results for "<?php echo htmlspecialchars($searchedFor, ENT_QUOTES, 'UTF-8'); ?>"</h2>

        <?php if (empty($results)): ?>
            <p>No results found.</p>
        <?php else: ?>
            <?php foreach ($results as $result): ?>
                <div class="result">
                    <h3 class="result-title">
                        <a href="<?php echo site_url('questions/question_info/' . $result['question_id']); ?>">
                            <?php echo htmlspecialchars($result['title'], ENT_QUOTES, 'UTF-8'); ?>
                        </a>
                    </h3>
                    <p class="result-content"><?php echo nl2br(htmlspecialchars($result['body'], ENT_QUOTES, 'UTF-8')); ?></p>
                    <div class="result-footer">
                        <span class="answers"><?php echo $result['answers']; ?> Answers</span>
                        <span class="views"><?php echo $result['views']; ?> Views</span>
                        <span class="votes"><?php echo $result['votes']; ?> Votes</span>
                        <span class="posted-date">Posted on: <?php echo $result['Date_posted']; ?></span>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</body>
</html>
