        <!-- CSS FILES -->      
        <link rel="preconnect" href="https://fonts.googleapis.com">
        
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

        <link href="https://fonts.googleapis.com/css2?family=Unbounded:wght@300;400;700&display=swap" rel="stylesheet">

        <link href="css/bootstrap.min.css" rel="stylesheet"> 

        <link href="css/bootstrap-icons.css" rel="stylesheet">

        <link href="css/apexcharts.css" rel="stylesheet">

        <link href="css/tooplate-mini-finance.css" rel="stylesheet">


<header class="navbar sticky-top flex-md-nowrap">
    <div class="col-md-3 col-lg-3 me-0 px-3 fs-6">
                <a class="navbar-brand" href="{{ route('dashboard') }}">
                    <i class="bi-box"></i>
                    Daily Me
                </a>
            </div>
        
        <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <form class="custom-form header-form ms-lg-3 ms-md-3 me-lg-auto me-md-auto order-2 order-lg-0 order-md-0" action="#" method="get" role="form">
                <input class="form-control" name="search" type="text" placeholder="Search" aria-label="Search">
            </form>

            <div class="navbar-nav me-lg-2">
                <div class="nav-item text-nowrap d-flex align-items-center">
                    
                    <div class="dropdown px-3">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="{{ Auth::user()->profileImg ? asset('storage/' . Auth::user()->profileImg) : asset('storage/default.jpg') }}" class="profile-image img-fluid" alt="">
                        </a>
                        <ul class="dropdown-menu bg-white shadow">
                            <li>
                                <div class="dropdown-menu-profile-thumb d-flex">
                                    <img src="{{ Auth::user()->profileImg ? asset('storage/' . Auth::user()->profileImg) : asset('storage/default.jpg') }}" class="profile-image img-fluid me-3" alt="">
                                    
                                    <div class="d-flex flex-column">
                                        <small>{{ Auth::user()->name }}</small>
                                        <a href="#">{{ Auth::user()->email }}</a>
                                    </div>
                                </div>
                            </li>

                            <li>
                                <a class="dropdown-item" href="{{ route('profile') }}">
                                    <i class="bi-person me-2"></i>
                                    Profile
                                </a>
                            </li>

                            <li class="border-top mt-3 pt-2 mx-4">
                                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="dropdown-item ms-0 me-0" style="border: none; background: none; cursor: pointer;">
                                        <i class="bi-box-arrow-left me-2"></i>
                                        Logout
                                    </button>
                                </form>
                            </li>

                        </ul>
                    </div>
                </div>
            </div>
    </header>
              <!-- JAVASCRIPT FILES -->
              <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.bundle.min.js"></script>
        <script src="js/custom.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
