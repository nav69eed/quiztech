<!DOCTYPE html>
<html lang="en">
<x-head :title="'QuizTech | ALL QUIZZES'" />
<x-nav-bar-main :user="$user" />
<style>
    h1 {
        color: var(--headingcolor);
        font-weight: 700;
        margin-bottom: 2rem;
        position: relative;
        display: inline-block;
    }

    h1::after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 0;
        width: 50%;
        height: 4px;
        background-color: var(--tertiary);
    }

    .quiz-card {
        background-color: white;
        border: none;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .quiz-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
    }

    .card-body {
        padding: 1.5rem;
    }

    .card-title {
        color: var(--secondary);
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .card-subtitle {
        color: var(--tertiary);
        font-weight: 500;
        margin-bottom: 1rem;
    }

    .card-text {
        color: var(--tcolor);
        font-size: 0.9rem;
        margin-bottom: 1rem;
    }

    .badge {
        font-weight: 500;
        padding: 0.5em 1em;
        border-radius: 20px;
    }

    .card-footer {
        background-color: var(--primary);
        border-top: none;
        padding: 1rem 1.5rem;
    }

    .btn-start-quiz {
        background-color: var(--action);
        border: none;
        color: white;
        font-weight: 600;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        transition: all 0.3s ease;
    }

    .btn-start-quiz:hover {
        background-color: var(--tertiary);
        transform: scale(1.05);
    }

    .quiz-info {
        font-size: 0.8rem;
        color: var(--tcolor);
    }

    .quiz-info i {
        color: var(--secondary);
        margin-right: 0.25rem;
    }
</style>

<body>
    <div class="container py-5">
        <h1 class="text-center">Explore Our Quizzes</h1>
        <div id="quizList" class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <!-- Quiz cards will be dynamically inserted here -->
            @forelse ($quizzes as $index=>$quiz)
                <div class="col">
                    <div class="card h-100 quiz-card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $quiz->title }}</h5>
                            <h6 class="card-subtitle">Subject of Quiz</h6>
                            <p class="card-text">{{ $quiz->description }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="badge">fddfdf</span>
                                <span class="quiz-info"><i class="fas fa-question-circle"></i> 12 questions</span>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="quiz-info">
                                    <span><i class="fas fa-clock"></i>{{ $quiz->time_limit }} mins</span>
                                    <span class="ms-3"><i class="fas fa-users"></i> 23 participants</span>
                                </div>
                                <a href="{{ route('squiz', ['id' => $quiz->id]) }}">
                                    <button class="btn
                                    btn-start-quiz">Start
                                        Quiz</button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="my-3 p-4 shadow c-s">
                    No Quiz Yet
                </div>
            @endforelse
        </div>
    </div>
</body>

</html>
