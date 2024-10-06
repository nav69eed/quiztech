<!DOCTYPE html>
<html lang="en" class="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QuizTech - Advanced Online Quiz Platform</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('webassets/images/Qlogo.png') }}" type="image/x-icon">
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
            --card-bg: #ffffff;
            --footer-bg: #391560;
        }

        .dark {
            --primary: #1a1a2e;
            --secondary: #16213e;
            --tertiary: #e94560;
            --action: #f77f00;
            --navbg: rgba(26, 26, 46, 0.8);
            --fontcolor: #e0e0e0;
            --tcolor: rgba(224, 224, 224, 0.9);
            --headingcolor: #ffffff;
            --card-bg: #16213e;
            --footer-bg: #0f3460;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--primary);
            color: var(--fontcolor);
            transition: background-color 0.3s, color 0.3s;
        }

        .navbar {
            background-color: var(--navbg);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s;
        }

        .navbar-brand img {
            height: 2.1875rem;
        }

        .navbar-brand {
            color: var(--headingcolor);
            font-weight: bold;
            font-size: 1.5rem;
        }

        .nav-link {
            color: var(--tcolor);
            font-weight: 500;
        }

        .btn-primary {
            background-color: var(--action);
            border-color: var(--action);
        }

        .btn-outline-primary {
            color: var(--action);
            border-color: var(--action);
        }

        .btn-outline-primary:hover {
            background-color: var(--action);
            color: white;
        }

        .hero {
            background-color: var(--secondary);
            color: var(--action);
            padding: 100px 0;
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('https://images.unsplash.com/photo-1434030216411-0b793f4b4173?q=80&w=1740&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D') no-repeat center center;
            background-size: cover;
            opacity: 0.2;
            z-index: 0;
        }

        .hero-content {
            position: relative;
            z-index: 1;
        }

        .hero h1 {
            font-size: 3.5rem;
            font-weight: bold;
            margin-bottom: 1rem;
        }

        .hero p {
            font-size: 1.25rem;
            margin-bottom: 2rem;
        }

        .feature-icon {
            font-size: 3rem;
            color: var(--tertiary);
            margin-bottom: 1rem;
        }

        .section-title {
            color: var(--headingcolor);
            font-weight: bold;
            margin-bottom: 2rem;
        }

        .card {
            background-color: var(--card-bg);
            border: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease, background-color 0.3s;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        .footer {
            background-color: var(--footer-bg);
            color: white;
            padding: 2rem 0;
            transition: background-color 0.3s;
        }

        .testimonial {
            background-color: var(--card-bg);
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s;
        }

        .testimonial img {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            margin-right: 15px;
        }

        .quiz-demo {
            background-color: var(--card-bg);
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s;
        }

        .stats-container {
            background-color: var(--tertiary);
            color: white;
            padding: 40px 0;
        }

        .stat-item {
            text-align: center;
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
        }

        .pricing-table {
            background-color: var(--card-bg);
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s;
        }

        .pricing-header {
            background-color: var(--secondary);
            color: var(--fontcolor);
            padding: 20px;
            text-align: center;
        }

        .pricing-features {
            padding: 20px;
        }

        .pricing-price {
            font-size: 2rem;
            font-weight: bold;
            margin: 20px 0;
            text-align: center;
        }

        .theme-toggle {
            cursor: pointer;
            margin-top: 5px;
            padding: 4px 16px;
            border-radius: 20px;
            transition: background-color 0.3s;
        }

        .light .theme-toggle {
            background-color: var(--secondary);
            color: white;
        }

        .dark .theme-toggle {
            background-color: var(--primary);
            color: var(--fontcolor);
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light sticky-top">
        <div class="container">
            <a class="navbar-brand" href="#"><img src="{{ asset('webassets/images/QuizTech.png') }}"
                    alt="QuizTech"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#features">Features</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#how-it-works">How It Works</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#pricing">Pricing</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#testimonials">Testimonials</a>
                    </li>
                    <li class="nav-item">
                        <span class="nav-link theme-toggle" id="themeToggle">
                            <i class="fas fa-sun"></i>
                        </span>
                    </li>
                </ul>
                <div class="ms-3">
                    <a href="{{ route('login') }}" class="btn btn-outline-primary me-2">Log In</a>
                    <a href="{{ route('registration') }}" class="btn btn-primary">Sign Up</a>
                </div>
            </div>
        </div>
    </nav>

    <header class="hero">
        <div class="container text-center hero-content">
            <h1>Welcome to QuizTech</h1>
            <p class="lead" style=" color: white;">Revolutionize your teaching and learning experience with our
                advanced quiz platform</p>
            <a href="{{ route('registration') }}" class="btn btn-primary btn-lg me-3">Get Started for Free</a>
            <a href="#how-it-works" class="btn btn-outline-light btn-lg">Learn More</a>
        </div>
    </header>

    <section id="features" class="py-5">
        <div class="container">
            <h2 class="text-center section-title">Why Choose QuizTech?</h2>
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="card h-100 text-center p-4">
                        <i class="fas fa-chalkboard-teacher feature-icon"></i>
                        <h3>For Educators</h3>
                        <p>Create engaging quizzes, track student progress, and manage your classes with our intuitive
                            dashboard.</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 text-center p-4">
                        <i class="fas fa-user-graduate feature-icon"></i>
                        <h3>For Students</h3>
                        <p>Take quizzes, view your results, and stay updated on upcoming assessments with our
                            user-friendly interface.</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 text-center p-4">
                        <i class="fas fa-chart-line feature-icon"></i>
                        <h3>Advanced Analytics</h3>
                        <p>Gain insights into student performance with our detailed analytics and reporting tools.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="how-it-works" class="py-5 bg-light">
        <div class="container">
            <h2 class="text-center section-title">How It Works</h2>
            <div class="row align-items-center">
                <div class="col-md-6">
                    <ol class="list-group list-group-numbered">
                        <li class="list-group-item">Sign up for a free account</li>
                        <li class="list-group-item">Create your first quiz or join a class</li>
                        <li class="list-group-item">Take quizzes or assign them to your students</li>
                        <li class="list-group-item">Track progress and analyze results</li>
                        <li class="list-group-item">Improve learning outcomes</li>
                    </ol>
                </div>
                <div class="col-md-6">
                    <img src="https://plus.unsplash.com/premium_photo-1680807869780-e0876a6f3cd5?q=80&w=1742&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                        alt="Classroom" class="img-fluid rounded shadow">
                </div>
            </div>
        </div>
    </section>

    <section class="stats-container">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-sm-6">
                    <div class="stat-item">
                        <div class="stat-number">100,000+</div>
                        <div>Active Users</div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="stat-item">
                        <div class="stat-number">500,000+</div>
                        <div>Quizzes Created</div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="stat-item">
                        <div class="stat-number">5,000+</div>
                        <div>Schools</div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="stat-item">
                        <div class="stat-number">98%</div>
                        <div>Satisfaction Rate</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="pricing" class="py-5">
        <div class="container">
            <h2 class="text-center section-title">Choose Your Plan</h2>
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="pricing-table">
                        <div class="pricing-header">
                            <h3 class="text-white">Basic</h3>
                        </div>
                        <div class="pricing-price">$0 / month</div>
                        <div class="pricing-features">
                            <ul class="list-unstyled">
                                <li><i class="fas fa-check text-success me-2"></i>Create up to 5 quizzes</li>
                                <li><i class="fas fa-check text-success me-2"></i>Basic analytics</li>
                                <li><i class="fas fa-check text-success me-2"></i>50 student limit</li>
                            </ul>
                        </div>
                        <div class="text-center pb-4">
                            <a href="#" class="btn btn-outline-primary">Get Started</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="pricing-table">
                        <div class="pricing-header">
                            <h3 class="text-white">Pro</h3>
                        </div>
                        <div class="pricing-price">$29 / month</div>
                        <div class="pricing-features">
                            <ul class="list-unstyled">
                                <li><i class="fas fa-check text-success me-2"></i>Unlimited quizzes</li>
                                <li><i class="fas fa-check text-success me-2"></i>Advanced analytics</li>
                                <li><i class="fas fa-check text-success me-2"></i>500 student limit</li>
                                <li><i class="fas fa-check text-success me-2"></i>Priority support</li>
                            </ul>
                        </div>
                        <div class="text-center pb-4">
                            <a href="#" class="btn btn-primary">Choose Pro</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="pricing-table">
                        <div class="pricing-header">
                            <h3 class="text-white">Enterprise</h3>
                        </div>
                        <div class="pricing-price">Custom</div>
                        <div class="pricing-features">
                            <ul class="list-unstyled">
                                <li><i class="fas fa-check text-success me-2"></i>All Pro features</li>
                                <li><i class="fas fa-check text-success me-2"></i>Unlimited students</li>
                                <li><i class="fas fa-check text-success me-2"></i>API access</li>
                                <li><i class="fas fa-check text-success me-2"></i>Dedicated support</li>
                            </ul>
                        </div>
                        <div class="text-center pb-4">
                            <a href="#" class="btn btn-outline-primary">Contact Sales</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="testimonials" class="py-5 bg-light">
        <div class="container">
            <h2 class="text-center section-title">What Our Users Say</h2>
            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="testimonial">
                        <div class="d-flex align-items-center mb-3">
                            <img src="https://i.pravatar.cc/150?img=1" alt="User" class="rounded-circle">
                            <div>
                                <h5 class="mb-0">Sarah Johnson</h5>
                                <p class="text-muted mb-0">High School Teacher</p>
                            </div>
                        </div>
                        <p>"QuizTech has revolutionized the way I assess my students. It's user-friendly and provides
                            valuable insights into their progress."</p>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="testimonial">
                        <div class="d-flex align-items-center mb-3">
                            <img src="https://i.pravatar.cc/150?img=3" alt="User" class="rounded-circle">
                            <div>
                                <h5 class="mb-0">Michael Chen</h5>
                                <p class="text-muted mb-0">University Professor</p>
                            </div>
                        </div>
                        <p>"The analytics provided by QuizTech have helped me identify areas where my students need
                            additional support. It's an invaluable tool for educators."</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <h2 class="text-center section-title">Try a Demo Quiz</h2>
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="quiz-demo">
                        <h3 class="mb-4">Sample Quiz: General Knowledge</h3>
                        <form>
                            <div class="mb-3">
                                <p>1. What is the capital of France?</p>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="q1" id="q1a"
                                        value="a">
                                    <label class="form-check-label" for="q1a">London</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="q1" id="q1b"
                                        value="b">
                                    <label class="form-check-label" for="q1b">Berlin</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="q1" id="q1c"
                                        value="c">
                                    <label class="form-check-label" for="q1c">Paris</label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <p>2. Which planet is known as the Red Planet?</p>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="q2" id="q2a"
                                        value="a">
                                    <label class="form-check-label" for="q2a">Venus</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="q2" id="q2b"
                                        value="b">
                                    <label class="form-check-label" for="q2b">Mars</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="q2" id="q2c"
                                        value="c">
                                    <label class="form-check-label" for="q2c">Jupiter</label>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit Answers</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5 bg-light">
        <div class="container text-center">
            <h2 class="section-title">Ready to Transform Your Teaching?</h2>
            <p class="lead mb-4">Join thousands of educators and students who are already using QuizTech to enhance
                their learning experience.</p>
            <a href="{{ route('registration') }}" class="btn btn-primary btn-lg me-3">Sign Up Now</a>
            <a href="#" class="btn btn-outline-primary btn-lg">Request a Demo</a>
        </div>
    </section>

    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5>QuizTech</h5>
                    <p>Empowering education through interactive quizzes and advanced analytics.</p>
                </div>
                <div class="col-md-4">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-white">Home</a></li>
                        <li><a href="#features" class="text-white">Features</a></li>
                        <li><a href="#pricing" class="text-white">Pricing</a></li>
                        <li><a href="#" class="text-white">Blog</a></li>
                        <li><a href="#" class="text-white">Support</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5>Connect With Us</h5>
                    <div class="d-flex">
                        <a href="#" class="text-white me-3"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-white me-3"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-white me-3"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-white"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                    <div class="mt-3">
                        <a href="#" class="text-white me-3">Privacy Policy</a>
                        <a href="#" class="text-white">Terms of Service</a>
                    </div>
                </div>
            </div>
            <hr class="mt-4 bg-light">
            <div class="text-center mt-4">
                <p>&copy; 2023 QuizTech. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const themeToggle = document.getElementById('themeToggle');
        const htmlElement = document.documentElement;
        const moonIcon = '<i class="fas fa-moon"></i>';
        const sunIcon = '<i class="fas fa-sun"></i>';

        themeToggle.addEventListener('click', () => {
            htmlElement.classList.toggle('dark');
            themeToggle.innerHTML = htmlElement.classList.contains('dark') ? moonIcon : sunIcon;
        });
    </script>
</body>

</html>
