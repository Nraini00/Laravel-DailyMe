
@extends ('layouts.default')

@section("title", "Login")

@section("content")

<section class="d-flex align-items-center justify-content-center" style="min-height: 100vh; padding-top:0px;">
  <div class="container" style="max-width: 800px;">
    <div class="card shadow-lg" style="border-radius: 1rem;">
      <div class="row g-0">
        <div class="col-md-6 d-none d-md-block" style="padding-top:110px;">
          <img src="images/logo.png" alt="login form" class="img-fluid" style="border-radius: 1rem 0 0 1rem;" />
        </div>
        <div class="col-md-12 col-lg-6 d-flex align-items-center">
          <div class="card-body p-4 p-lg-5">

            <!-- Login Form -->
            <form action="{{route("login.post")}}" method="POST">
            @csrf
              <!-- Error message display -->
              @if (isset($_GET['error']))
                <p class="error text-danger">{{ $_GET['error'] }}</p>
              @endif

              <h3 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px; text-align: center;">Sign In to your Account</h3>

              <div class="form-outline mb-2">
                <input type="email" id="form2Example17" name="email" class="form-control form-control-lg" required />
                <label class="form-label" for="form2Example17">Email address</label>
              </div>

              <div class="form-outline mb-2">
                <input type="password" id="form2Example27" name="password" class="form-control form-control-lg" required />
                <label class="form-label" for="form2Example27">Password</label>
              </div>

              <div class="pt-1 mb-4" style="text-align: center;">
                <button class="btn btn-dark btn-lg btn-block" type="submit">Login</button>
              </div>

              <div class="d-flex justify-content-between">
                <a class="small text-muted" href="#!">Forgot password?</a>
                <a class="small text-muted" href="{{ route('register') }}">Register here</a>
              </div>

            </form>

          </div>
        </div>
      </div>
    </div>
  </div>
</section>

@endsection
