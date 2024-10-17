<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">


        <title>Your Wardrobe</title>
        @vite('resources/js/daily.js')

        
        <!-- CSS FILES -->      
    <!-- CSS FILES -->      
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Unbounded:wght@300;400;700&display=swap" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-icons.css" rel="stylesheet">
    <link href="css/tooplate-mini-finance.css" rel="stylesheet">
    

    </head>
    
    <body style="background-color: white;">

        @include('navbar.header')

        <div class="container-fluid">
            <div class="row">
            
            @extends('navbar.sidenav')
            <main class="main-wrapper col-md-9 ms-sm-auto py-4 col-lg-9 px-md-4 border-start" style="height:100%; background-color:white;">

            <h1 class="h2 mb-0">Profile Details</h1>
            <hr>
            
            <!-- Profile Section -->
            <div style="display: flex; align-items: center;">

            <!-- Profile Image Section -->
            <div style="margin-right: 20px;">
                <p style="font-weight:bold;">Profile Image</p>
                <img id="profileImage" src="{{ Auth::user()->profileImg ? asset('storage/' . Auth::user()->profileImg) : asset('storage/default.jpg') }}" alt="Profile Image" style="max-width: 150px; border-radius: 50%;">
                <br>
                <form id="profileImageForm" enctype="multipart/form-data">
                    <br>
                    <input type="file" name="profileImg" id="profileImgInput" accept="image/*">
                    <br><br>
                    <button type="submit">Update Image</button>
                </form>
                <p id="updateMessage"></p>
            </div>

            <!-- Profile Details Section -->
            <div>
                <p><b>Name: </b> {{ Auth::user()->name }}</p>
                <p><b>Username: </b> {{ Auth::user()->username }}</p>
                <p><b>Email: </b> {{ Auth::user()->email }}</p>
                <p><b>Gender: </b> {{ Auth::user()->gender }}</p>
                
                <!-- Edit Button -->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                    Edit Details
                </button>
            </div>

            </div>
            
            


            <hr>
            <footer class="site-footer">
                        <div class="container">
                            <div class="row">
                                
                                <div class="col-lg-12 col-12">
                                    <p class="copyright-text">Copyright © Daily Me 2024 </p>
                                </div>

                            </div>
                        </div>
            </footer>
            </main>
         </div>

        
        </div>

<!-- Modal HTML for Editing User Details -->
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProfileModalLabel">Edit Profile Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editProfileForm" action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Name Input -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ Auth::user()->name }}" required>
                    </div>

                    <!-- Username Input -->
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" value="{{ Auth::user()->username }}" required>
                    </div>

                    <!-- Email Input -->
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ Auth::user()->email }}" required>
                    </div>

                    <!-- Gender Input -->
                    <div class="mb-3">
                        <label for="gender" class="form-label">Gender</label>
                        <div class="form-check me-3">
                            <input type="radio" class="form-check-input" name="gender" id="genderP" value="P" {{ Auth::user()->gender == 'P' ? 'checked' : '' }} required>
                            <label class="form-check-label" for="genderP">Female</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="gender" id="genderL" value="L" {{ Auth::user()->gender == 'L' ? 'checked' : '' }} required>
                            <label class="form-check-label" for="genderL">Male</label>
                        </div>
                    </div>


                    <button type="submit" class="btn btn-success">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>




         <!-- JAVASCRIPT FILES -->
         <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.bundle.min.js"></script>

<script>
$(document).ready(function() {
    // Set the CSRF token in the header for all AJAX requests
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#profileImageForm').on('submit', function(e) {
        e.preventDefault();
        
        var formData = new FormData(this);
        $.ajax({
            url: '{{ route('updateProfileImage') }}', // Route to handle the image upload
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    $('#profileImage').attr('src', response.imagePath); // Update profile image
                    $('#updateMessage').text('Profile image updated successfully.');
                } else {
                    $('#updateMessage').text('Failed to update image.');
                }
            },
            error: function(xhr) {
                $('#updateMessage').text('An error occurred while uploading.');
            }
        });
    });
});

</script>


    </body>
    </html>