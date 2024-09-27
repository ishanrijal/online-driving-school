@extends('student.layout')
@section('title', 'Invoices')
@section('content')
    <div class="content-wrapper">
        @if(session('success'))
            <div class="row">
                <div class="col-sm-12">
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                </div>
            </div>
        @endif
        <div class="row">
            <div class="col-sm-12">
                <section class="purchases box-shadow">
                    <div class="table-top">
                        <h2 class="title">Enrolled Courses</h2>
                        <div class="search-bar">
                            <input class="search-input" type="text" id="search-course-input" placeholder="Search Enrolled Course">
                            <i class="fa-solid fa-magnifying-glass" id="search-icon"></i>
                        </div>
                    </div>
                    @if($classSchedules->isEmpty())
                        <div class="alert alert-info">
                            You are not enrolled in any courses.
                        </div>
                    @else
                        <table>
                            <thead>
                                <tr>
                                    <th>Course Name</th>
                                    <th>Course Description</th>
                                    <th>Price</th>
                                    <th>Course Enroll Date</th>
                                </tr>
                            </thead>
                            <tbody id="class-schedules-body">
                                @foreach ($classSchedules as $class)
                                    <tr class="class-row">
                                        <td>{{ $class->course->Name }}</td>
                                        <td>{{ $class->course->Description }}</td>
                                        <td>{{ $class->course->Price }}</td>
                                        <td>{{ $class->course->created_at->format('d F Y') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </section>
            </div>
        </div>
    </div>
@endsection

<script type="text/javascript" defer>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.querySelector('#search-course-input'); // Changed ID to reflect course context
        const classRows = document.querySelectorAll('.class-row'); // Updated variable name for clarity
        const tableBody = document.getElementById('class-schedules-body'); // Updated ID for the tbody element

        // Create a "No Result Found" message element
        const noResultMessage = document.createElement('tr');
        noResultMessage.classList.add('no-result');
        noResultMessage.innerHTML = `<td class="alert alert-warning" colspan="4" style="text-align: center;">No course found.</td>`; // Adjusted colspan to match the number of columns
        noResultMessage.style.display = 'none'; // Initially hidden
        tableBody.insertBefore(noResultMessage, tableBody.firstChild); // Insert the no-result message into the table body

        // Function to filter class schedules
        function filterClasses() {
            const searchTerm = searchInput.value.toLowerCase();
            let hasResults = false; // Flag to track if any results are found

            classRows.forEach((row) => {
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

        // Add event listener to filter the class schedules as the user types (on key change)
        searchInput.addEventListener('input', filterClasses);

        // Optional: Expand the search bar when clicked
        searchInput.addEventListener('focus', () => {
            searchBar.classList.add('expanded');
        });
    });
</script>
