<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Register - Modern Design</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
   <style>
    :root {
        --primary-color: #2ecc71;
        --secondary-color: #1b5e20;
        --accent-color: #a3e635;
        --light-color: #f8f9fa;
        --dark-color: #212529;
        --success-color: #1b5e20;
        --error-color: #ff3333;
    }
    body {
        background: linear-gradient(135deg, #f5f7fa 0%, #d7f7e6 100%);
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    .container {
        max-width: 600px;
    }
    .card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
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
        box-shadow: 0 0 0 3px rgba(46, 204, 113, 0.2);
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
        box-shadow: 0 4px 15px rgba(46, 204, 113, 0.3);
    }
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(46, 204, 113, 0.4);
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
    .password-strength {
        height: 5px;
        background: #e9ecef;
        border-radius: 5px;
        margin-top: 5px;
        overflow: hidden;
    }
    .strength-bar {
        height: 100%;
        width: 0;
        transition: width 0.3s ease, background 0.3s ease;
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
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
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
    .google { background: #DB4437; }
    .facebook { background: #4267B2; }
    .twitter { background: #1DA1F2; }
</style>

</head>
<body>
<div class="container">
    <div class="card">
        <div class="card-header">{{ __('Register') }}</div>

        <div class="card-body">
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="row mb-3">
                    <label for="name" class="col-form-label">{{ __('Name') }}</label>
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                           name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                    @error('name')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <div class="row mb-3">
                    <label for="email" class="col-form-label">{{ __('Email Address') }}</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                           name="email" value="{{ old('email') }}" required autocomplete="email">
                    @error('email')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <div class="row mb-3">
                    <label for="password" class="col-form-label">{{ __('Password') }}</label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                           name="password" required autocomplete="new-password">
                    <div class="password-strength">
                        <div class="strength-bar"></div>
                    </div>
                    @error('password')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <div class="row mb-3">
                    <label for="password-confirm" class="col-form-label">{{ __('Confirm Password') }}</label>
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                </div>

                <div class="row mb-3">
                    <label for="type" class="col-form-label">{{ __('Type') }}</label>
                    <select id="type" name="type" class="form-control @error('type') is-invalid @enderror" required>
                        <option value="candidat" {{ old('type') == 'candidat' ? 'selected' : '' }}>Candidat</option>
                        <option value="recruteur" {{ old('type') == 'recruteur' ? 'selected' : '' }}>Recruteur</option>
                        <option value="admin" {{ old('type') == 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                    @error('type')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <div class="social-login">
                    <a href="#" class="social-btn google"><i class="fab fa-google"></i></a>
                    <a href="#" class="social-btn facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social-btn twitter"><i class="fab fa-twitter"></i></a>
                </div>

                <div class="row mb-0">
                    <button type="submit" class="btn btn-primary w-100">{{ __('Register') }}</button>
                </div>

                <div class="form-footer">
                    Already have an account? <a href="{{ route('login') }}">Login here</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const passwordInput = document.getElementById('password');
        const strengthBar = document.querySelector('.strength-bar');

        passwordInput.addEventListener('input', function() {
            const strength = calculatePasswordStrength(this.value);
            updateStrengthIndicator(strength);
        });

        function calculatePasswordStrength(password) {
            let strength = 0;
            if (password.length > 7) strength += 1;
            if (password.length > 11) strength += 1;
            if (/[A-Z]/.test(password)) strength += 1;
            if (/[0-9]/.test(password)) strength += 1;
            if (/[^A-Za-z0-9]/.test(password)) strength += 1;
            return Math.min(strength, 5);
        }

        function updateStrengthIndicator(strength) {
            const colors = ['#ff0000', '#ff5a5a', '#ffb700', '#9acd32', '#00b500'];
            const width = strength * 20;
            strengthBar.style.width = `${width}%`;
            strengthBar.style.backgroundColor = colors[strength - 1] || '#e9ecef';
        }
    });
</script>
</body>
</html>
