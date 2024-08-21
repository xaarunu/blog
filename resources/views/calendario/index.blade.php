<x-app-layout>
    @section('title', 'DCJ - CFE')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ 'Calendario' }}
        </h2>
    </x-slot>
    <div class="py-6">
          
        <div class="max-w-screen-2xl mx-auto sm:px-6 lg:px-8">
          
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg" style="padding: 50px 50px 50px 50px;">
                <div id='calendar'></div>
            </div>
        </div>
    </div>
  </x-app-layout>
  
  <!-- Script para ver la imagen antes de CREAR UN NUEVO PRODUCTO -->
  <link rel="stylesheet" href={{asset('plugins/fullcalendar/fullcalendar.min.css')}} />
  <link rel="stylesheet" href={{asset('plugins/toastr/toastr.min.css')}} />

  <script src={{asset('plugins/jquery/jquery-3.5.1.min.js')}}></script> 
  <script src={{asset('plugins/moment/moment.min.js')}}></script>
  <script src={{asset('plugins/fullcalendar/fullcalendar.min.js')}}></script>
  <script src={{asset('plugins/toastr/toastr.min.js')}}></script>
    
  <script>
    $(document).ready(function () {
       
    var SITEURL = "{{ url('/') }}";
      
    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
      
    var calendar = $('#calendar').fullCalendar({
                        lang: 'es',
                        editable: false,
                        events: SITEURL + '/calendario',
                        eventRender: function (event, element, view) {
                            if (event.allDay === 'true') {
                                    event.allDay = true;
                            } else {
                                    event.allDay = false;
                            }
                        },
                        selectable: true,
                        selectHelper: true,
                        select: function (start, end, allDay) {
                            
                        var start = $.fullCalendar.formatDate(start, "Y-MM-DD");
                        var end = $.fullCalendar.formatDate(end, "Y-MM-DD");
                        $.ajax({
                            url: SITEURL + '/fullcalenderajax',
                            data: {
                                start: start,
                                end: end,
                                type: 'add'
                            },
                            type: "POST",
                            success: function (data) {
                                displayMessage("Evento creado con éxito");

                                calendar.fullCalendar('renderEvent',
                                    {
                                        title: "fecha no valida",
                                        id: data.id,
                                        start: start,
                                        end: end,
                                        allDay: allDay,
                                        color: '#C81F0E'
                                    },true);

                                calendar.fullCalendar('unselect');
                            }
                        });
                        },
                        eventDrop: function (event, delta) {
                            var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD");
                            var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD");
                            alert(event);
                            $.ajax({
                                url: SITEURL + '/fullcalenderajax',
                                data: {
                                    start: start,
                                    end: end,
                                    id: event.id,
                                    type: 'update'
                                },
                                type: "POST",
                                success: function (response) {
                                    displayMessage("Evento actualizado con éxito");
                                }
                            });
                        },
                        eventClick: function (event) {
                            var deleteMsg = confirm("¿De verdad quieres borrar el evento?");
                            if (deleteMsg) {
                                $.ajax({
                                    type: "POST",
                                    url: SITEURL + '/fullcalenderajax',
                                    data: {
                                            id: event.id,
                                            type: 'delete'
                                    },
                                    success: function (response) {
                                        calendar.fullCalendar('removeEvents', event.id);
                                        displayMessage("Evento eliminado con éxito");
                                    }
                                });
                            }
                        }
     
                    });
     
    });
     
    function displayMessage(message) {
        toastr.success(message, 'Event');
    } 
      
    </script>
  