
@include('main.index')

                <main class="main-wrapper col-md-9 ms-sm-auto py-4 col-lg-9 px-md-4 border-start">
                <h3>Search Results</h3>
<hr>

                    <!-- <h6>Budget Results</h6>-->
                    @if($budgets->isEmpty())
                        <p>No budget found.</p>
                    @else
                        <ul>
                            @foreach($budgets as $budget)
                                <li><b>Title: </b>{{ $budget->title }}</li>
                                <li><b>Category: </b>{{ $budget->category_name }}</li>
                                <li><b>Amount: </b>RM {{ $budget->amount }}</li>
                                <li><b>Date: </b>{{ $budget->date }}</li>
                                <li><b>Remarks: </b>{{ $budget->remarks }}</li>
                                <li><b>Event Name: </b>{{ $budget->event->eventname ?? 'N/A' }}</li>
                                <li><b>Apparel Name: </b>{{ $budget->apparel->name ?? 'N/A' }}</li>
                                
                            @endforeach
                        </ul>
                    @endif

</main>
