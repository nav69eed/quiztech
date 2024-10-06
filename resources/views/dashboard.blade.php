<!DOCTYPE html>
<html lang="en">
<x-head :title="'QuizTech | Dashboard'" />
<link rel="stylesheet" href="{{ asset('webassets/css/dashboard.css') }}">
<x-nav-bar-main :user="$user" />

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 d-md-block sidebar">
                <div class="position-sticky">
                    <h2 class="text-center text-white mb-4">QuizTech</h2>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="#">
                                <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-question-circle me-2"></i> Quizzes
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-chart-bar me-2"></i> Results
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('studentslist') }}">
                                <i class="fas fa-users me-2"></i> Users
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
                    <h1 class="h2">{{ $user->name }}</h1>
                    <a class="btn btn-primary" href="/createquiz">
                        <i class="fas fa-plus me-2"></i> Create New Quiz
                    </a>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <a href="/allquizzes">
                            <div class="widget">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-book quiz-icon"></i>
                                    <div>
                                        <h3>Total Quizzes</h3>
                                        <p class="stat-number">{{ $quizCount }}</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="{{ route('studentslist') }}">
                            <div class="widget">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-users quiz-icon"></i>
                                    <div>
                                        <h3>Registered Students</h3>
                                        <p class="stat-number">{{ $studentCount }}</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="{{ route('overduequizzes') }}">
                            <div class="widget">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-check-circle quiz-icon"></i>
                                    <div>
                                        <h3>Completed Quizzes</h3>
                                        <p class="stat-number">{{ $overdueQuizCount }}</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="widget">
                            <h3>Recent Quizzes</h3>
                            <ul class="list-group">
                                @foreach ($recentQuizzes as $index => $quiz)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        {{ $quiz->title }}
                                        @if ($index === 0)
                                            <span class="badge rounded-pill newbadge">New</span>
                                        @endif
                                        @if ($index === 1)
                                            <span class="badge rounded-pill newbadge2">IMP</span>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="widget">
                            <h3>Top Performers</h3>
                            <ul class="list-group">
                                @forelse ($topusers as$topuser)
                                    <li class="list-group-item">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span>{{ $topuser->user_name }}</span>
                                            <span>{{ $topuser->avg_score }}%</span>
                                        </div>
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar"
                                                style="width: {{ $topuser->avg_score }}%"
                                                aria-valuenow="{{ $topuser->avg_score }}" aria-valuemin="0"
                                                aria-valuemax="100"></div>
                                        </div>
                                    </li>
                                @empty
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
