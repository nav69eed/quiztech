<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Past Quizzes - Quiz App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
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
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .navbar {
            background-color: var(--navbg);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand {
            color: var(--primary-color);
            font-weight: bold;
        }

        .nav-link {
            color: var(--tcolor);
        }

        .card {
            background-color: white;
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: var(--secondary);
            color: white;
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
        }

        .btn-primary {
            background-color: var(--action);
            border-color: var(--action);
        }

        .btn-primary:hover {
            background-color: var(--tertiary);
            border-color: var(--tertiary);
        }

        .table th {
            color: var(--headingcolor);
        }

        .completion-rate {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            font-weight: bold;
            color: white;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="#">Quiz App</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fas fa-home"></i> Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="#"><i class="fas fa-history"></i> Past Quizzes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fas fa-users"></i> Students</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fas fa-cog"></i> Settings</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h2 class="mb-0">Past Quizzes</h2>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Quiz Title</th>
                                        <th>Subject</th>
                                        <th>Due Date</th>
                                        <th>Completion Rate</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="quizTableBody">
                                    <!-- Quiz data will be dynamically inserted here -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quiz Details Modal -->
    <div class="modal fade" id="quizDetailsModal" tabindex="-1" aria-labelledby="quizDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="quizDetailsModalLabel">Quiz Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="quizDetailsBody">
                    <!-- Quiz details will be dynamically inserted here -->
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Sample quiz data
        const quizzes = [
            { id: 1, title: "Mathematics Midterm", subject: "Mathematics", dueDate: "2023-04-15", totalStudents: 50, completedStudents: 45 },
            { id: 2, title: "History Essay", subject: "History", dueDate: "2023-04-18", totalStudents: 40, completedStudents: 35 },
            { id: 3, title: "Physics Lab Report", subject: "Physics", dueDate: "2023-04-10", totalStudents: 30, completedStudents: 28 },
            { id: 4, title: "Literature Analysis", subject: "English", dueDate: "2023-04-17", totalStudents: 45, completedStudents: 40 },
            { id: 5, title: "Chemistry Experiment", subject: "Chemistry", dueDate: "2023-04-05", totalStudents: 35, completedStudents: 32 },
        ];

        function renderQuizzes() {
            const tableBody = document.getElementById("quizTableBody");
            tableBody.innerHTML = "";

            quizzes.forEach(quiz => {
                const completionRate = Math.round((quiz.completedStudents / quiz.totalStudents) * 100);
                const row = document.createElement("tr");
                row.innerHTML = `
                    <td>${quiz.title}</td>
                    <td>${quiz.subject}</td>
                    <td>${quiz.dueDate}</td>
                    <td>
                        <div class="completion-rate" style="background-color: ${getCompletionColor(completionRate)};">
                            ${completionRate}%
                        </div>
                    </td>
                    <td>
                        <button class="btn btn-sm btn-primary" onclick="showQuizDetails(${quiz.id})">
                            <i class="fas fa-info-circle"></i> Details
                        </button>
                    </td>
                `;
                tableBody.appendChild(row);
            });
        }

        function getCompletionColor(rate) {
            if (rate >= 90) return "#4CAF50";
            if (rate >= 75) return "#8BC34A";
            if (rate >= 60) return "#FFC107";
            if (rate >= 40) return "#FF9800";
            return "#F44336";
        }

        function showQuizDetails(quizId) {
            const quiz = quizzes.find(q => q.id === quizId);
            if (!quiz) return;

            const completionRate = Math.round((quiz.completedStudents / quiz.totalStudents) * 100);
            const modalBody = document.getElementById("quizDetailsBody");
            modalBody.innerHTML = `
                <h3>${quiz.title}</h3>
                <p><strong>Subject:</strong> ${quiz.subject}</p>
                <p><strong>Due Date:</strong> ${quiz.dueDate}</p>
                <p><strong>Total Students:</strong> ${quiz.totalStudents}</p>
                <p><strong>Completed Students:</strong> ${quiz.completedStudents}</p>
                <div class="progress">
                    <div class="progress-bar" role="progressbar" style="width: ${completionRate}%; background-color: ${getCompletionColor(completionRate)};" aria-valuenow="${completionRate}" aria-valuemin="0" aria-valuemax="100">${completionRate}%</div>
                </div>
            `;

            const modal = new bootstrap.Modal(document.getElementById('quizDetailsModal'));
            modal.show();
        }

        // Initial render
        renderQuizzes();
    </script>
</body>
</html>