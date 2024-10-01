<!DOCTYPE html>
<html lang="en">
<x-head :title="'QuizTech | Dashboard'" />

<body>
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
                                <i class="fas fa-question-circle me-2"></i> Quizzes
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-chart-bar me-2"></i> Results
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
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
                    <h1 class="h2">Dashboard</h1>
                    <a class="btn btn-primary" href="/allquizzes">
                        <i class="fas fa-plus me-2"></i> Create New Quiz
                    </a>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="widget">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-book quiz-icon"></i>
                                <div>
                                    <h3>Total Quizzes</h3>
                                    <p class="stat-number">25</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="widget">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-users quiz-icon"></i>
                                <div>
                                    <h3>Active Users</h3>
                                    <p class="stat-number">150</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="widget">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-check-circle quiz-icon"></i>
                                <div>
                                    <h3>Completed Quizzes</h3>
                                    <p class="stat-number">1,234</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="widget">
                            <h3>Recent Quizzes</h3>
                            <ul class="list-group">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Math Quiz - Grade 5
                                    <span class="badge rounded-pill newbadge">New</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Science Trivia
                                    <span class="badge newbadge2 rounded-pill">Popular</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    History of Ancient Rome
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Programming Basics
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="widget">
                            <h3>Top Performers</h3>
                            <ul class="list-group">
                                <li class="list-group-item">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span>John Doe</span>
                                        <span>98%</span>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" style="width: 98%"
                                            aria-valuenow="98" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span>Jane Smith</span>
                                        <span>95%</span>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" style="width: 95%"
                                            aria-valuenow="95" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span>Bob Johnson</span>
                                        <span>92%</span>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" style="width: 92%"
                                            aria-valuenow="92" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span>Alice Brown</span>
                                        <span>90%</span>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" style="width: 90%"
                                            aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </li>
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
