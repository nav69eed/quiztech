<!DOCTYPE html>
<html lang="en">
<x-head :title="'QuizTech | Create Quiz'" />
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

    .navbar {
        background-color: var(--navbg);
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .navbar-brand {
        color: var(--primary-color);
        font-weight: bold;
    }

    h1,
    h2,
    h3 {
        color: var(--headingcolor);
    }

    .card {
        background-color: white;
        border-radius: 15px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease-in-out;
    }

    .card:hover {
        transform: translateY(-5px);
    }

    .btn-primary {
        background-color: var(--action);
        border-color: var(--action);
    }

    .btn-primary:hover {
        background-color: var(--tertiary);
        border-color: var(--tertiary);
    }

    .form-control:focus {
        border-color: var(--tertiary);
        box-shadow: 0 0 0 0.2rem rgba(177, 33, 102, 0.25);
    }

    .option-input {
        border-left: 3px solid var(--secondary);
    }

    .correct-answer {
        background-color: rgba(57, 21, 96, 0.1);
        border-radius: 5px;
    }

    #quizInfo {
        background-color: var(--secondary);
        color: white;
        padding: 20px;
        border-radius: 15px;
        margin-bottom: 20px;
    }
</style>

<body>
    <x-nav-bar-main :user="$user" />
        <div class="container mt-5">
            <h1 class="text-center mb-4">Create Your Quiz</h1>
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <h2 class="card-title mb-4">Add a New Question</h2>
                            <form id="questionForm" action="{{ route('createquestion') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="questionText" class="form-label">Question</label>
                                    <input type="text" class="form-control" name="ques" id="questionText"
                                        required>
                                </div>
                                <div id="optionsContainer">
                                    <div class="mb-3">
                                        <label class="form-label">Options</label>
                                        <div class="input-group mb-2">
                                            <input type="text" class="form-control option-input" name="opt1"
                                                required>
                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    <input type="radio" name="correct_option" value="1" required>
                                                    <!-- Change name to correct_option -->
                                                </div>
                                            </div>
                                        </div>
                                        <div class="input-group mb-2">
                                            <input type="text" class="form-control option-input" name="opt2"
                                                required>
                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    <input type="radio" name="correct_option" value="2" required>
                                                    <!-- Change name to correct_option -->
                                                </div>
                                            </div>
                                        </div>
                                        <div class="input-group mb-2">
                                            <input type="text" class="form-control option-input" name="opt3"
                                                required>
                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    <input type="radio" name="correct_option" value="3" required>
                                                    <!-- Change name to correct_option -->
                                                </div>
                                            </div>
                                        </div>
                                        <div class="input-group mb-2">
                                            <input type="text" class="form-control option-input" name="opt4"
                                                required>
                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    <input type="radio" name="correct_option" value="4" required>
                                                    <!-- Change name to correct_option -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Add Question</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center mt-5">
                <div class="col-md-8">
                    <h2 class="mb-3">Quiz Preview</h2>
                    <div id="quizInfo" class="mb-4"></div>
                    <div id="quizPreview">
                        @forelse ($quiz as $index=>$question )
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $index + 1 }}- {{ $question->ques }}</h5>
                                    <ol class="list-group list-group-flush">
                                        @forelse ($question->options as $opt)
                                            <li
                                                class="list-group-item 
                                        @if ($opt->result == 1) correct-answer @endif
                                        ">
                                                {{ $opt->opt }}
                                                @if ($opt->result == 1)
                                                    <span class="badge bg-success">Correct</span>
                                                @endif
                                            </li>
                                        @empty
                                            no options
                                        @endforelse
                                    </ol>
                                </div>
                            </div>
                        @empty
                            no question till
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
</body>

</html>
