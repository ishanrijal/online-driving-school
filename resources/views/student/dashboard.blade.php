@extends('student.layout')
@section('title', 'Dashboard')
@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    @if (session('success'))
                        <div class="col-sm-12">
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        </div>
                    @endif
                    @if (session('course_error'))
                        <div class="col-sm-12">
                            <div class="alert alert-success">
                                {{ session('course_error') }}
                            </div>
                        </div>
                    @endif
                </div>
                <div class="row dashboard-insight">
                    <h2 class="title">Overview</h2>
                    <div class="col-sm-12">
                        <section class="overview">
                            <div class="card">
                                <h4>Amount To Pay</h4>
                                <h2>${{ ($invoices->sum('TotalAmount') > 0 ) ? $invoices->sum('TotalAmount') : 0  }}</h2>
                                @if ($invoices->isNotEmpty())
                                    <p>{{ date('F Y', strtotime($invoices->last()->created_at)) }}</p>
                                @else
                                    <p>No invoices available</p>
                                @endif
                                <span class="change positive">Last Invoice Generated</span>
                            </div>
                            <div class="card">
                                <h4>Unpaid Invoices</h4>
                                <h2>
                                    @if($invoices->count() > 0)
                                        {{$invoices->count()}}
                                    @else
                                        0
                                    @endif
                                </h2>
                                <p>{{ date('F Y') }}</p>
                                @if($appointments->count() > 0)
                                    <span class="change negative"><strong> Please settle your outstanding dues.</strong></span>
                                @else
                                    <span class="change positive"><strong>All invoices have been paid!</strong></span>
                                @endif
                            </div>
                            <div class="card">
                                <h4>Total Classes</h4>
                                <h2>
                                    @if($appointments->count() > 0)
                                        {{$appointments->count()}}
                                    @else
                                        0
                                    @endif
                                </h2>
                                <p>{{ date('F Y') }}</p>
                                <span class="change negative">
                                    @if($appointments->count() > 0)
                                        Number of classes left
                                    @else 
                                        No More classes
                                    @endif
                                </span>
                            </div>
                        </section>
                    </div>
                </div>
                <div class="separator"></div>
                <div class="row">
                    <div class="col-sm-8">
                        <section class="purchases box-shadow">
                            <div class="table-top">
                                <h2 class="title">Today's Classes</h2>
                                <div class="search-bar">
                                    <input class="search-input" type="text" id="search-input" placeholder="Search Class Schedule">
                                    <i class="fa-solid fa-magnifying-glass" id="search-icon"></i>
                                </div>
                            </div>
                            @if($today_appointments->isEmpty())
                                <div class="alert alert-info">
                                    No Classes Today
                                </div>
                            @else
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Instructor's Name</th>
                                            <th>Class Time</th>
                                            <th>Location</th>
                                            <th>Course</th>
                                        </tr>
                                    </thead>
                                    <tbody id="appointments-body">
                                        @foreach ( $today_appointments as $appointment )
                                            <tr class="appointment-row">
                                                <td>{{$appointment->instructor->Name}}</td>
                                                <td>{{$appointment->Time}}</td>
                                                <td>{{$appointment->Location}}</td>
                                                <td>{{$appointment->Course->Name}}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif
                        </section>
                    </div>
                    <div class="col-sm-4" style="padding-right:0">
                        <section class="purchases box-shadow">
                            <div class="table-top">
                                <h2 class="title">Unpaid Invoice</h2>
                            </div>

                            @if($invoices->isEmpty())
                                <div class="alert alert-success">
                                    All invoices have been paid.
                                </div>
                            @else         
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Invoice Due Date</th>
                                            <th>Invoice Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ( $invoices as $invoice )
                                                <td>{{date( 'd M Y', strtotime($invoice->Date)) }}</td>
                                                <td>{{$invoice->TotalAmount}}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif
                        </section>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

<script type="text/javascript" defer>
    document.addEventListener('DOMContentLoaded', function () {
        // Your code here
        const searchInput = document.querySelector('#search-input');
        const searchBar = document.querySelector('.search-bar');
        const appointmentRows = document.querySelectorAll('.appointment-row');

        const tableBody = document.getElementById('appointments-body');

        // Create a "No Result Found" message element
        const noResultMessage = document.createElement('tr');
        noResultMessage.classList.add('no-result');
        noResultMessage.innerHTML = `<td colspan="5" style="text-align: center;">No result found</td>`;
        noResultMessage.style.display = 'none'; // Initially hidden
        tableBody.insertBefore(noResultMessage, tableBody.firstChild);

        // Function to filter appointments
        function filterAppointments() {
        const searchTerm = searchInput.value.toLowerCase();
        let hasResults = false; // Flag to track if any results are found

        appointmentRows.forEach((row) => {
            // Get all the td elements in the current row
            const cells = row.querySelectorAll('td');
            let rowMatches = false; // Flag to track if the current row matches

            // Loop through each cell in the row
            cells.forEach((cell) => {
                if (cell.textContent.toLowerCase().includes(searchTerm)) {
                    rowMatches = true; // Set the flag to true if a match is found
                }
            });

            // Show or hide the row based on whether a match was found
            if (rowMatches) {
                row.style.display = ''; // Show the row if it matches
                hasResults = true; // Set the overall results flag to true
            } else {
                row.style.display = 'none'; // Hide the row if it doesn't match
            }
        });

        // Show or hide the no result message based on search results
        noResultMessage.style.display = hasResults ? 'none' : ''; // Show/hide the no result message
    }

    // Add event listener to filter the appointments as the user types (on key change)
    searchInput.addEventListener('input', filterAppointments);

    // Optional: Expand the search bar when clicked
    searchInput.addEventListener('focus', () => {
        searchBar.classList.add('expanded');
    });
});

</script>