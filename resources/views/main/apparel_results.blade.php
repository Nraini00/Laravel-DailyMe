@include('main.index')

<main class="main-wrapper col-md-9 ms-sm-auto py-4 col-lg-9 px-md-4 border-start">
                <h3>Search Results</h3>
<hr>
                    <!--<h6>Apparel Results</h6>-->
                    @if($apparels->isEmpty())
                        <p>No apparel found.</p>
                    @else
                        <ul>
                            @foreach($apparels as $apparel)
                                <li><b>Name: </b>{{ $apparel->name }}</li>
                                <li><b>Color: </b>{{ $apparel->color }} <span style="display:inline-block; width: 20px; height: 20px; background-color: {{ $apparel->color }}; border: 1px solid #000;"></span>
                                </li>
                                <li><b>Type: </b>{{ $apparel->type_name }}</li>
                                <li><b>Quantity: </b>{{ $apparel->quantity }}</li>
                                <li><b>Price: </b>RM {{ $apparel->price }}</li>
                                <li><b>Brand: </b>{{ $apparel->brand }}</li>
                                <li><b>Remarks: </b>{{ $apparel->remarks }}</li>
                                <li><!-- Display Attachment -->
                                @if($apparel->attachment)
                                    <div class="mt-3">
                                        <strong>Attachment: </strong>
                                         <img src="{{ asset('storage/' . $apparel->attachment) }}" alt="Attachment" class="img-fluid mt-2" style="height:200px;">
                                    </div>
                                @endif
                            </li>
                            @endforeach
                        </ul>
                    @endif
</main>