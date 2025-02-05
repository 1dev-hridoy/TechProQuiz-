<?php
require_once 'config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interactive Tech Quiz</title>
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
        <h1 class="text-center mb-4 fade-in">
            <i class="fas fa-laptop-code"></i> Tech Quiz Challenge
        </h1>
        
        <div class="card quiz-card slide-in">
            <div class="card-body">
                <form action="quiz.php" method="GET" id="quizForm">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="category" class="form-label">
                                    <i class="fas fa-folder"></i> Category
                                </label>
                                <select name="category" id="category" class="form-select" required>
                                    <option value="linux">Linux</option>
                                    <option value="bash">Bash</option>
                                    <option value="docker">Docker</option>
                                    <option value="sql">SQL</option>
                                    <option value="cms">CMS</option>
                                    <option value="code">Code</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="difficulty" class="form-label">
                                    <i class="fas fa-signal"></i> Difficulty
                                </label>
                                <select name="difficulty" id="difficulty" class="form-select" required>
                                    <option value="easy">Easy</option>
                                    <option value="medium">Medium</option>
                                    <option value="hard">Hard</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="limit" class="form-label">
                                    <i class="fas fa-list-ol"></i> Number of Questions
                                </label>
                                <input type="number" name="limit" id="limit" class="form-control" min="1" max="20" value="5" required>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary btn-lg bounce">
                            <i class="fas fa-play"></i> Start Quiz
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card quiz-card slide-in" style="margin-top: 30px;">
            <div class="card-body">
                <h5 class="card-title">
                    <i class="fas fa-trophy"></i> Your Statistics
                </h5>
                <div class="row text-center">
                    <div class="col-md-4">
                        <div class="stat-box">
                            <i class="fas fa-check-circle fa-2x text-success"></i>
                            <h3>0</h3>
                            <p>Quizzes Completed</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stat-box">
                            <i class="fas fa-star fa-2x text-warning"></i>
                            <h3>0%</h3>
                            <p>Average Score</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stat-box">
                            <i class="fas fa-medal fa-2x text-info"></i>
                            <h3>0</h3>
                            <p>Best Score</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Add hover effect to stat boxes
            const statBoxes = document.querySelectorAll('.stat-box');
            statBoxes.forEach(box => {
                box.addEventListener('mouseenter', () => {
                    box.classList.add('bounce');
                });
                box.addEventListener('mouseleave', () => {
                    box.classList.remove('bounce');
                });
            });

            // Form validation with animation
            const form = document.getElementById('quizForm');
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                const button = form.querySelector('button[type="submit"]');
                button.classList.add('bounce');
                setTimeout(() => form.submit(), 300);
            });
        });
    </script>
</body>
</html>