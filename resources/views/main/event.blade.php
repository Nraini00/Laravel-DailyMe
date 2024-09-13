<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Your Event</title>

    @vite('resources/css/app.css')

    <!-- CSS FILES -->      
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Unbounded:wght@300;400;700&display=swap" rel="stylesheet">

    <link href="css/bootstrap.min.css" rel="stylesheet"> 
    <link href="css/bootstrap-icons.css" rel="stylesheet">
    <link href="css/apexcharts.css" rel="stylesheet">
    <link href="css/tooplate-mini-finance.css" rel="stylesheet">

</head>

<body style="bg-color: white;">

    @include('main.header')

    <div class="container-fluid">
        <div class="row">
        
        @extends('main.sidenav')
        <main class="main-wrapper col-md-9 ms-sm-auto py-4 col-lg-9 px-md-4 border-start" style="height:100%; bg-color: white;">

        <!-- Here main content -->
        <div class="container">
                <h2 class="text-center">List of Events</h2>
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#eventModal">Add Event</button>
                
                <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for event" title="Type in a name" style="margin-top:5px;">
                
                <table class="table table-bordered mt-2" id="myTable">
                    <thead>
                        <tr>
                            <th>Event Name</th>
                            <th>Location</th>
                            <th>Date Time</th>
                            <th>Remarks</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($events as $event)
                            <tr>
                                <td>{{ $event->eventname }}</td>
                                <td>{{ $event->location }}</td>
                                <td>{{ $event->datetime }}</td>
                                <td>{{ $event->remarks }}</td>
                                <td>
                                    <!-- View Button -->
                                    <button 
                                        type="button" 
                                        class="btn btn-info btn-sm" 
                                        style="width: 70px; height: 30px; font-size: 15px; margin-top: 5px;"
                                        data-bs-toggle="modal" 
                                        data-bs-target="#viewModal-{{ $event->id }}">
                                        View
                                    </button>
                                    <!-- Edit Button -->
                                    <button 
                                            type="button" 
                                            class="btn btn-warning btn-sm" 
                                            style="width: 70px; height: 30px; font-size: 15px; margin-top: 5px;"
                                            data-bs-toggle="modal" 
                                            data-bs-target="#editModal-{{ $event->id }}"
                                            onclick="populateEditModal({{ $event->id }})">
                                            Edit
                                        </button>

                                    <!-- Delete Button -->
                                    <form action="{{ route('event.destroy', $event->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <!-- Modify button to use onclick for confirmation -->
                                        <button 
                                            type="submit" 
                                            onclick="return confirmDelete({{ $event->id }})" 
                                            class="btn btn-danger btn-sm" 
                                            style="width: 70px; height: 30px; font-size: 15px; margin-top: 5px;">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">No events found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>


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

    <button onclick="topFunction()" id="myBtn" title="Go to top">Top</button>

    <!-- Modal HTML for Creating Event -->
    <div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="eventModalLabel">Add Event</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                 <div class="modal-body">
                        <!-- Laravel Form: Route 'events.store' points to EventController@store -->
                        <form action="{{ route('event.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf <!-- Laravel CSRF token for form security -->

                            <div class="form-group">
                                <label for="eventname">Event Name</label>
                                <input type="text" class="form-control" id="eventname" name="eventname" required>
                            </div>

                            <div class="form-group">
                                <label for="location">Location</label>
                                <input type="text" class="form-control" id="location" name="location" required>
                            </div>

                            <div class="form-group">
                                <label for="datetime">Date Time</label>
                                <input type="datetime-local" class="form-control" id="datetime" name="datetime" required>
                            </div>

                            <div class="form-group">
                                <label for="remarks">Remarks</label>
                                <textarea class="form-control" id="remarks" name="remarks" rows="4"></textarea>
                            </div>

                            <div class="form-group">
                                    <label for="attachment">Attachment</label>
                                    <input type="file" class="form-control" id="attachment" name="attachment" onchange="previewImage()">
                                    <div class="mt-2">
                                        <img id="attachmentPreview" src="" alt="Attachment Preview" class="img-fluid" style="max-width: 200px; display: none;">
                                    </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- View Modal -->
        @foreach ($events as $event)
                <div class="modal fade" id="viewModal-{{ $event->id }}" tabindex="-1" aria-labelledby="viewModalLabel-{{ $event->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="viewModalLabel-{{ $event->id }}">Event Details</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p><strong>Event Name:</strong> {{ $event->eventname }}</p>
                                <p><strong>Location:</strong> {{ $event->location }}</p>
                                <p><strong>Date Time:</strong> {{ $event->datetime }}</p>
                                <p><strong>Remarks:</strong> {{ $event->remarks }}</p>

                                <!-- Display Attachment -->
                                @if($event->attachment)
                                    <div class="mt-3">
                                        <strong>Attachment:</strong>
                                        <img src="{{ asset('storage/' . $event->attachment) }}" alt="Attachment" class="img-fluid mt-2">
                                    </div>
                                @endif
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach


            <!-- Modal for Editing Event -->
            @foreach($events as $event)
                <div class="modal fade" id="editModal-{{ $event->id }}" tabindex="-1" aria-labelledby="editModalLabel-{{ $event->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel-{{ $event->id }}">Edit Event</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="editForm-{{ $event->id }}" action="{{ route('event.update', $event->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <label for="eventname">Event Name</label>
                                        <input type="text" class="form-control" id="eventname" name="eventname" value="{{ $event->eventname }}" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="location">Location</label>
                                        <input type="text" class="form-control" id="location" name="location" value="{{ $event->location }}" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="datetime">Date Time</label>
                                        <input type="datetime-local" class="form-control" id="datetime" name="datetime" value="{{ \Carbon\Carbon::parse($event->datetime)->format('Y-m-d\TH:i') }}" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="remarks">Remarks</label>
                                        <textarea class="form-control" id="remarks" name="remarks" rows="4">{{ $event->remarks }}</textarea>
                                    </div>

                                    <div class="form-group">
                                        <label for="attachment">Attachment</label>
                                        <input type="file" class="form-control" id="attachment" name="attachment" onchange="previewImage()">
                                        @if($event->attachment)
                                            <div class="mt-2">
                                                <img id="attachmentPreview-{{ $event->id }}" src="{{ asset('storage/' . $event->attachment) }}" alt="Attachment Preview" class="img-fluid" style="max-width: 200px;">
                                            </div>
                                        @endif
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
    @endforeach


<script type="text/javascript">

function populateEditModal(id) {
    // You can use AJAX to populate the modal form with the selected apparel's data if needed
    // Example:
    $.ajax({
    url: '/event/' + id + '/edit',
    method: 'GET',
    success: function(data) {
    $('#editForm-' + id).find('input[name="name"]').val(data.name);
    //         // Populate other fields
    }
    });
}

function confirmDelete(id) {
    return confirm('Are you sure you want to delete this item with ID ' + id + '?');
}

function previewImage() {
    const fileInput = document.getElementById('attachment');
    const preview = document.getElementById('attachmentPreview');

    if (fileInput.files && fileInput.files[0]) {
        const reader = new FileReader();

        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        }

        reader.readAsDataURL(fileInput.files[0]);
    } else {
        preview.src = '';
        preview.style.display = 'none';
    }
}

// Function to show or hide the button based on scroll position
function scrollFunction() {
    const mybutton = document.getElementById("myBtn");
    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
      mybutton.style.display = "block";
    } else {
      mybutton.style.display = "none";
    }
  }
  
  // Function to scroll to the top of the document
  function topFunction() {
    document.body.scrollTop = 0; // For Safari
    document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE, and Opera
  }


  // for search function in every list page
function myFunction() {
    var input, filter, table, tr, td, i, j, txtValue;
    input = document.getElementById("myInput");
    filter = input.value.toUpperCase();
    table = document.getElementById("myTable");
    tr = table.getElementsByTagName("tr");

    for (i = 1; i < tr.length; i++) {  // Start from 1 to skip the header row
        tr[i].style.display = "none";  // Initially hide all rows
        td = tr[i].getElementsByTagName("td");
        for (j = 0; j < td.length; j++) {  // Loop through all cells in the row
            if (td[j]) {
                txtValue = td[j].textContent || td[j].innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";  // Show the row if a match is found
                    break;  // No need to check other cells in the row
                }
            }
        }
    }
}

</script>


     <!-- JAVASCRIPT FILES -->
     <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/custom.js"></script>

</body>
</html>
