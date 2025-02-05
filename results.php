<?php
session_start();

// Get submitted answers and questions from session
$submitted_answers = $_POST['answers'] ?? [];
$questions = $_SESSION['quiz_questions'] ?? [];

$total_questions = count($questions);
$correct_answers = 0;

// Calculate score
foreach ($submitted_answers as $index => $submitted_answer) {
    if (isset($questions[$index]['correct_answers'])) {
        $correct_key = 'answer_' . $submitted_answer . '_correct';
        if (isset($questions[$index]['correct_answers'][$correct_key]) && 
            $questions[$index]['correct_answers'][$correct_key] === 'true') {
            $correct_answers++;
        }
    }
}

$percentage = ($total_questions > 0) ? round(($correct_answers / $total_questions) * 100, 2) : 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Results</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container py-5">
        <h1 class="text-center mb-4">Quiz Results</h1>
        
        <div class="card mb-4">
            <div class="card-body text-center">
                <h3>Your Score</h3>
                <p class="display-4"><?php echo $correct_answers; ?> / <?php echo $total_questions; ?></p>
                <p class="lead">Percentage: <?php echo $percentage; ?>%</p>
                
                <?php
                $message = '';
                if ($percentage >= 90) $message = 'Excellent! Outstanding performance!';
                elseif ($percentage >= 70) $message = 'Good job! Well done!';
                elseif ($percentage >= 50) $message = 'Not bad! Keep practicing!';
                else $message = 'Keep learning! You can do better!';
                ?>
                
                <p class="alert alert-info"><?php echo $message; ?></p>
                <a href="index.php" class="btn btn-primary">Take Another Quiz</a>
            </div>
        </div>

        <h2 class="mb-4">Detailed Results</h2>
        <?php foreach($questions as $index => $question): ?>
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Question <?php echo $index + 1; ?></h5>
                    <p class="card-text"><?php echo htmlspecialchars($question['question']); ?></p>
                    
                    <?php
                    $user_answer = $submitted_answers[$index] ?? '';
                    $is_correct = false;
                    
                    if (isset($question['correct_answers'])) {
                        $correct_key = 'answer_' . $user_answer . '_correct';
                        $is_correct = ($question['correct_answers'][$correct_key] ?? '') === 'true';
                    }
                    ?>
                    
                    <div class="alert <?php echo $is_correct ? 'alert-success' : 'alert-danger'; ?>">
                        <strong><?php echo $is_correct ? 'Correct!' : 'Incorrect!'; ?></strong>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>