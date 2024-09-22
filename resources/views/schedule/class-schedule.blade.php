@extends('admin.layout')
@section('title', 'Dashboard')
@section('content')
<div class="content-wrapper">
    <style>
        #calendar {
            width: 100%;
            margin: 40px auto;
        }
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
        }
        .modal-content {
            background-color: white;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 40%;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>

    <h1><b>Check Your Appointment</b></h1>

    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                @if (session('success'))
                        <div class="col-sm-12">
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        </div>
                    @endif
            </div>
        </div>
    </div>

    <!-- Calendar -->
    <div id="calendar"></div>

    <!-- Modal for adding/editing appointment -->
    <div id="appointmentModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2 id="modalTitle">Add Appointment</h2>
            <form id="appointmentForm" action="{{ route('admin.classSchedule.store') }}" method="POST" enctype="multipart/form-data" id="entity-form">
                @csrf
                <div>
                    <label for="Date">Date:</label>
                    <input type="date" id="Date" name="Date" required>
                </div>
                <div>
                    <label for="Time">Time:</label>
                    <input type="time" id="Time" name="Time" required>
                </div>
                <div>
                    <label for="Location">Location:</label>
                    <input type="text" id="Location" name="Location" required>
                </div>
                <div>
                    <label for="InstructorID">Instructor:</label>
                    <select id="InstructorID" name="InstructorID" required>
                        <option value="">Select Instructor</option>
                        @foreach ($instructors as $instructor)
                            <option value="{{ $instructor->InstructorID }}">{{ $instructor->Name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="CourseID">Course:</label>
                    <select id="CourseID" name="CourseID" required>
                        <option value="">Select Course</option>
                        @foreach ($courses as $course)
                            <option value="{{ $course->CourseID }}">{{ $course->Name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="StudentID">Student:</label>
                    <select id="StudentID" name="StudentID" required>
                        <option value="">Choose Student</option>
                        @foreach ($students as $student)
                            <option value="{{ $student->StudentID }}">{{ $student->Name }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" id="saveButton">Save</button>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var modal = document.getElementById('appointmentModal');
            var span = document.getElementsByClassName('close')[0];

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                selectable: true,
                editable: true,
                events: @json($appointments),
                select: function(info) {
                    openModal(info.startStr, info.endStr); // Open modal on select
                },
                eventClick: function(info) {
                    // Open modal to edit event
                    openModal(info.event.startStr, info.event.endStr, info.event.id);
                }
            });

            calendar.render();


            // Close modal when clicking the 'X' button
            span.onclick = function() {
                modal.style.display = 'none';
            }

            // Close modal when clicking outside
            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = 'none';
                }
            }

            // Open modal with existing or new data
            function openModal(startDate, endDate, scheduleID = null) {
                modal.style.display = 'block';
                if (scheduleID) {
                    document.getElementById('modalTitle').innerText = 'Edit Appointment';
                    document.getElementById('saveButton').innerText = 'Update';
                    // Fetch and prefill data for editing
                    fetch(`/appointments/${scheduleID}`)
                        .then(response => response.json())
                        .then(data => {
                            document.getElementById('Date').value = data.Date;
                            document.getElementById('Time').value = data.Time;
                            document.getElementById('Location').value = data.Location;
                            document.getElementById('InstructorID').value = data.InstructorID;
                            document.getElementById('CourseID').value = data.CourseID;
                            document.getElementById('StudentID').value = data.StudentID;
                        });
                } else {
                    document.getElementById('modalTitle').innerText = 'Add Appointment';
                    document.getElementById('saveButton').innerText = 'Save';
                    document.getElementById('ClassScheduleID').value = '';
                    document.getElementById('Date').value = startDate;
                    document.getElementById('Time').value = '';
                    document.getElementById('Location').value = '';
                    document.getElementById('InstructorID').value = '';
                    document.getElementById('CourseID').value = '';
                    document.getElementById('StudentID').value = '';
                }
            }

            // // Handle form submission
            // document.getElementById('appointmentForm').onsubmit = function(event) {
            //     event.preventDefault();
            //     var formData = new FormData(this);
            //     var scheduleID = formData.get('ClassScheduleID');
            //     var url = scheduleID ? `/class-schedule/${scheduleID}` : '/admin/class-schedule';
            //     var method = scheduleID ? 'PUT' : 'POST';

            //     fetch(url, {
            //         method: method,
            //         headers: {
            //             'X-CSRF-TOKEN': "{{ csrf_token() }}"
            //         },
            //         body: formData
            //     })
            //     .then(response => {
            //         if (response.ok) {
            //             calendar.refetchEvents(); // Reload events
            //             modal.style.display = 'none'; // Close modal
            //             alert('Appointment saved successfully');
            //         } else {
            //             alert('Failed to save appointment');
            //         }
            //     });
            // }
        });
    </script>
</div>
@endsection
