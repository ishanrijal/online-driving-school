@extends('admin.layout')
@section('title', 'Dashboard')
@section('content')
    <div class="content-wrapper">
            <style>
                #calendar {
                    width: 100%;
                    margin: 40px auto;
                }
            </style>
            <h1><b>Check Your Appointment</b></h1>

            <div id="calendar"></div>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    var calendarEl = document.getElementById('calendar');

                    var calendar = new FullCalendar.Calendar(calendarEl, {
                        initialView: 'dayGridMonth', 
                        selectable: true, 
                        editable: true,
                        events: '/appointments', // Fetch events (appointments) from backend
                        select: function(info) {
                            var title = prompt('Enter Appointment Title:');
                            if (title) {
                                $.ajax({
                                    url: '/appointments/create',
                                    type: 'POST',
                                    data: {
                                        _token: "{{ csrf_token() }}",
                                        title: title,
                                        start: info.startStr,
                                        end: info.endStr
                                    },
                                    success: function() {
                                        calendar.refetchEvents(); // Reload the calendar events
                                        alert('Appointment added successfully');
                                    },
                                    error: function() {
                                        alert('Failed to add appointment');
                                    }
                                });
                            }
                            calendar.unselect();
                        },
                        eventDrop: function(info) {
                            $.ajax({
                                url: '/appointments/update/' + info.event.id,
                                type: 'PUT',
                                data: {
                                    _token: "{{ csrf_token() }}",
                                    start: info.event.start.toISOString(),
                                    end: info.event.end ? info.event.end.toISOString() : null
                                },
                                success: function() {
                                    alert('Appointment updated successfully');
                                },
                                error: function() {
                                    alert('Failed to update appointment');
                                }
                            });
                        },
                        eventClick: function(info) {
                            if (confirm('Do you want to delete this appointment?')) {
                                $.ajax({
                                    url: '/appointments/delete/' + info.event.id,
                                    type: 'DELETE',
                                    data: {
                                        _token: "{{ csrf_token() }}"
                                    },
                                    success: function() {
                                        calendar.refetchEvents();
                                        alert('Appointment deleted successfully');
                                    },
                                    error: function() {
                                        alert('Failed to delete appointment');
                                    }
                                });
                            }
                        }
                    });

                    calendar.render();
                });
            </script>
    </div>
@endsection
