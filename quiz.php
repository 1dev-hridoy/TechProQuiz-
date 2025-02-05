<?php
require_once 'config.php';
session_start();

// Get quiz parameters
$category = $_GET['category'] ?? 'linux';
$difficulty = $_GET['difficulty'] ?? 'easy';
$limit = min((int)($_GET['limit'] ?? 5), 20);

// Fetch questions from API
$url = "https://quizapi.io/api/v1/questions?apiKey=" . QUIZ_API_KEY . 
       "&category={$category}&difficulty={$difficulty}&limit={$limit}";

$ch = curl_init($url);
setCommonCurlOptions($ch);
$response = curl_exec($ch);

if(curl_errno($ch)) {
    die('<div class="container mt-5"><div class="alert alert-danger">Error: ' . curl_error($ch) . '</div></div>');
}

$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

$questions = json_decode($response, true);

if ($httpCode !== 200 || !is_array($questions)) {
    die('<div class="container mt-5"><div class="alert alert-danger">Error: Unable to fetch questions.</div></div>');
}

$_SESSION['quiz_questions'] = $questions;
$_SESSION['quiz_start_time'] = time();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz in Progress</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="floating-user">
        <i class="fas fa-user"></i> <?php echo htmlspecialchars(USER_LOGIN); ?>
    </div>

    <div class="container py-5 quiz-container">
        <div class="timer" id="timer">Time: 00:00</div>
        
        <div class="progress-container">
            <div class="progress-bar" id="progressBar" style="width: 0%"></div>
        </div>

        <?php if (empty($questions)): ?>
            <div class="alert alert-danger fade-in">
                No questions available. Please try again.
                <br>
                <a href="index.php" class="btn btn-primary mt-3">Back to Home</a>
            </div>
        <?php else: ?>
            <form action="results.php" method="POST" id="quizForm">
                <?php foreach($questions as $index => $question): ?>
                    <div class="card quiz-card slide-in" style="animation-delay: <?php echo $index * 0.1; ?>s">
                        <div class="card-body">
                            <h5 class="card-title">
                                <i class="fas fa-question-circle"></i> 
                                Question <?php echo $index + 1; ?> of <?php echo count($questions); ?>
                            </h5>
                            <p class="card-text"><?php echo htmlspecialchars($question['question']); ?></p>
                            
                            <div class="answers">
                                <?php foreach($question['answers'] as $key => $answer): ?>
                                    <?php if($answer): ?>
                                        <div class="answer-option" onclick="selectAnswer(this, '<?php echo $index; ?>', '<?php echo $key; ?>')">
                                            <input type="radio" name="answers[<?php echo $index; ?>]" 
                                                   id="<?php echo $index . '_' . $key; ?>" 
                                                   value="<?php echo $key; ?>" required style="display: none;">
                                            <label for="<?php echo $index . '_' . $key; ?>">
                                                <?php echo htmlspecialchars($answer); ?>
                                            </label>
                                        </div>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
                
                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary btn-lg bounce">
                        <i class="fas fa-check-circle"></i> Submit Quiz
                    </button>
                </div>
            </form>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Timer functionality
        const startTime = <?php echo time() * 1000; ?>;
        function updateTimer() {
            const now = new Date().getTime();
            const timeDiff = Math.floor((now - startTime) / 1000);
            const minutes = Math.floor(timeDiff / 60);
            const seconds = timeDiff % 60;
            document.getElementById('timer').innerHTML = 
                `<i class="fas fa-clock"></i> Time: ${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
        }
        setInterval(updateTimer, 1000);

        // Progress bar functionality
        const totalQuestions = <?php echo count($questions); ?>;
        let answeredQuestions = 0;

        function updateProgress() {
            const progress = (answeredQuestions / totalQuestions) * 100;
            const progressBar = document.getElementById('progressBar');
            progressBar.style.width = `${progress}%`;
            progressBar.setAttribute('aria-valuenow', progress);
        }

        // Answer selection functionality
        function selectAnswer(element, questionIndex, answerKey) {
            // Remove selected class from all options in this question
            const questionAnswers = element.parentElement.getElementsByClassName('answer-option');
            Array.from(questionAnswers).forEach(answer => {
                answer.classList.remove('selected');
            });

            // Add selected class to clicked option
            element.classList.add('selected');
            
            // Select the radio button
            const radio = element.querySelector('input[type="radio"]');
            radio.checked = true;

            // Play selection sound
            playSelectSound();

            // Update progress if this question wasn't answered before
            if (!element.parentElement.hasAttribute('data-answered')) {
                element.parentElement.setAttribute('data-answered', 'true');
                answeredQuestions++;
                updateProgress();
            }

            // Add animation
            element.classList.add('bounce');
            setTimeout(() => {
                element.classList.remove('bounce');
            }, 500);
        }

// Sound effects
function playSelectSound() {
            const audio = new Audio("data:audio/mpeg;base64,SUQzBAAAAAAAI1RTU0UAAAAPAAADTGF2ZjU4LjI5LjEwMAAAAAAAAAAAAAAA//tUAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAWGluZwAAAA8AAAACAAADQABISEhISEhISEhISEhISEhISEhISEhISEhISEhISEhISEhISEhISEhISEhISEhISEhI//////////////////////////////////////////////////////////////////8AAAAATGF2YzU4LjU0AAAAAAAAAAAAAAAAJAAAAAAAAAAAAwBAiFrqAAAAAAAA//tUZAAP8AAAaQAAAAgAAA0gAAABAAABpAAAACAAADSAAAAETEFNRTMuMTAwVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVV");
            audio.volume = 0.2;
            audio.play();
        }

        // Form submission with animations
        document.getElementById('quizForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Check if all questions are answered
            if (answeredQuestions < totalQuestions) {
                showAlert('Please answer all questions before submitting!');
                return;
            }

            // Add submission animation
            const submitBtn = this.querySelector('button[type="submit"]');
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Submitting...';
            submitBtn.disabled = true;

            // Create confetti effect
            createConfetti();

            // Submit form after animations
            setTimeout(() => this.submit(), 1500);
        });

        // Create confetti effect
        function createConfetti() {
            for (let i = 0; i < 50; i++) {
                const confetti = document.createElement('div');
                confetti.className = 'confetti';
                confetti.style.left = Math.random() * 100 + 'vw';
                confetti.style.animationDelay = Math.random() * 3 + 's';
                confetti.style.backgroundColor = getRandomColor();
                document.body.appendChild(confetti);
                
                // Remove confetti after animation
                setTimeout(() => confetti.remove(), 3000);
            }
        }

        // Get random color for confetti
        function getRandomColor() {
            const colors = ['#ff0000', '#00ff00', '#0000ff', '#ffff00', '#ff00ff', '#00ffff'];
            return colors[Math.floor(Math.random() * colors.length)];
        }

        // Show alert message
        function showAlert(message) {
            const alertDiv = document.createElement('div');
            alertDiv.className = 'alert alert-warning alert-dismissible fade show';
            alertDiv.innerHTML = `
                <i class="fas fa-exclamation-triangle"></i> ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            document.querySelector('.quiz-container').insertBefore(alertDiv, document.querySelector('.card'));
            
            // Remove alert after 3 seconds
            setTimeout(() => alertDiv.remove(), 3000);
        }

        // Add keyboard navigation
        document.addEventListener('keydown', function(e) {
            if (e.key >= '1' && e.key <= '4') {
                const currentQuestion = document.querySelector('.card:not([data-answered])');
                if (currentQuestion) {
                    const options = currentQuestion.querySelectorAll('.answer-option');
                    const index = parseInt(e.key) - 1;
                    if (options[index]) {
                        options[index].click();
                    }
                }
            }
        });

        // Add smooth scroll to next unanswered question
        function scrollToNextUnanswered() {
            const unanswered = document.querySelector('.card:not([data-answered])');
            if (unanswered) {
                unanswered.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        }

        // Initialize tooltips
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Add current time display
        const timeElement = document.createElement('div');
        timeElement.className = 'floating-time';
        timeElement.innerHTML = `<i class="fas fa-globe"></i> UTC: <?php echo date('Y-m-d H:i:s'); ?>`;
        document.body.appendChild(timeElement);

        // Show welcome message
        const welcome = document.createElement('div');
        welcome.className = 'welcome-message fade-in';
        welcome.innerHTML = `
            <h3>Welcome, <?php echo htmlspecialchars(USER_LOGIN); ?>!</h3>
            <p>Good luck with your quiz!</p>
        `;
        document.querySelector('.quiz-container').insertBefore(welcome, document.querySelector('.timer'));
        setTimeout(() => welcome.remove(), 3000);
    </script>
    </body>
    </html>