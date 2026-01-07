<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login - Modern Design</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
   <style>
    :root {
        --primary-color: #2e7d32;
        --secondary-color: #1b5e20;
        --accent-color: #81c784;
        --light-color: #f8f9fa;
        --dark-color: #212529;
        --success-color: #4bb543;
        --error-color: #ff3333;
    }

    body {
        background: linear-gradient(135deg, #f5f7fa 0%, #d0f0d6 100%);
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .container {
        max-width: 1200px;
    }

    .card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        transition: transform 0.3s ease;
    }

    .card:hover {
        transform: translateY(-5px);
    }

    .card-header {
        background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
        color: white;
        text-align: center;
        padding: 1.5rem;
        font-size: 1.5rem;
        font-weight: 600;
        border-bottom: none;
    }

    .card-body {
        padding: 2.5rem;
        animation: fadeIn 0.6s ease-out;
    }

    .form-control {
        border: 2px solid #e9ecef;
        border-radius: 8px;
        padding: 12px 15px;
        transition: all 0.3s;
        box-shadow: none;
    }

    .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(46, 125, 50, 0.2);
    }

    .btn-primary {
        background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
        border: none;
        padding: 12px 30px;
        border-radius: 8px;
        font-weight: 600;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        transition: all 0.3s;
        box-shadow: 0 4px 15px rgba(46, 125, 50, 0.3);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(46, 125, 50, 0.4);
    }

    .btn-primary:active {
        transform: translateY(0);
    }

    .input-group {
        position: relative;
        margin-bottom: 1.5rem;
    }

    .input-group label {
        position: absolute;
        top: -10px;
        left: 15px;
        background: white;
        padding: 0 5px;
        font-size: 0.85rem;
        color: var(--primary-color);
        font-weight: 500;
    }

    .form-footer {
        text-align: center;
        margin-top: 1.5rem;
        color: #6c757d;
    }

    .form-footer a {
        color: var(--primary-color);
        text-decoration: none;
        font-weight: 500;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .social-login {
        display: flex;
        justify-content: center;
        gap: 15px;
        margin: 20px 0;
    }

    .social-btn {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 18px;
        transition: all 0.3s;
    }

    .social-btn:hover {
        transform: translateY(-3px);
    }

    .google {
        background: #db4437;
    }

    .facebook {
        background:rgb(7, 63, 88); /* vert pour LinkedIn par ex. */
    }

    .twitter {
        background:rgb(78, 223, 245); /* vert WhatsApp */
    }
</style>

</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Login') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="row mb-3">
                                <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="current-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6 offset-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                            {{ old('remember') ? 'checked' : '' }}>

                                        <label class="form-check-label" for="remember">
                                            {{ __('Remember Me') }}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="social-login">
                                <a href="#" class="social-btn google"><i class="fab fa-google"></i></a>
                                <a href="#" class="social-btn facebook"><i class="fab fa-facebook-f"></i></a>
                                <a href="#" class="social-btn twitter"><i class="fab fa-twitter"></i></a>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Login') }}
                                    </button>
                                </div>
                            </div>

                            <div class="form-footer">
                                Don't have an account? <a href="{{ route('register') }}">Register here</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
