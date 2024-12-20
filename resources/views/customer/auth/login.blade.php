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
   <div id="loading" style="position: fixed; width: 100%; height: 100%; background: white; z-index: 9999;">
      <div id="loading-center" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
          <div class="spinner-border text-primary" role="status">
              <span class="sr-only">Loading...</span>
          </div>
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
                        <h2>Sign In</h2>
                        <p>Login to stay connected.</p>
                        <form method="POST" action="{{ route('customer.login') }}">
                            @csrf
                           <div class="row">
                              <div class="col-lg-12">
                                 <div class="floating-input form-group">
                                    <input class="form-control" type="text" name="email" id="email" required />
                                    <label class="form-label" for="email"  :value="__('Email')" >Email</label>
                                 </div>
                                 <x-input-error :messages="$errors->get('email')" class="mt-2" />
                              </div>
                              <div class="col-lg-12">
                                 <div class="floating-input form-group">
                                    <input class="form-control" type="password" name="password" id="password" required />
                                    <label class="form-label" for="password"  :value="__('Password')" >Password</label>
                                 </div>
                                 <x-input-error :messages="$errors->get('password')" class="mt-2" />
                              </div>
                              <div class="col-lg-6">
                                 <div class="custom-control custom-checkbox mb-3 text-left">
                                    <input type="checkbox" class="custom-control-input" id="customCheck1">
                                    <label class="custom-control-label" for="customCheck1">Remember Me</label>
                                 </div>
                              </div>
                              @if (Route::has('password.request'))
                              <div class="col-lg-6">
                                
                                 <a href="{{ route('password.request') }}" class="text-primary float-right">Forgot Password?</a>
                               
                                </div>
                                @endif
                           </div>
                           <button type="submit" class="btn btn-primary">Sign In</button>
                           <p class="mt-3">
                              Create an Account <a href="{{ route('customer.register') }}" class="text-primary">Sign Up</a>
                           </p>
                        </form>
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
   <script src="/assets/js/app.js"></script>  
   <script>
      window.addEventListener('load', function () {
          document.getElementById('loading').style.display = 'none';
      });
   </script>
 
   </body>
</html>