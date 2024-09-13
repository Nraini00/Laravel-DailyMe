<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>My Expenses</title>

    @vite('resources/css/app.css')
    <!-- CSS FILES -->      
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Unbounded:wght@300;400;700&display=swap" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-icons.css" rel="stylesheet">
    <link href="css/tooplate-mini-finance.css" rel="stylesheet">
    
</head>
    
<body>
    @include('main.header')

    <div class="container-fluid">
        <div class="row">

            @extends('main.sidenav')

            <!-- Here is the main content -->
            <main class="main-wrapper col-md-9 ms-sm-auto py-4 col-lg-9 px-md-4 border-start">
                <div class="container mt-4">
                    <h4 class="text-center">My Expenses</h4>
                    <button class="btn btn-success mb-2" data-bs-toggle="modal" data-bs-target="#addExpense">Add Expense</button>

                    <br><input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for expenses" title="Type in a name">

                    <table class="table table-bordered" id="myTable" style="margin-top:5px;">
                        <thead>
                            <tr>
                                <th>Category Name</th>
                                <th>Title</th>
                                <th>Amount</th>
                                <th>Date</th>
                                <th>Remarks</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($budgets as $budget)
                            <tr>
                                <td>{{ $budget->category->name }}</td>
                                <td>{{ $budget->title }}</td>
                                <td>RM{{ $budget->amount }}</td>
                                <td>{{ $budget->date }}</td>
                                <td>{{ $budget->remarks }}</td>
                                <td>
                                    <!-- View Button -->
                                    <button 
                                        type="button" 
                                        class="btn btn-info btn-sm" 
                                        style="width: 70px; height: 30px; font-size: 15px; margin-top: 5px;"
                                        data-bs-toggle="modal" 
                                        data-bs-target="#viewModal-{{ $budget->id }}">
                                        View
                                    </button>
                                    <!-- Edit Button -->
                                    <button 
                                        type="button" 
                                        class="btn btn-warning btn-sm" 
                                        style="width: 70px; height: 30px; font-size: 15px; margin-top: 5px;"
                                        data-bs-toggle="modal" 
                                        data-bs-target="#editModal-{{ $budget->id }}">
                                        Edit
                                    </button>

                                    <!-- Delete Button -->
                                    <form action="{{ route('budget.destroy', $budget->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button 
                                            type="submit" 
                                            onclick="return confirmDelete({{ $budget->id }})" 
                                            class="btn btn-danger btn-sm" 
                                            style="width: 70px; height: 30px; font-size: 15px; margin-top: 5px;">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
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

    <!-- Modal HTML for Adding Expense -->
    <div class="modal fade" id="addExpense" tabindex="-1" aria-labelledby="expenseModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="expenseModalLabel">Add Expense</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Laravel Form: Route 'budget.store' points to BudgetController@store -->
                    <form action="{{ route('budget.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <!-- Hidden User ID Field -->
                        <input type="hidden" id="user_id" name="user_id" value="{{ auth()->id() }}">
                        <div class="form-group">
                            <label for="category_id">Category</label>
                            <select class="form-control" id="category_id" name="category_id" required>
                            <option value="" disabled selected>Select a Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>
                        <div class="form-group">
                            <label for="amount">Amount (RM)</label>
                            <input type="text" class="form-control" id="amount" name="amount" required>
                        </div>
                        <div class="form-group">
                            <label for="date">Date</label>
                            <input type="date" class="form-control" id="date" name="date" required>
                        </div>
                        <div class="form-group">
                            <label for="remarks">Remarks</label>
                            <textarea class="form-control" id="remarks" name="remarks" rows="4"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="event_id">Event List</label>
                            <select class="form-control" id="event_id" name="event_id">
                            <option value="" disabled selected>Select a Event</option>
                                @foreach($events as $event)
                                    <option value="{{ $event->id }}">{{ $event->eventname }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="apparel_id">Apparel Name</label>
                            <select class="form-control" id="apparel_id" name="apparel_id">
                            <option value="" disabled selected>Select a Apparel</option>
                                @foreach($apparels as $apparel)
                                    <option value="{{ $apparel->id }}">{{ $apparel->name }}</option>
                                @endforeach
                            </select>
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
        @foreach ($budgets as $budget)
        <div class="modal fade" id="viewModal-{{ $budget->id }}" tabindex="-1" aria-labelledby="viewModalLabel-{{ $budget->id }}"  aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="viewModalLabel-{{ $budget->id }}">Expense Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p><strong>Category:</strong> {{ $budget->category->name ?? 'N/A' }}</p>
                        <p><strong>Title:</strong> {{ $budget->title }}</p>
                        <p><strong>Amount: RM</strong> {{ $budget->amount }}</p>
                        <p><strong>Date:</strong> {{ $budget->date }}</p>
                        <p><strong>Remarks:</strong> {{ $budget->remarks }}</p>
                        <p><strong>Event Name:</strong> {{ $budget->event->eventname ?? 'N/A' }}</p>
                        <p><strong>Apparel Name:</strong> {{ $budget->apparel->name ?? 'N/A' }}</p>
                        <div id="modal-attachment" class="mt-3" style="display: none;">
                            <strong>Attachment:</strong>
                            <img id="attachment-preview" src="" alt="Attachment" class="img-fluid mt-2">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        @endforeach

    <!-- Modal for Editing Expense -->
    @foreach($budgets as $budget)
        <div class="modal fade" id="editModal-{{ $budget->id }}" tabindex="-1" aria-labelledby="editModalLabel-{{ $budget->id }}" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel-{{ $budget->id }}">Edit Expense</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('budget.update', $budget->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="category_id">Category</label>
                                <select class="form-control" id="category_id" name="category_id" required>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ $category->id == $budget->category_id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" class="form-control" id="title" name="title" value="{{ $budget->title }}" required>
                            </div>
                            <div class="form-group">
                                <label for="amount">Amount (RM)</label>
                                <input type="number" class="form-control" id="amount" name="amount" value="{{ $budget->amount }}" required>
                            </div>
                            <div class="form-group">
                                <label for="date">Date</label>
                                <input type="date" class="form-control" id="date" name="date" value="{{ date('Y-m-d', strtotime($budget->date)) }}" required>
                            </div>

                            <div class="form-group">
                                <label for="remarks">Remarks</label>
                                <textarea class="form-control" id="remarks" name="remarks" rows="4">{{ $budget->remarks }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="event_id">Event</label>
                                <select class="form-control" id="event_id" name="event_id">
                                <option value="" disabled selected>Select a Event</option>
                                    @foreach($events as $event)
                                        <option value="{{ $event->id }}" {{ $event->id == $budget->event_id ? 'selected' : '' }}>
                                            {{ $event->eventname }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="apparel_id">Apparel</label>
                                <select class="form-control" id="apparel_id" name="apparel_id">
                                <option value="" disabled selected>Select a Apparel</option>
                                    @foreach($apparels as $apparel)
                                        <option value="{{ $apparel->id }}" {{ $apparel->id == $budget->apparel_id ? 'selected' : '' }}>
                                            {{ $apparel->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="attachment">Attachment</label>
                                <input type="file" class="form-control" id="attachment" name="attachment">
                                @if($budget->attachment)
                                    <div class="mt-2">
                                        <img src="{{ asset('storage/' . $budget->attachment) }}" alt="Attachment Preview" class="img-fluid" style="max-width: 200px;">
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

    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/jquery.min.js"></script>


<script>
        function populateEditModal(id) {
        // You can use AJAX to populate the modal form with the selected apparel's data if needed
        // Example:
        $.ajax({
        url: '/budget/' + id + '/edit',
        method: 'GET',
        success: function(data) {
        $('#editForm-' + id).find('input[name="name"]').val(data.name);
        //         // Populate other fields
        }
        });
        }
        function previewImage() {
            const file = document.getElementById('attachment').files[0];
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('attachmentPreview').src = e.target.result;
                document.getElementById('attachmentPreview').style.display = 'block';
            }
            if (file) {
                reader.readAsDataURL(file);
            }
        }

        function confirmDelete(id) {
            return confirm('Are you sure you want to delete this expense?');
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
</body>
</html>
