<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Register Page</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
  <style type="text/css">
    body{
      background: #F8F9FA;
    }
    .spinner-border-sm {
      width: 1rem;
      height: 1rem;
      border-width: 0.15em;
    }
  </style>
</head>
<body>

<section class="bg-light py-3 py-md-5">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5 col-xxl-4">
        <div class="card border border-light-subtle rounded-3 shadow-sm">
          <div class="card-body p-3 p-md-4 p-xl-5">
            <div class="text-center mb-3">
              <a href="#!">
                <img src="https://bajo.jumbomark.com/labels/JID2021078022" alt="Logo" width="250">
              </a>
            </div>
            <h2 class="fs-6 fw-normal text-center text-secondary mb-4">Sign up to your account</h2>
            
            <div id="alertMessage"></div>

            <form id="registerForm">
              <div class="row gy-2 overflow-hidden">
                <div class="col-12">
                  <div class="form-floating mb-3">
                    <input type="text" class="form-control" name="name" id="name" placeholder="Your Name" required>
                    <label for="name" class="form-label">{{ __('Name') }}</label>
                  </div>
                  <div class="invalid-feedback" id="nameError"></div>
                </div>

                <div class="col-12">
                  <div class="form-floating mb-3">
                    <input type="email" class="form-control" name="email" id="email" placeholder="name@example.com" required>
                    <label for="email" class="form-label">{{ __('Email Address') }}</label>
                  </div>
                  <div class="invalid-feedback" id="emailError"></div>
                </div>

                <div class="col-12">
                  <div class="form-floating mb-3">
                    <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
                    <label for="password" class="form-label">{{ __('Password') }}</label>
                  </div>
                  <div class="invalid-feedback" id="passwordError"></div>
                </div>

                <div class="col-12">
                  <div class="form-floating mb-3">
                    <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Confirm Password" required>
                    <label for="password_confirmation" class="form-label">{{ __('Confirm Password') }}</label>
                  </div>
                  <div class="invalid-feedback" id="passwordConfirmationError"></div>
                </div>

                <div class="col-12">
                  <div class="d-grid my-3">
                    <button class="btn btn-primary btn-lg" type="submit" id="registerBtn">
                      <span id="btnText">{{ __('Register') }}</span>
                      <span id="btnSpinner" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                    </button>
                  </div>
                </div>

                <div class="col-12">
                  <p class="m-0 text-secondary text-center">
                    Have an account? <a href="{{ route('login') }}" class="link-primary text-decoration-none">Sign in</a>
                  </p>
                </div>
              </div>
            </form>

          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#registerForm').on('submit', function(e) {
        e.preventDefault();
        
        // Reset errors
        $('.form-control').removeClass('is-invalid');
        $('.invalid-feedback').text('').hide();
        $('#alertMessage').html('');
        
        // Show loading
        $('#registerBtn').prop('disabled', true);
        $('#btnText').addClass('d-none');
        $('#btnSpinner').removeClass('d-none');
        
        const formData = {
            name: $('#name').val(),
            email: $('#email').val(),
            password: $('#password').val(),
            password_confirmation: $('#password_confirmation').val()
        };
        
        $.ajax({
            url: '/api/register',
            type: 'POST',
            data: formData,
            success: function(response) {
                if(response.success) {
                    // Save token to localStorage
                    localStorage.setItem('auth_token', response.data.token);
                    localStorage.setItem('user', JSON.stringify(response.data.user));
                    
                    $('#alertMessage').html(
                        '<div class="alert alert-success alert-dismissible fade show" role="alert">' +
                        response.message +
                        '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>' +
                        '</div>'
                    );
                    
                    // Redirect to dashboard
                    setTimeout(function() {
                        window.location.href = '/dashboard';
                    }, 1000);
                }
            },
            error: function(xhr) {
                $('#registerBtn').prop('disabled', false);
                $('#btnText').removeClass('d-none');
                $('#btnSpinner').addClass('d-none');
                
                if(xhr.status === 422) {
                    // Validation errors
                    const errors = xhr.responseJSON.errors;
                    if(errors.name) {
                        $('#name').addClass('is-invalid');
                        $('#nameError').text(errors.name[0]).show();
                    }
                    if(errors.email) {
                        $('#email').addClass('is-invalid');
                        $('#emailError').text(errors.email[0]).show();
                    }
                    if(errors.password) {
                        $('#password').addClass('is-invalid');
                        $('#passwordError').text(errors.password[0]).show();
                    }
                    if(errors.password_confirmation) {
                        $('#password_confirmation').addClass('is-invalid');
                        $('#passwordConfirmationError').text(errors.password_confirmation[0]).show();
                    }
                } else {
                    // Other errors
                    const message = xhr.responseJSON?.message || 'Registration failed. Please try again.';
                    $('#alertMessage').html(
                        '<div class="alert alert-danger alert-dismissible fade show" role="alert">' +
                        message +
                        '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>' +
                        '</div>'
                    );
                }
            }
        });
    });
});
</script>

</body>
</html>
