@extends('instructor.layout')
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
            z-index: 100;
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
            padding: 24px;
            border: 1px solid #888;
            width: 40%;
            display: flex;
            flex-direction: column;
            gap: 48px
            border-radius: 16px;
            box-shadow: 0px 0px 1px #d0d0d0, 0px 0px 1px #f0f0f0;
        }
        .modal-top{
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        #modalTitle{
            font-size: 28px;
            font-weight: 700;
        }
        .close {
            color: #aaa;
            font-size: 28px;
            font-weight: bold;
            display: flex;
            justify-content: flex-end;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
        .viewAppointment{
            display: none;
        }
        #viewAppointment {
            width: 100%;
            margin: 24px auto;
        }

        #viewAppointment div {
            margin-bottom: 15px;
            display: flex;
            gap: 12px;
        }

        #viewAppointment label {
            flex-basis: 30%;
            font-weight: bold;
            color: #333;
            display: block;
            margin-bottom: 5px;
        }

        #viewAppointment p {
            font-size: 16px;
            color: #666;
            margin: 0;
        }

        /*calendar style*/
        #calendar #calendar button.fc-today-button.fc-button.fc-button-primary {
            text-transform: capitalize;
        }
    </style>
    <h1><b>Check Your Timetable</b></h1>
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
            <div class="modal-top">
                <h2 id="modalTitle">View Appointment</h2>
                <span class="close">&times;</span>           
            </div>
            <div id="viewAppointment">
                <div>
                    <label for="appointment-date">Date</label>
                    <p id="appointment-date"></p>
                </div>
                <div>
                    <label for="appointment-id">Time:</label>
                    <p id="appointment-time"></p>
                </div>
                <div>
                    <label for="appointment-location">Location</label>
                    <p id="appointment-location"></p>
                </div>
                <div>
                    <label for="appointment-instructor">Instructor</label>
                    <p id="appointment-instructor"></p>
                </div>
                <div>
                    <label for="appointment-course-name">Course</label>
                    <p id="appointment-course-name"></p>
                </div>
                <div>
                    <label for="appointment-course-description">Course Description</label>
                    <p id="appointment-course-description"></p>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var modal = document.getElementById('appointmentModal');
            var viewAppointment = document.getElementById('viewAppointment');
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
                if (scheduleID) {
                    modal.style.display = 'block';
                    viewAppointment.style.display = 'block';
                    fetch(`/instructor/time-table/${scheduleID}/edit`)
                        .then(response => response.json())
                        .then(data => {
                            console.log(data);
                            document.getElementById('appointment-date').innerHTML = data.Date;
                            document.getElementById('appointment-time').innerHTML = data.Time;
                            document.getElementById('appointment-location').innerHTML = data.Location;
                            document.getElementById('appointment-instructor').innerHTML = data.InstructorName;
                            document.getElementById('appointment-course-name').innerHTML = data.CourseName;
                            document.getElementById('appointment-course-description').innerHTML = data.CourseDescription;
                        });
                }else{
                    modal.style.display = 'none';
                }
            }
        });
    </script>
</div>
@endsection