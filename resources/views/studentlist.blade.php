<!DOCTYPE html>
<html lang="en">
<x-head :title="'QuizTech | Students'" />
<style>
    body {
        background-color: var(--primary);
        color: var(--fontcolor);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .card {
        background-color: white;
        border: none;
        border-radius: 15px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease-in-out;
    }

    .card:hover {
        transform: translateY(-5px);
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

    .student-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
    }

    .table th {
        color: var(--headingcolor);
    }

    .badge {
        font-size: 0.8rem;
    }
</style>

<body>
    <x-nav-bar-main :user="$user" />
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h2 class="mb-0">Registered Students</h2>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="input-group w-50">
                                <input type="text" class="form-control" placeholder="Search students..."
                                    id="searchInput">
                                <button class="btn btn-outline-secondary" type="button"><i
                                        class="fas fa-search"></i></button>
                            </div>
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addStudentModal">
                                <i class="fas fa-plus"></i> Add Student
                            </button>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Quizzes Taken</th>
                                        <th>Average Score</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="studentTableBody">
                                    @forelse ($students as $index => $student)
                                        <tr>
                                            <td>{{ $index + 1 }}</td> <!-- Changed from hardcoded '1' to index -->
                                            <td>
                                                <img src="https://i.pravatar.cc/150?img={{ $student['user_id'] }}"
                                                    alt="{{ $student['name'] }}" class="student-avatar me-2">
                                                {{ $student['name'] }} <!-- Accessing as array -->
                                            </td>
                                            <td>{{ $student['email'] }}</td> <!-- Accessing as array -->
                                            <td>{{ $student['attempts_count'] }}</td> <!-- Accessing as array -->
                                            <td>
                                                @if ($student['average_score'] == null)
                                                    0
                                                @else
                                                    {{ $student['average_score'] }}
                                                @endif%
                                            </td> <!-- Accessing as array -->
                                            <td>
                                                <button class="btn btn-sm btn-outline-primary me-1"><i
                                                        class="fas fa-edit"></i></button>
                                                <a href="{{ route('deletestudent', ['id' => $student['user_id']]) }}">
                                                    <button class="btn btn-sm btn-outline-danger"><i
                                                            class="fas fa-trash"></i></button>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center">No students found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const studentTableBody = document.getElementById('studentTableBody');

            searchInput.addEventListener('input', function() {
                const query = searchInput.value.toLowerCase();
                const rows = studentTableBody.getElementsByTagName('tr');

                Array.from(rows).forEach(row => {
                    const cells = row.getElementsByTagName('td');
                    const nameCell = cells[1]; // Assuming the name is in the second column
                    if (nameCell) {
                        const name = nameCell.textContent.toLowerCase();
                        row.style.display = name.includes(query) ? '' : 'none';
                    }
                });
            });
        });
    </script>
</body>

</html>
