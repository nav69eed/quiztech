<!DOCTYPE html>
<html lang="en">
<x-head :title="'QuizTech | Dashboard'" />
<style>
    .card {
      //  background-color: white;
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
</style>
<body>
    <x-nav-bar-main :user="$user" />

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
                                        <th>No.</th>
                                        <th>Quiz Title</th>
                                        <th>Subject</th>
                                        <th>Due Date</th>
                                        <th>Completion Rate</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="quizTableBody">
                                    @forelse ($completionRates as $index => $quizData)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $quizData['quiz']['title'] }}</td> <!-- Accessing title from the nested array -->
                                            <td>{{ $quizData['quiz']['subject'] }}</td> <!-- Accessing subject from the nested array -->
                                            <td>{{ \Carbon\Carbon::parse($quizData['quiz']['due_datetime'])->format('F j, Y, g:i A') }}</td> <!-- Accessing due_datetime -->
                                            <td>{{ $quizData['completionRate'] }}% </td> <!-- Accessing completionRate -->
                                            <td>
                                                <button class="btn btn-sm btn-primary" onclick="showQuizDetails({{ $quizData['quiz']['id'] }})"> <!-- Accessing quiz ID -->
                                                    <i class="fas fa-info-circle"></i> Details
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
