@php
    $user = Auth::user();
    if ($user->role == 'admin' || $user->role == 'superadmin') {
        $role = 'admin';
        $addClassRoute = route('admin.classSchedule.store');
    }  else{
        $role = 'staff';
        $addClassRoute = route('staff.classSchedule.store');
    } 
@endphp

@extends($role. '.layout')
@section('title', 'Time Table')
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
            display: flex;
            justify-content: flex-end;
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
        #viewAppointment {
            padding: 20px;
            border-radius: 8px;
            width: 100%;
            margin: 20px auto;
        }

        #viewAppointment div {
            margin-bottom: 15px;
        }

        #viewAppointment label {
            font-weight: bold;
            color: #333;
            display: block;
            margin-bottom: 5px;
        }

        #viewAppointment p {
            font-size: 16px;
            color: #666;
            margin: 0;
            padding: 5px;
            background-color: #fff;
            border-radius: 4px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            padding-left: 10px;
        }

        .action-btn {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px;
        }

        #editButton {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 14px;
            transition: background-color 0.3s ease;
        }

        #editButton:hover {
            background-color: #45a049;
        }

        .delete-btn {
            background-color: #f44336;
            border: none;
            color: white;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .delete-btn:hover {
            background-color: #e53935;
        }

        img[alt="Delete"] {
            width: 16px;
            height: 16px;
            vertical-align: middle;
        }


        /* Form */
        #appointmentForm {
            padding: 20px;
            border-radius: 10px;
            width: 100%
            margin: 20px auto;
        }

        #modalTitle {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        #appointmentForm div {
            margin-bottom: 15px;
        }

        #appointmentForm label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
            color: #333;
        }

        #appointmentForm input,
        #appointmentForm select {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            color: #333;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #fff;
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        #appointmentForm input:focus,
        #appointmentForm select:focus {
            outline: none;
            border-color: #F91942;
            box-shadow: 0 0 5px rgba(249, 25, 66, 0.5);
        }

        #saveButton {
            display: block;
            width: 100%;
            padding: 12px;
            font-size: 16px;
            font-weight: bold;
            color: white;
            background-color: #F91942;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-top: 20px;
        }

        #saveButton:hover {
            background-color: #e6163a;
        }

    </style>

    @if(in_array($role, ['admin', 'superadmin', 'staff']))
        <h1><b>Schedule Classes</b></h1>
    @else
        <h1><b>Check Your Appointment</b></h1>
    @endif

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
            @if(in_array($role, ['admin', 'superadmin', 'staff']))
                <h2 id="modalTitle">Add Class</h2>
            @else
                <h2 id="modalTitle">Add Appointment</h2>
            @endif
            <form id="appointmentForm" action="{{ $addClassRoute }}" method="POST" enctype="multipart/form-data" id="entity-form">
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
                dateClick: function(info) {
                    // Check if the clicked date is in the past
                    if (info.date < new Date().setHours(0, 0, 0, 0)) { // Adjust for time
                        return; // Do nothing for past dates
                    }
                    // Open modal for valid date click (including today)
                    openModal(info.dateStr);
                },
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

                const role = '{{$role}}';
                const baseURL = (role === 'admin' || role === 'superadmin') 
                ? '/admin/class-schedule/' 
                : '/staff/class-schedule/';

                if (scheduleID) {
                    viewAppointment.style.display = 'block';
                    appointmentForm.style.display = 'none';
                    document.getElementById('modalTitle').innerText = 'View Appointment';
                    document.getElementById('saveButton').innerText = 'Edit';
                    // Fetch and prefill data for editing
                    fetch(`${baseURL}${scheduleID}/edit`)
                        .then(response => response.json())
                        .then(data => {
                            document.getElementById('appointment-date').innerHTML = data.Date;
                            document.getElementById('appointment-time').innerHTML = data.Time;
                            document.getElementById('appointment-location').innerHTML = data.Location;
                            document.getElementById('appointment-instructor').innerHTML = data.InstructorName;
                            document.getElementById('appointment-course').innerHTML = data.CourseName;
                            document.getElementById('appointment-student').innerHTML = data.StudentName;
                            document.getElementById('deleteForm').action = `${baseURL}destroy/${data.ClassScheduleID}`;

                            const saveButton = document.getElementById('editButton');
                            saveButton.href = `${baseURL}${data.ClassScheduleID}/edit-form`;
                        });
                } else {
                    viewAppointment.style.display = 'none';
                    appointmentForm.style.display = 'block';
                    document.getElementById('Date').value = startDate;
                    document.getElementById('saveButton').innerText = 'Save';
                    document.getElementById('ClassScheduleID').value = '';
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
