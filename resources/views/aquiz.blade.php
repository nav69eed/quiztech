<!DOCTYPE html>
<html lang="en">
<x-head :title="'QuizTech'" />
<style>
    .login-box {
        display: flex;
        align-items: center;
        justify-content: center;
        position: static;
        transform: translate(0%, 0%);
    }

    .quizBox {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .radio-options {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .radio-options label {
        display: block;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 5px;
        cursor: pointer;
    }

    .radio-options input[type="radio"] {
        display: none;
    }

    .radio-options input[type="radio"]:checked+label {
        background-color: #007BFF;
        color: #fff;
        border-color: #007BFF;
    }
</style>

<body>
    <x-nav-bar-main :user="$user" />
    
    @if (Session::has('error'))
        <div class="alert alert-danger mt-4">
            {{ Session::get('error') }}
        </div>
    @endif

    @if (!Session::has('response'))
        <div class="mx-auto my-3 p-4 shadow  h6 quizdiv position-relative" id="quiztitle">
            <p class="c-a">
                Quiz Name : <strong class="c-s">{{ $quiz->title }}</strong>
            </p>
            <p class="">
                <span class="c-a h6">Description :- </span>{{ $quiz->description }}
            </p>
            <a id="quizstartbtn">
                <x-start-button />
            </a>
        </div>
    @endif
    <div class="quizBox">
        <div class="" id="quiz">
            <form action="{{ route('quizsubmit', ['id' => $quiz->id]) }}" method="POST">
                @csrf
                @php
                    $response = Session::get('response');
                @endphp
                @if (Session::has('response'))
                    <div class="alert alert-info py-2 mt-4">
                        <p class="mb-0">
                            <strong>Total Marks:</strong> {{ count($quiz->questions) }}
                        </p>
                        <p class="mb-0">
                            <strong>Obtained Marks:</strong> {{ collect($response)->filter(function($answer) { return Str::startsWith($answer, 'Correct'); })->count() }}
                        </p>
                    </div>
                @endif
                @forelse ($quiz->questions as $index => $question)
                    @if (Session::has('response'))
                        @if (isset($response[$index]) && \Illuminate\Support\Str::startsWith($response[$index], 'Correct'))
                            <div class="alert alert-success py-1 mt-4">
                                Correct Answer !!!
                            </div>
                        @else
                            <div class="alert alert-danger py-1 mt-4">
                                Wrong Answer !!!
                            </div>
                        @endif
                    @endif

                    <div class="form-check mt-4">
                        {{ $question->ques }}
                    </div>
                    @foreach ($question->options as $optionIndex => $option)
                        <div class="form-check">
                            <input type="radio" class="form-check-input"
                                id="radio{{ $question->id }}_{{ $optionIndex }}" name="{{ $question->id }}"
                                value="{{ $option->opt }}">

                            <label class="form-check-label"
                                for="radio{{ $question->id }}_{{ $optionIndex }}">{{ $option->opt }}</label>
                        </div>
                    @endforeach

                @empty
                    <p>No questions available.</p>
                @endforelse

                <button type="submit" class="btn btn-primary mt-3">Submit</button>
            </form>
        </div>
    </div>
    @if (!Session::has('response'))
        <div id="timer" class="text-center mt-3 h4"></div>
    @endif
</body>
<script>
    btn = document.getElementById('quizstartbtn');
    quiztitle = document.getElementById('quiztitle');
    quiz = document.getElementById('quiz');
    // Corrected code
    var radio = document.querySelectorAll('input[type="radio"]');
    @php
        $sessionData = Session::get('inpt');
    @endphp
    var sessionData = {!! json_encode($sessionData) !!};
    quiz.style.display = 'none';
    @if (Session::has('response'))
        // console.log(radio);
        quiz.style.display = 'flex';
        radio.forEach(radioButton => {
            if (radioButton.value === sessionData[radioButton.name]) {
                radioButton.checked = true;
            }
            radioButton.disabled = true;
        });
    @endif
    btn.addEventListener('click', () => {
        quiz.style.display = 'flex';
        quiztitle.style.display = 'none';
    });

    // Add timer functionality
    var timeLimit = {{ $quiz->time_limit * 60 }}; // Convert minutes to seconds
    var timer = document.getElementById('timer');
    var quizForm = document.querySelector('form');

    function startTimer() {
        var interval = setInterval(function() {
            var minutes = Math.floor(timeLimit / 60);
            var seconds = timeLimit % 60;
            timer.textContent = minutes + ":" + (seconds < 10 ? "0" : "") + seconds;
            
            if (timeLimit <= 0) {
                clearInterval(interval);
                quizForm.submit();
            }
            timeLimit--;
        }, 1000);
    }

    btn.addEventListener('click', () => {
        quiz.style.display = 'flex';
        quiztitle.style.display = 'none';
        startTimer();
    });

    // Auto-submit when time runs out
    setTimeout(() => {
        if (!quizForm.classList.contains('submitted')) {
            quizForm.submit();
        }
    }, {{ $quiz->time_limit * 60 * 1000 }});

    quizForm.addEventListener('submit', function() {
        this.classList.add('submitted');
    });
</script>

</html>
