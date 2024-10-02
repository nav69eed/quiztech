<!DOCTYPE html>
<html lang="en">
<x-head :title="'QuizTech'" />
<style>
    :root {
        --primary-color: #391560;
        --primary: #F0F3F8;
        --secondary: #391560;
        --tertiary: #b12166;
        --action: #f77f00;
        --navbg: rgba(255, 255, 255, 1);
        --fontcolor: black;
        --tcolor: rgba(17, 24, 39, 1);
        --headingcolor: rgb(7, 10, 17);
    }

    body {
        background-color: var(--primary);
        color: var(--fontcolor);
        font-family: Arial, sans-serif;
    }

    .quiz-container {
        background-color: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    }

    .quiz-header {
        background-color: var(--secondary);
        color: white;
        padding: 20px;
    }

    .quiz-body {
        padding: 30px;
    }

    .btn-option {
        background-color: var(--primary);
        color: var(--secondary);
        border: none;
        transition: all 0.3s ease;
    }

    .btn-option:hover,
    .btn-option:focus {
        background-color: var(--secondary);
        color: white;
    }

    .btn-option.selected {
        background-color: var(--tertiary);
        color: white;
    }

    .btn-action {
        background-color: var(--action);
        color: white;
        border: none;
    }

    .btn-action:hover,
    .btn-action:focus {
        background-color: var(--tertiary);
    }

    .progress {
        height: 10px;
        margin-bottom: 20px;
    }

    .progress-bar {
        background-color: var(--tertiary);
    }

    #timer {
        font-size: 1.5rem;
        font-weight: bold;
        color: var(--action);
        text-align: center;
        margin-bottom: 15px;
    }
</style>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="quiz-container">
                    <div class="quiz-header">
                        <h1 class="text-center mb-3">{{ $quiz->title }}</h1>
                        <div id="timer">Time Left: {{ $quiz->time_limit }}:00</div>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0"
                                aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <h2 id="question-number" class="text-center">Question 1 of {{ $quiz->questions->count() }}</h2>
                    </div>
                    <form id="quiz-form" action="{{ route('quizsubmit', ['id' => $quiz->id]) }}" method="POST">
                        @csrf
                        <div class="quiz-body">
                            <h3 id="question-text" class="mb-4"></h3>
                            <div id="options" class="d-grid gap-3">
                                <!-- Options will be dynamically inserted here -->
                            </div>
                        </div>
                        <div class="quiz-footer p-4 bg-light d-flex justify-content-between">
                            <button type="button" id="prev-btn" class="btn btn-action">Previous</button>
                            <button type="button" id="next-btn" class="btn btn-action">Next</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const questions = @json($quiz->questions);
        let currentQuestion = 0;
        const userAnswers = {};
        let timer;
        let timeLeft = {{ $quiz->time_limit }} * 60; // Convert minutes to seconds

        const questionText = document.getElementById('question-text');
        const optionsContainer = document.getElementById('options');
        const prevBtn = document.getElementById('prev-btn');
        const nextBtn = document.getElementById('next-btn');
        const questionNumber = document.getElementById('question-number');
        const progressBar = document.querySelector('.progress-bar');
        const timerDisplay = document.getElementById('timer');

        function loadQuestion() {
            const question = questions[currentQuestion];
            questionText.textContent = question.ques;
            questionNumber.textContent = `Question ${currentQuestion + 1} of ${questions.length}`;

            optionsContainer.innerHTML = '';
            question.options.forEach((option, index) => {
                const button = document.createElement('button');
                button.textContent = option.opt;
                button.classList.add('btn', 'btn-option', 'btn-lg');
                button.type = 'button';
                if (userAnswers[question.id] === option.opt) {
                    button.classList.add('selected');
                }
                button.addEventListener('click', () => selectOption(question.id, option.opt));
                optionsContainer.appendChild(button);
            });

            updateButtons();
            updateProgressBar();
        }

        function selectOption(questionId, option) {
            userAnswers[questionId] = option;
            document.querySelectorAll('.btn-option').forEach(btn => {
                btn.classList.remove('selected');
                if (btn.textContent === option) {
                    btn.classList.add('selected');
                }
            });
        }

        function updateButtons() {
            prevBtn.disabled = currentQuestion === 0;
            if (currentQuestion === questions.length - 1) {
                nextBtn.textContent = 'Submit';
            } else {
                nextBtn.textContent = 'Next';
            }
        }

        function updateProgressBar() {
            const progress = ((currentQuestion + 1) / questions.length) * 100;
            progressBar.style.width = `${progress}%`;
            progressBar.setAttribute('aria-valuenow', progress);
        }

        function startTimer() {
            timer = setInterval(() => {
                timeLeft--;
                updateTimerDisplay();
                if (timeLeft <= 0) {
                    clearInterval(timer);
                    submitQuiz();
                }
            }, 1000);
        }

        function updateTimerDisplay() {
            const minutes = Math.floor(timeLeft / 60);
            const seconds = timeLeft % 60;
            timerDisplay.textContent = `Time Left: ${minutes}:${seconds.toString().padStart(2, '0')}`;
            if (timeLeft <= 60) {
                timerDisplay.style.color = 'red';
            } else {
                timerDisplay.style.color = 'var(--action)';
            }
        }

        function moveToNextQuestion() {
            if (currentQuestion < questions.length - 1) {
                currentQuestion++;
                loadQuestion();
            } else {
                submitQuiz();
            }
        }

        prevBtn.addEventListener('click', () => {
            if (currentQuestion > 0) {
                currentQuestion--;
                loadQuestion();
            }
        });

        nextBtn.addEventListener('click', moveToNextQuestion);

        function submitQuiz() {
            clearInterval(timer);
            const form = document.getElementById('quiz-form');
            
            // Add hidden inputs for each answer
            for (const [questionId, answer] of Object.entries(userAnswers)) {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = questionId;
                input.value = answer;
                form.appendChild(input);
            }

            form.submit();
        }

        loadQuestion();
        startTimer();
    </script>
</body>

</html>