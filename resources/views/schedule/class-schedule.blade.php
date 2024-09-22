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
        .appointmentForm,
        .viewAppointment{
            display: none;
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
            <div id="viewAppointment">
                <div>
                    <label for="appointment-date">Date:</label>
                    <p id="appointment-date"></p>
                </div>
                <div>
                    <label for="appointment-id">Time:</label>
                    <p id="appointment-time"></p>
                </div>
                <div>
                    <label for="appointment-location">Location:</label>
                    <p id="appointment-location"></p>
                </div>
                <div>
                    <label for="appointment-instructor">Instructor:</label>
                    <p id="appointment-instructor"></p>
                </div>
                <div>
                    <label for="appointment-course">Course:</label>
                    <p id="appointment-course"></p>
                </div>
                <div>
                    <label for="appointment-student">Student:</label>
                    <p id="appointment-student"></p>
                </div>
                <div class="action-btn">
                    <a href="#" id="editButton">
                        Edit
                    </a>
                    <form id="deleteForm" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button class="delete-btn" type="submit" onclick="return confirm('Are you sure you want to delete this course?');">
                            <img src="{{ asset('assets/svgs/delete.svg') }}" alt="Delete">
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var modal = document.getElementById('appointmentModal');
            var viewAppointment = document.getElementById('viewAppointment');
            var appointmentForm = document.getElementById('appointmentForm');
            var modal = document.getElementById('appointmentModal');
            var span = document.getElementsByClassName('close')[0];

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                selectable: true,
                editable: true,
                events: @json($appointments),
                select: function(info) {
                    //open model to add the details
                    openModal(info.startStr, info.endStr); // Open modal on select
                },
                eventClick: function(info) {
                    // Open modal to view the event details
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
                    viewAppointment.style.display = 'block';
                    appointmentForm.style.display = 'none';
                    document.getElementById('modalTitle').innerText = 'View Appointment';
                    document.getElementById('saveButton').innerText = 'Edit';
                    // Fetch and prefill data for editing
                    fetch(`/admin/class-schedule/${scheduleID}/edit`)
                        .then(response => response.json())
                        .then(data => {
                            console.log(data)
                            document.getElementById('appointment-date').innerHTML = data.Date;
                            document.getElementById('appointment-time').innerHTML = data.Time;
                            document.getElementById('appointment-location').innerHTML = data.Location;
                            document.getElementById('appointment-instructor').innerHTML = data.InstructorName;
                            document.getElementById('appointment-course').innerHTML = data.CourseName;
                            document.getElementById('appointment-student').innerHTML = data.StudentName;
                            document.getElementById('deleteForm').action = `/admin/class-schedule/destroy/${data.ClassScheduleID}`;

                            const saveButton = document.getElementById('editButton');
                            saveButton.href = `/admin/class-schedule/${data.ClassScheduleID}/edit-form`;
                        });
                } else {
                    viewAppointment.style.display = 'none';
                    appointmentForm.style.display = 'block';
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
        });
    </script>
</div>
@endsection
