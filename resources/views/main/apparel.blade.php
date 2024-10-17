
@include('main.index')

            <main class="main-wrapper col-md-9 ms-sm-auto py-4 col-lg-9 px-md-4 border-start" style="height:100%;">

            <!-- Here main content -->
            <div class="container mt-4">
                <h3 class="text-center">Your Wardrobe List</h3>
                <button class="btn btn-success mb-2" data-bs-toggle="modal" data-bs-target="#addApparelModal">Add Apparel</button>
                
                <br><input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for apparel" title="Type in a name">
                
                <table class="table table-bordered" id="myTable" style="margin-top:5px;">
                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>Name</th>
                            <th>Color</th>
                            <th>Quantity</th>
                            <th>Purchase Date</th>
                            <th>Price</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($apparels as $apparel)
                        <tr>
                            <td>{{ $apparel->type->type_name }}</td>
                            <td>{{ $apparel->name }}</td>
                            <td style="background-color: {{ $apparel->color }}"></td>
                            <td>{{ $apparel->quantity }}</td>
                            <td>{{ $apparel->purchase_date }}</td>
                            <td>RM {{ $apparel->price }}</td>
                            <td>
                                <!-- View Button -->
                                <button 
                                    type="button" 
                                    class="btn btn-info btn-sm" 
                                    style="width: 70px; height: 30px; font-size: 15px; margin-top: 5px;"
                                    data-bs-toggle="modal" 
                                    data-bs-target="#viewModal-{{ $apparel->id }}">
                                    View
                                </button>
                                <!-- Edit Button -->
                                <button 
                                        type="button" 
                                        class="btn btn-warning btn-sm" 
                                        style="width: 70px; height: 30px; font-size: 15px; margin-top: 5px;"
                                        data-bs-toggle="modal" 
                                        data-bs-target="#editModal-{{ $apparel->id }}"
                                        onclick="populateEditModal({{ $apparel->id }})">
                                        Edit
                                    </button>

                                <!-- Delete Button -->
                                <form action="{{ route('apparel.destroy', $apparel->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <!-- Modify button to use onclick for confirmation -->
                                    <button 
                                        type="submit" 
                                        onclick="return confirmDelete({{ $apparel->id }})" 
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


        <!-- Modal for Adding Apparel -->
        <div class="modal fade" id="addApparelModal" tabindex="-1" role="dialog" aria-labelledby="addApparelModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addApparelModalLabel">Add Apparel</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                        <form action="{{ route('apparel.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                                <!-- Hidden User ID Field -->
                                <input type="hidden" id="user_id" name="user_id" value="{{ auth()->id() }}">
                                <div class="form-group">
                                    <label for="type_id">Type</label>
                                    <select class="form-control" id="type_id" name="type_id" required>
                                        <option value="" disabled selected>Select a Type</option>
                                        @foreach($types as $type)
                                        <option value="{{ $type->id }}">{{ $type->type_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="name">Apparel Name</label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>
                                <div class="form-group">
                                    <label for="color">Color</label>
                                    <input type="color" class="form-control" id="color" name="color" required>
                                </div>
                                <div class="form-group">
                                    <label for="quantity">Quantity</label>
                                    <input type="number" class="form-control" id="quantity" name="quantity" min="1" required>
                                </div>
                                <div class="form-group">
                                    <label for="purchase_date">Purchase Date</label>
                                    <input type="date" class="form-control" id="purchase_date" name="purchase_date" required>
                                </div>
                                <div class="form-group">
                                    <label for="price">Price (RM)</label>
                                    <input type="text" class="form-control" id="price" name="price" required>
                                </div>
                                <div class="form-group">
                                    <label for="brand">Brand</label>
                                    <input type="text" class="form-control" id="brand" name="brand" required>
                                </div>
                                <div class="form-group">
                                    <label for="remarks">Remarks</label>
                                    <textarea class="form-control" id="remarks" name="remarks"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="attachment">Attachment</label>
                                    <input type="file" class="form-control" id="attachment" name="attachment" onchange="previewImage()">
                                    <div class="mt-2">
                                        <img id="attachmentPreview" src="" alt="Attachment Preview" class="img-fluid" style="max-width: 200px; display: none;">
                                        <button type="button" id="cancelAttachment" class="btn btn-danger mt-2"  onclick="removeAttachment()">Cancel</button>
                                    </div>
                                </div>
                                <br>
                                <button type="submit" class="btn btn-primary" style="float:right;">Add Apparel</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- View Modal -->
            @foreach ($apparels as $apparel)
                <div class="modal fade" id="viewModal-{{ $apparel->id }}" tabindex="-1" aria-labelledby="viewModalLabel-{{ $apparel->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="viewModalLabel-{{ $apparel->id }}">Apparel Details</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p><strong>Name:</strong> {{ $apparel->name }}</p>
                                <p><strong>Color:</strong> {{ $apparel->color }}</p>
                                <p><strong>Quantity:</strong> {{ $apparel->quantity }}</p>
                                <p><strong>Purchase Date:</strong> {{ $apparel->purchase_date }}</p>
                                <p><strong>Price:</strong> RM {{ $apparel->price }}</p>
                                <p><strong>Brand:</strong> {{ $apparel->brand }}</p>
                                <p><strong>Remarks:</strong> {{ $apparel->remarks }}</p>

                                <!-- Display Attachment -->
                                @if($apparel->attachment)
                                    <div class="mt-3">
                                        <strong>Attachment:</strong>
                                        <img src="{{ asset('storage/' . $apparel->attachment) }}" alt="Attachment" class="img-fluid mt-2" style="height:200px;">
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

             <!-- Modal for Editing Apparel -->
            @foreach($apparels as $apparel)
            <div class="modal fade" id="editModal-{{ $apparel->id }}" tabindex="-1" aria-labelledby="editModalLabel-{{ $apparel->id }}" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel-{{ $apparel->id }}">Edit Apparel</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('apparel.update', $apparel->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="type_id">Type</label>
                                    <select class="form-control" id="type_id" name="type_id" required>
                                        @foreach($types as $type)
                                            <option value="{{ $type->id }}" {{ $apparel->type_id == $type->id ? 'selected' : '' }}>
                                                {{ $type->type_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="name">Apparel Name</label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ $apparel->name }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="color">Color</label>
                                    <input type="color" class="form-control" id="color" name="color" value="{{ $apparel->color }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="quantity">Quantity</label>
                                    <input type="number" class="form-control" id="quantity" name="quantity" value="{{ $apparel->quantity }}" min="1" required>
                                </div>
                                <div class="form-group">
                                    <label for="purchase_date">Purchase Date</label>
                                    <input type="date" class="form-control" id="purchase_date" name="purchase_date" value="{{ $apparel->purchase_date }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="price">Price (RM)</label>
                                    <input type="text" class="form-control" id="price" name="price" value="{{ $apparel->price }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="brand">Brand</label>
                                    <input type="text" class="form-control" id="brand" name="brand" value="{{ $apparel->brand }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="remarks">Remarks</label>
                                    <textarea class="form-control" id="remarks" name="remarks">{{ $apparel->remarks }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="attachment">Attachment</label>
                                    <input type="file" class="form-control" id="attachment" name="attachment">
                                    @if($apparel->attachment)
                                        <div class="mt-2">
                                            <label>Current Attachment:</label>
                                            <img src="{{ asset('storage/' . $apparel->attachment) }}" alt="Attachment" class="img-fluid" style="max-width: 200px;">
                                        </div>
                                    @endif
                                </div>
                                <br>
                                <button type="submit" class="btn btn-primary">Update Apparel</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach




         <!-- JAVASCRIPT FILES -->
         <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.bundle.min.js"></script>

<script type="text/javascript">

function populateEditModal(id) {
    // You can use AJAX to populate the modal form with the selected apparel's data if needed
    // Example:
    $.ajax({
    url: '/apparel/' + id + '/edit',
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

function removeAttachment() {
    const fileInput = document.getElementById('attachment');
    const preview = document.getElementById('attachmentPreview');
    const cancelButton = document.getElementById('cancelAttachment');

    fileInput.value = ''; // Clear the file input
    preview.src = '';
    preview.style.display = 'none';
    cancelButton.style.display = 'none';
}
</script>

