# Interactive Tech Quiz Application 🚀

A modern, interactive quiz application built with PHP, Bootstrap, and JavaScript that uses the QuizAPI.io service to generate technical questions across various programming topics.

## Features 🌟

- **Multiple Technical Categories**
  - Linux
  - Docker
  - SQL
  - CMS
  - Code
  - DevOps
  - Bash

- **Interactive UI Elements**
  - Real-time progress tracking
  - Dynamic timer
  - Animated transitions
  - Sound effects
  - Confetti celebration on completion

- **Difficulty Levels**
  - Easy
  - Medium
  - Hard

- **User-Friendly Features**
  - Keyboard navigation (1-4 keys)
  - Progress saving
  - Instant feedback
  - Responsive design

## Prerequisites 🔧

- PHP 7.4 or higher
- Web server (Apache/Nginx)
- QuizAPI.io API key
- Modern web browser
- Internet connection

## Installation ⚙️

1. Clone the repository:
   ```bash
   git clone https://github.com/1dev-hridoy/TechProQuiz-.git
   ```

2. Navigate to the project directory:
   ```bash
   cd tech-quiz-app
   ```

3. Create a config.php file with your API key:
   ```php
   <?php
   define('QUIZ_API_KEY', 'YOUR_API_KEY_HERE');
   ```

4. Configure your web server to serve the application.

## Project Structure 📦

```
tech-quiz-app/
│
├── config.php          # Configuration file
├── index.php          # Home page
├── quiz.php           # Quiz interface
├── results.php        # Results display
├── style.css          # Styling
│
├── screenshots/       # Screenshots directory
│   ├── home.png
│   ├── quiz-interface.png
│   └── results.png
│
└── README.md         # Documentation
```

## User Interface 🎨

### Home Page
- Category selection
- Difficulty settings
- Question count configuration

### Quiz Interface
- Real-time progress tracking
- Dynamic timer
- Interactive answer selection

### Results Page
- Detailed score breakdown
- Correct answer review
- Performance statistics

## Latest Updates 🚀
*Last Updated: 2025-02-05*

- Added confetti animation on quiz completion
- Implemented keyboard navigation
- Enhanced UI responsiveness
- Added sound effects
- Improved error handling

## Usage 💻

1. Access the application through your web browser
2. Select your preferred category and difficulty
3. Choose the number of questions
4. Start the quiz
5. Answer questions within the time limit
6. Submit to see your results

## Security Features 🔒

- XSS protection
- CSRF prevention
- Input validation
- Secure API key storage

## Contributing 🤝

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## License 📝

This project is licensed under the MIT License - see the LICENSE file for details.

## Author 👨‍💻

**Hridoy**
- GitHub: [@hridoy09bg](https://github.com/hridoy09bg)

## Acknowledgments 🙏

- QuizAPI.io for providing the quiz questions
- Bootstrap for the UI framework
- Font Awesome for icons

## Screenshots 📸

![home](https://i.ibb.co.com/5Q7Vn3B/Screenshot-2025-02-05-125023.png)

![quiz](https://i.ibb.co.com/x8wqrR91/Screenshot-2025-02-05-125044.png)

![results ](https://i.ibb.co.com/bj4FQYc4/Screenshot-2025-02-05-125110.png)