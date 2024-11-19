


<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>xyz-tyres</title>
      
      <!-- Favicon -->
      <link rel="shortcut icon" href="/assets/images/favicon.ico" />
      
      <link rel="stylesheet" href="/assets/css/backend-plugin.min.css">
      <link rel="stylesheet" href="/assets/css/backend.css?v=1.0.1">
      <link rel="stylesheet" href="/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css">
      <link rel="stylesheet" href="/assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css">
      <link rel="stylesheet" href="/assets/vendor/remixicon/fonts/remixicon.css">  </head>
  <body class=" ">
    <!-- loader Start -->
    <div id="loading">
          <div id="loading-center">
          </div>
    </div>
    <!-- loader END -->
    
      <div class="wrapper">
      <section class="login-content">
         <div class="container h-100">
            <div class="row justify-content-center align-items-center height-self-center">
               <div class="col-md-5 col-sm-12 col-12 align-self-center">
                  <div class="card">
                     <div class="card-body text-center">
                        <h2>Sign Up</h2>
                        <p>Create your account.</p>
                        {{-- <x-guest-layout> --}}
                            <form method="POST" action="{{ route('register') }}">
                                @csrf
                                <div class="row">
                                    <!-- Name -->
                                    <div class="col-lg-6">
                                        <div class="floating-input form-group">
                                            <input class="form-control" type="text" name="name" id="name" value="{{ old('name') }}" required />
                                            <label class="form-label" for="name">{{ __('Name') }}</label>
                                        </div>
                                    </div>
                        
                                    <!-- Company -->
                                    <div class="col-lg-6">
                                        <div class="floating-input form-group">
                                            <input class="form-control" type="text" name="company" id="company" value="{{ old('company') }}" required />
                                            <label class="form-label" for="company">{{ __('Company') }}</label>
                                        </div>
                                    </div>
                        
                                    <!-- Email -->
                                    <div class="col-lg-12">
                                        <div class="floating-input form-group">
                                            <input class="form-control" type="email" name="email" id="email" value="{{ old('email') }}" required />
                                            <label class="form-label" for="email">{{ __('Email') }}</label>
                                        </div>
                                    </div>
                        
                                    <!-- Password -->
                                    <div class="col-lg-6">
                                        <div class="floating-input form-group">
                                            <input class="form-control" type="password" name="password" id="password" required />
                                            <label class="form-label" for="password">{{ __('Password') }}</label>
                                        </div>
                                    </div>
                        
                                    <!-- Confirm Password -->
                                    <div class="col-lg-6">
                                        <div class="floating-input form-group">
                                            <input class="form-control" type="password" name="password_confirmation" id="password_confirmation" required />
                                            <label class="form-label" for="password_confirmation">{{ __('Confirm Password') }}</label>
                                        </div>
                                    </div>
                        
                                    <!-- Agree to Terms -->
                                    <div class="col-lg-12">
                                        <div class="custom-control custom-checkbox mb-3 text-left">
                                            <input type="checkbox" class="custom-control-input" id="customCheck1" name="terms" required />
                                            <label class="custom-control-label" for="customCheck1">{{ __('I agree with the terms of use') }}</label>
                                        </div>
                                    </div>
                                </div>
                        
                                <!-- Submit Button -->
                                <button type="submit" class="btn btn-primary">{{ __('Sign Up') }}</button>
                        
                                <!-- Login Link -->
                                <p class="mt-3">
                                    {{ __('Already have an Account?') }} <a href="{{ route('login') }}" class="text-primary">{{ __('Sign In') }}</a>
                                </p>
                            </form>
                        {{-- </x-guest-layout> --}}
                        
                     </div>
                  </div>                  
               </div>
            </div>
         </div>
      </section>
      </div>
    
    <!-- Backend Bundle JavaScript -->
    <script src="/assets/js/backend-bundle.min.js"></script>
    
    <!-- Chart Custom JavaScript -->
    <script src="/assets/js/customizer.js"></script>
    
    
    <!-- app JavaScript -->
    <script src="/assets/js/app.js"></script>  </body>
</html>