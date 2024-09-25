@extends('instructor.layout')
@section('title', 'Dashboard')
@section('content')
    <div class="row">
        @if (session('success'))
            <div class="col-sm-12">
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            </div>
        @endif
    </div>
    <div class="row dashboard-insight">
        <h2 class="title">Overview</h2>
        <div class="col-sm-12">
            <section class="overview">
                <div class="card">
                    <h4>Month Revenue</h4>
                    <h2>$90k</h2>
                    <p>March 2023</p>
                    <span class="change positive">+ 37.43%</span>
                </div>
                <div class="card">
                    <h4>Today's Classes</h4>
                    <h2>
                        @if($today_appointments->count() > 0)
                            {{$today_appointments->count()}}
                        @else
                            0
                        @endif
                    </h2>
                    <p>Aug 13 - Sep 13</p>
                    <span class="change positive">+ 37.43%</span>
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
                    <span class="change negative">- 13.43%</span>
                </div>
            </section>
        </div>
    </div>
    <div class="separator"></div>
    <div class="row box-shadow ">
        <div class="col-sm-12">
            <section class="purchases">
                <div class="table-top">
                    <h2 class="title">Today's Classes</h2>
                    <div class="search-bar">
                        <input type="text" id="search-input" placeholder="Search Class Schedule">
                        <i class="fa-solid fa-magnifying-glass" id="search-icon"></i>
                    </div>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>Student's Name</th>
                            <th>Class Time</th>
                            <th>Location</th>
                            <th>Course</th>
                            <th>Course Description</th>
                        </tr>
                    </thead>
                    <tbody id="appointments-body">
                        @foreach ( $today_appointments as $appointment )
                            <tr class="appointment-row">
                                <td>{{$appointment->student->Name}}</td>
                                <td>{{$appointment->Time}}</td>
                                <td>{{$appointment->Location}}</td>
                                <td>{{$appointment->Course->Name}}</td>
                                <td>{{$appointment->Course->Description}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </section>
        </div>
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