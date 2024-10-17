
@include('main.index')

            <!-- Here is the main content -->
            <main class="main-wrapper col-md-9 ms-sm-auto py-4 col-lg-9 px-md-4 border-start">
                <div class="container mt-4">
                    <h4 class="text-center">My Wallet</h4>
                    <br>
                    <button class="btn btn-success mb-2" data-bs-toggle="modal" data-bs-target="#addWallet">Add Wallet Amount</button>
                    <br><input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for expenses" title="Type in a name">

                    <table class="table table-bordered" id="myTable" style="margin-top:5px;">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Details</th>
                                <th>Amount</th>
                                <th>Balance</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($wallets as $wallet)
                            <tr>
                                <td>{{ $wallet->date }}</td>
                                <td>{{ $wallet->details }}</td>
                                <td>RM{{ $wallet->amount }}</td>
                                <td>{{ $wallet->balance }}</td>
                                <td>
                                    <!-- Edit Button -->
                                    <button 
                                        type="button" 
                                        class="btn btn-warning btn-sm" 
                                        style="width: 70px; height: 30px; font-size: 15px; margin-top: 5px;"
                                        data-bs-toggle="modal" 
                                        data-bs-target="#editModal-{{ $wallet->id }}">
                                        Edit
                                    </button>

                                    <!-- Delete Button -->
                                    <form action="{{ route('wallet.destroy', $wallet->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button 
                                            type="submit" 
                                            onclick="return confirmDelete({{ $wallet->id }})" 
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


 <!-- Modal HTML for Adding wallet -->
 <div class="modal fade" id="addWallet" tabindex="-1" aria-labelledby="walletModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="walletModalLabel">Add Wallet</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Laravel Form: Route 'wallet.store' points to WalletController@store -->
                    <form action="{{ route('wallet.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <!-- Hidden User ID Field -->
                        <input type="hidden" id="user_id" name="user_id" value="{{ auth()->id() }}">
                        <div class="form-group">
                            <label for="title">Details</label>
                            <input type="text" class="form-control" id="details" name="details" required>
                        </div>
                        <div class="form-group">
                            <label for="amount">Amount (RM)</label>
                            <input type="text" class="form-control" id="amount" name="amount" required>
                        </div>
                        <div class="form-group">
                            <label for="date">Date</label>
                            <input type="date" class="form-control" id="date" name="date" required>
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


    <!-- Modal for Editing Wallet -->
    @foreach($wallets as $wallet)
        <div class="modal fade" id="editModal-{{ $wallet->id }}" tabindex="-1" aria-labelledby="editModalLabel-{{ $wallet->id }}" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel-{{ $wallet->id }}">Edit Expense</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('wallet.update', $wallet->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="title">Details</label>
                                <input type="text" class="form-control" id="details" name="details" value="{{ $wallet->details }}" required>
                            </div>
                            <div class="form-group">
                                <label for="amount">Amount (RM)</label>
                                <input type="number" class="form-control" id="amount" name="amount" value="{{ $wallet->amount }}" required>
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
        url: '/wallet/' + id + '/edit',
        method: 'GET',
        success: function(data) {
        $('#editForm-' + id).find('input[name="name"]').val(data.name);
        //         // Populate other fields
        }
        });
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

