@extends ('layouts.default')

@section("title", "Register")

@section("content")

<section style="padding-top: 10px;">
    <div class="container" style="max-width: 700px; background-color: white; border-radius: 15px; padding: 30px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
        <div class="text-center mb-4">
            <h2 class="h3">Registration</h2>
            <h3 class="fs-6 fw-normal text-secondary m-0">Enter your details to register</h3>
        </div>

        <form action="{{route("register.post")}}" method="POST">
            @csrf
            <div class="row mb-3">
                <div class="col-12 col-md-6 mb-3 mb-md-0">
                    <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control rounded-pill" name="name" id="name" placeholder="Name" required>
                </div>
                <div class="col-12 col-md-6">
                    <label for="username" class="form-label">Username <span class="text-danger">*</span></label>
                    <input type="text" class="form-control rounded-pill" name="username" id="username" placeholder="Username" required>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-12 col-md-6 mb-3 mb-md-0">
                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                    <input type="email" class="form-control rounded-pill" name="email" id="email" placeholder="name@example.com" required>
                </div>
                <div class="col-12 col-md-6">
                    <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                    <input type="password" class="form-control rounded-pill" name="password" id="password" required>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Gender <span class="text-danger">*</span></label>
                <div class="d-flex">
                    <div class="form-check me-3">
                        <input type="radio" class="form-check-input" name="gender" id="genderP" value="P" required>
                        <label for="genderP" class="form-check-label">Female</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" name="gender" id="genderL" value="L" required>
                        <label for="genderL" class="form-check-label">Male</label>
                    </div>
                </div>
            </div>

            <div class="text-center mb-4">
                <button class="btn btn-primary rounded-pill" style="background-color: #ff6219; border-color: #ff6219;" type="submit" name="submit">Sign up</button>
            </div>
        </form>

        
        <p class="text-center" style="font-size:15px;">Already have an account? <a href="{{ route('login') }}" class="link-primary text-decoration-none">Sign in</a></p>
    </div>
</section>

@endsection
