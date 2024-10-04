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
                <div class="card mb-4">
                    <div class="card-body">
                        <h2 class="card-title mb-4">Quiz Information</h2>
                        <form id="quizInfoForm" action="{{ route('createquiz') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="quizName" class="form-label">Quiz Name</label>
                                <input type="text" class="form-control" name="quizName" id="quizName" required>
                            </div>
                            <div class="mb-3">
                                <label for="quizSubject" class="form-label">Subject</label>
                                <input type="text" class="form-control" name="quizSubject" id="quizSubject" required>
                            </div>
                            <div class="mb-3">
                                <label for="quizDescription" class="form-label">Description</label>
                                <textarea class="form-control" name="quizDescription" id="quizDescription" rows="3" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="quizTimeLimit" class="form-label">Time Limit (minutes)</label>
                                <input type="number" class="form-control" name="quizTimeLimit" id="quizTimeLimit"
                                    min="1" required>
                            </div>
                            <div class="mb-3">
                                <label for="due_datetime" class="form-label">Due Date and Time</label>
                                <input type="datetime-local" class="form-control" name="due_datetime" id="due_datetime" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Save Quiz Info</button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</body>

</html>
