@include('main.index')

                <main class="main-wrapper col-md-9 ms-sm-auto py-4 col-lg-9 px-md-4 border-start">
                <h3>Search Results</h3>
<hr>

                <!--<h1>Event Search Results</h1>-->

                    @if($events->isEmpty())
                        <p>No events found.</p>
                    @else
                        <ul>
                            @foreach($events as $event)
                            <li><b>Event Name: </b>{{ $event->eventname }}</li>
                            <li><b>Event Location: </b>{{ $event->location }}</li>
                            <li><b>Event Date: </b>{{ $event->datetime }}</li>
                            <li><b>Remarks: </b>{{ $event->remarks }}</li>
                            <li><!-- Display Attachment -->
                                @if($event->attachment)
                                    <div class="mt-3">
                                        <strong>Attachment: </strong>
                                         <img src="{{ asset('storage/' . $event->attachment) }}" alt="Attachment" class="img-fluid mt-2" style="height:200px;">
                                    </div>
                                @endif
                            </li>
                            @endforeach
                        </ul>
                    @endif
</main>