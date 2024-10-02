<!DOCTYPE html>
<html lang="en">
<x-head :title="'QuizTech - Results'" />
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
        font-family: 'Arial', sans-serif;
    }

    .quiz-container {
        max-width: 800px;
        margin: 2rem auto;
        padding: 2rem;
        background-color: white;
        border-radius: 15px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .quiz-header {
        background-color: var(--primary-color);
        color: white;
        padding: 1.5rem;
        border-radius: 10px;
        margin-bottom: 2rem;
        text-align: center;
    }

    .quiz-header h1 {
        margin: 0;
        font-size: 2rem;
    }

    .score-summary {
        display: flex;
        justify-content: space-around;
        background-color: var(--action);
        color: white;
        padding: 1rem;
        border-radius: 10px;
        margin-bottom: 2rem;
    }

    .score-item {
        text-align: center;
    }

    .score-item h2 {
        font-size: 1.5rem;
        margin: 0;
    }

    .score-item p {
        font-size: 2rem;
        font-weight: bold;
        margin: 0.5rem 0 0;
    }

    .question-container {
        background-color: var(--primary);
        border-radius: 10px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .question-result {
        font-size: 1.1rem;
        font-weight: bold;
        padding: 0.5rem 1rem;
        border-radius: 5px;
        margin-bottom: 1rem;
    }

    .correct {
        background-color: #4CAF50;
        color: white;
    }

    .incorrect {
        background-color: var(--tertiary);
        color: white;
    }

    .question-text {
        font-size: 1.2rem;
        margin-bottom: 1rem;
        color: var(--headingcolor);
    }

    .options-container {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
    }

    .option {
        padding: 0.8rem;
        border: 2px solid var(--secondary);
        border-radius: 5px;
        cursor: not-allowed;
        transition: all 0.3s ease;
    }

    .option.selected {
        background-color: var(--secondary);
        color: white;
    }

    .option.correct {
        background-color: #4CAF50;
        border-color: #4CAF50;
        color: white;
    }

    .option.incorrect {
        background-color: var(--tertiary);
        border-color: var(--tertiary);
        color: white;
    }
</style>

<body>
    <x-nav-bar-main :user="$user" />
    
    <div class="quiz-container">
        <div class="quiz-header">
            <h1>Quiz Results</h1>
        </div>

        @php
            $response = Session::get('response');
            $totalQuestions = count($quiz->questions);
            $correctAnswers = collect($response)->filter(function($answer) { return Str::startsWith($answer, 'Correct'); })->count();
        @endphp

        <div class="score-summary">
            <div class="score-item">
                <h2>Total Questions</h2>
                <p>{{ $totalQuestions }}</p>
            </div>
            <div class="score-item">
                <h2>Correct Answers</h2>
                <p>{{ $correctAnswers }}</p>
            </div>
            <div class="score-item">
                <h2>Score</h2>
                <p>{{ round(($correctAnswers / $totalQuestions) * 100) }}%</p>
            </div>
        </div>

        @foreach ($quiz->questions as $index => $question)
            <div class="question-container">
                @if (isset($response[$index]) && \Illuminate\Support\Str::startsWith($response[$index], 'Correct'))
                    <div class="question-result correct">Correct Answer!</div>
                @else
                    <div class="question-result incorrect">Incorrect Answer</div>
                @endif

                <div class="question-text">
                    <strong>Question {{ $index + 1 }}:</strong> {{ $question->ques }}
                </div>

                <div class="options-container">
                    @foreach ($question->options as $optionIndex => $option)
                        <div class="option {{ $option->opt === Session::get('inpt')[$question->id] ? 'selected' : '' }} 
                                    {{ $option->is_correct ? 'correct' : ($option->opt === Session::get('inpt')[$question->id] && !$option->is_correct ? 'incorrect' : '') }}">
                            {{ $option->opt }}
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</body>
</html>
