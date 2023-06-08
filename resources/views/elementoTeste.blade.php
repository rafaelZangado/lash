

<script src="{{ asset('js/fullcalendar/index.global.js') }}"></script>
<script src="{{ asset('js/fullcalendar/pt-br.global.js') }}"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
  
  document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
      locale: 'pt-br',
      height: '100%',
      expandRows: true,
      slotMinTime: '08:00',
      slotMaxTime: '20:00',
      headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
      },
      initialView: 'dayGridMonth',
      initialDate: '2023-01-12',
      navLinks: true, // can click day/week names to navigate views
      editable: true,
      selectable: true,
      nowIndicator: true,
      dayMaxEvents: true, // allow "more" link when too many events
      events:[]
      
    });

    calendar.render();
    $.ajax({
      url:'/eventos',
      method: 'GET',
      success: function(response) {
        var eventos = response;

        // Atualize a propriedade events do calendário com os eventos retornados
        calendar.setOption('events', eventos);
      },
      error: function() {
        console.log('Ocorreu um erro ao obter os eventos.');
      }
    });
  });

</script>
<style>

  html, body {
    overflow: hidden; /* don't do scrollbars */
    font-family: Arial, Helvetica Neue, Helvetica, sans-serif;
    font-size: 14px;
  }

  #calendar-container {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
  }

  .fc-header-toolbar {
 
    padding-top: 1em;
    padding-left: 1em;
    padding-right: 1em;
  }

</style>


  <div id='calendar-container'>
    <div id='calendar'></div>
  </div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
