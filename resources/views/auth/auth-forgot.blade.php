<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Forgot Your Password</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
    
        .navigation-links {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
    
        .navigation-links a {
            text-decoration: none;
            color: #007BFF;
            font-weight: bold;
        }
    
        .navigation-links a:hover {
            text-decoration: underline;
        }
    
        .profile-section {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    
        .profile-section h1 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
        }
    
        .profile-field {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }
    
        .profile-field span {
            font-size: 18px;
            color: #555;
        }
    
        .profile-field a {
            text-decoration: none;
            color: #007BFF;
            font-weight: bold;
            font-size: 16px;
        }
    
        .profile-field a:hover {
            text-decoration: underline;
        }
    
        /* Mobile Logout Button Styles */
        .btn-logout-mobile {
            display: none; /* Hide by default */
            color: #007BFF;
            font-weight: bold;
            text-decoration: none;
            padding: 10px;
            text-align: center;
            border: 1px solid #007BFF;
            border-radius: 5px;
            margin-top: 10px;
        }
    
        .btn-logout-mobile:hover {
            background-color: #007BFF;
            color: white;
            text-decoration: none;
        }
    
        @media (max-width: 768px) {
            .btn-logout-mobile {
                display: block; /* Show on mobile */
            }
        }
    </style>
</head>

<body>
    <main class="container">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <img src="{{ isset($setting) && $setting->app_logo ? asset('storage/' . $setting->app_logo) : asset('assets/images/logo_gym.png') }}" alt="Logo" width="200px" class="d-block mx-auto">
                <div class="card my-4 shadow-lg rounded">
                    <div class="card-header">
                        <h3 class="text-center font-weight-bold">Reset Your Password</h3>
                    </div>
                    <div class="card-body">
                        <p>Enter your user account's email address and we will send you a password reset link.</p>
                        <form action="{{ route('forgot') }}" method="POST">
                            @csrf
                            <div class="form-floating mb-3">
                                <input name="email" type="email" class="form-control @error('email') is-invalid @enderror" id="floatingInput" placeholder="name@example.com" value="{{ $user->email }}" required>
                                <label for="floatingInput">Email address</label>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <button class="w-100 btn-lg btn-primary" type="submit">Send Password Reset Mail</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1cnd+0AdAq8ni0Y3C03GA+6GczfURhZgefjMNKDU3KwLLpTt92lW2TdeYifz59C" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        @if (Session::has('success'))
            {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: '{{ Session::get('success') }}',
                })
            }
        @endif
    </script>
</body>

</html>
