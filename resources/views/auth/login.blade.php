<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Ghana Hospital Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #1e40af 0%, #059669 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .login-card {
            border: none;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            border-radius: 1rem;
            width: 100%;
            max-width: 420px;
        }

        .login-header {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
            color: white;
            padding: 2rem;
            border-radius: 1rem 1rem 0 0;
            text-align: center;
        }

        .login-header h1 {
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .login-header p {
            font-size: 0.875rem;
            opacity: 0.9;
            margin: 0;
        }

        .form-control, .form-control:focus {
            border-radius: 0.5rem;
            border: 1px solid #e5e7eb;
        }

        .form-control:focus {
            border-color: #1e40af;
            box-shadow: 0 0 0 0.2rem rgba(30, 64, 175, 0.25);
        }

        .btn-login {
            background-color: #1e40af;
            border: none;
            color: white;
            font-weight: 600;
            padding: 0.75rem;
            border-radius: 0.5rem;
            width: 100%;
        }

        .btn-login:hover {
            background-color: #1e3a8a;
            color: white;
        }

        .credentials-info {
            background-color: #f0f9ff;
            border-left: 4px solid #1e40af;
            padding: 1rem;
            border-radius: 0.25rem;
            font-size: 0.875rem;
            margin-top: 1.5rem;
        }

        .credentials-info h6 {
            color: #1e40af;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .credential-item {
            display: flex;
            justify-content: space-between;
            padding: 0.25rem 0;
            border-bottom: 1px solid #dbeafe;
        }

        .credential-item:last-child {
            border-bottom: none;
        }

        .label-role {
            font-weight: 600;
            color: #1f2937;
        }

        .label-cred {
            color: #6b7280;
            font-size: 0.8rem;
        }

        .alert-info {
            background-color: #ecfdf5;
            border-color: #059669;
            color: #065f46;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="login-header">
            <h1><i class="bi bi-hospital"></i> GHMS</h1>
            <p>Ghana Hospital Management System</p>
        </div>

        <div class="card-body p-4">
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error!</strong>
                    <ul class="mb-0 mt-2">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label fw-600">Email Address</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required autofocus>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label fw-600">Password</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                </div>

                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="remember" name="remember">
                    <label class="form-check-label" for="remember">Remember me</label>
                </div>

                <button type="submit" class="btn btn-login">Sign In</button>
            </form>

            <!-- Default Credentials Info -->
            <div class="credentials-info">
                <h6><i class="bi bi-info-circle"></i> Demo Credentials</h6>

                <div class="credential-item">
                    <span class="label-role">Administrator:</span>
                    <span class="label-cred">admin@ghospital.gov.gh</span>
                </div>

                <div class="credential-item">
                    <span class="label-cred" style="width: 100%; text-align: right;">Password: Admin@123456</span>
                </div>

                <div style="margin-top: 1rem; border-top: 1px solid #dbeafe; padding-top: 0.75rem;">
                    <small style="color: #059669; font-weight: 600;">Other test accounts available:</small>
                    <ul style="font-size: 0.75rem; margin-top: 0.5rem; color: #6b7280;">
                        <li><strong>Doctor:</strong> doctor@ghospital.gov.gh / Doctor@12345</li>
                        <li><strong>Nurse:</strong> nurse@ghospital.gov.gh / Nurse@12345</li>
                        <li><strong>NHIS Officer:</strong> nhis@ghospital.gov.gh / NHIS@12345</li>
                        <li><strong>Finance:</strong> finance@ghospital.gov.gh / Finance@12345</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
