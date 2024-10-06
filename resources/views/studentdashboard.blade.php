<!DOCTYPE html>
<html lang="en">
<x-head :title="'QuizTech | Dashboard'" />
<link rel="stylesheet" href="{{ asset('webassets/css/studentdashboard.css') }}">

<body>
    <x-nav-bar-main :user="$user" />
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 d-md-block sidebar">
                <div class="position-sticky">
                    <h2 class="text-center text-white mb-4">QuizMaster</h2>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="#">
                                <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-book me-2"></i> My Courses
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-tasks me-2"></i> Assignments
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-chart-bar me-2"></i> Progress
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-cog me-2"></i> Settings
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 main-content">
                <div
                    class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Student Dashboard</h1>
                    <a href="{{ route('allquiz') }}">
                        <button class="btn btn-primary">
                            <i class="fas fa-play me-2"></i> Start New Quiz
                        </button>
                    </a>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="widget">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-check-circle quiz-icon"></i>
                                <div>
                                    <h3>Completed Quizzes</h3>
                                    <p class="stat-number">{{ $attemptedQuizCount }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="widget">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-star quiz-icon"></i>
                                <div>
                                    <h3>Average Score</h3>
                                    <p class="stat-number">{{ $averageScore }}%</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="widget">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-trophy quiz-icon"></i>
                                <div>
                                    <h3>Achievements</h3>
                                    <p class="stat-number">7</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="widget">
                            <h3>Upcoming Quizzes</h3>
                            <ul class="list-group">
                                @forelse ($nearDueQuizzes as $nearquiz)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                       {{ $nearquiz->title }}
                                        @if ($nearquiz->remaining_days == 0)
                                        <span class="bg-danger px-2  rounded-pill">Today</span>
                                        @elseif ($nearquiz->remaining_days == 1)
                                        <span class="bg-info px-2 rounded-pill">Tomorrow</span>
                                        @else
                                        <span class="bg-success px-2 rounded-pill">{{ $nearquiz->remaining_days }} days left</span>
                                        @endif
                                    </li>
                                @empty
                                    <div class="conatiner-fluid">
                                        No Quiz
                                    </div>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="widget">
                            <h3>Recent Performance</h3>
                            <ul class="list-group">
                                @forelse ($attemptedQuiz as $quiz)
                                    <li class="list-group-item">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span>{{ $quiz->quiz_name }}</span>
                                            <span>{{ $quiz->percentage_scored }}%</span>
                                        </div>
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar"
                                                style="width: {{ $quiz->percentage_scored }}%"
                                                aria-valuenow="{{ $quiz->percentage_scored }}" aria-valuemin="0"
                                                aria-valuemax="100"></div>
                                        </div>
                                    </li>
                                @empty
                                    <div class="container-fluid">
                                        No Quiz Yet
                                    </div>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
