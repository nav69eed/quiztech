    <style>
        body {
            background-color: var(--primary);
            color: var(--fontcolor);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .navbar {
            background-color: var(--navbg);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s ease;
        }

        .navbar-brand {
            color: var(--secondary);
            font-weight: 700;
            font-size: 1.5rem;
            transition: color 0.3s ease;
        }

        .navbar-brand img {
            width: auto;
            height: 34px;
        }

        .navbar-brand:hover {
            color: var(--tertiary);
        }

        .nav-link {
            color: var(--tcolor);
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .nav-link:hover,
        .nav-link:focus {
            color: var(--tertiary);
        }

        .nav-link.active {
            color: var(--action);
        }

        .navbar-toggler {
            border-color: var(--secondary);
        }

        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(57, 21, 96, 1)' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }

        .btn-login {
            background-color: var(--action);
            color: white;
            font-weight: 600;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            transition: all 0.3s ease;
        }

        .btn-login:hover {
            background-color: var(--tertiary);
            transform: scale(1.05);
        }

        @media (max-width: 991.98px) {
            .navbar-nav {
                background-color: var(--navbg);
                padding: 1rem;
                border-radius: 0.5rem;
                margin-top: 0.5rem;
            }
        }

        /* Theme switch styles */
        .theme-switch-wrapper {
            display: flex;
            align-items: center;
            margin-left: 1rem;
        }

        .theme-switch {
            display: inline-block;
            height: 34px;
            position: relative;
            width: 60px;
        }

        .theme-switch input {
            display: none;
        }

        .slider {
            background-color: #ccc;
            bottom: 0;
            cursor: pointer;
            left: 0;
            position: absolute;
            right: 0;
            top: 0;
            transition: .4s;
            border-radius: 34px;
        }

        .slider:before {
            background-color: #fff;
            bottom: 4px;
            content: "";
            height: 26px;
            left: 4px;
            position: absolute;
            transition: .4s;
            width: 26px;
            border-radius: 50%;
        }

        input:checked+.slider {
            background-color: var(--action);
        }

        input:checked+.slider:before {
            transform: translateX(26px);
        }

        .slider-icon {
            color: var(--tcolor);
            font-size: 1.2rem;
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            transition: opacity 0.3s ease;
        }

        .slider-icon-sun {
            left: 7px;
            opacity: 1;
        }

        .slider-icon-moon {
            right: 10px;
            opacity: 0;
        }

        input:checked+.slider .slider-icon-sun {
            opacity: 0;
        }

        input:checked+.slider .slider-icon-moon {
            opacity: 1;
        }
    </style>
    </head>

    <body>
        <nav class="navbar navbar-expand-lg sticky-top">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">
                    <img src="{{ asset('webassets/images/QuizTech.png') }}" alt="" class="navbar-logo">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('dashboard') ? 'linkactive' : '' }}"
                                aria-current="page" href="{{ route('dashboard') }}">
                                <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link 
                            {{ request()->routeIs('allquiz') ? 'linkactive' : '' }}
                             "
                                href="/allquizzes">
                                <i class="fas fa-question-circle me-2"></i> Quizzes
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('quizresult*') ? 'linkactive' : '' }}" href="">
                                <i class="fas fa-chart-bar me-2"></i> Results
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('users*') ? 'linkactive' : '' }}" href="">
                                <i class="fas fa-users me-2"></i> Users
                            </a>
                        </li>
                    </ul>
                    <div class="d-flex align-items-center">
                        <a href="/logout">
                            <button class="btn btn-login" type="button">Logout</button>
                        </a>
                        <div class="theme-switch-wrapper">
                            <label class="theme-switch" for="checkbox">
                                <input type="checkbox" id="checkbox" />
                                <div class="slider">
                                    <i class="fas fa-sun slider-icon slider-icon-sun"></i>
                                    <i class="fas fa-moon slider-icon slider-icon-moon"></i>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
        <script></script>
