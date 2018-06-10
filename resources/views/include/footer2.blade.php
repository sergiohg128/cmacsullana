       <!-- Footer -->
    
    <!-- End Footer -->

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="js/jquery-3.3.1.js"></script>
    <script src="js/moment.min.js"></script>
    <script src="js/fullcalendar.js"></script>
    <script src='js/es.js'></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/smooth-scroll.min.js"></script>
    <script src="js/toasts.js"></script>
    <script src="js/scripts.js"></script>
    
    <script>
      var scroll =  new  SmoothScroll ('a[href*="#titulo"]',{
        speed: 900,
      });

      $('#calendar').fullCalendar({
        minTime: "08:00:00",
        defaultView: 'agendaWeek',
        locale: 'es',
        allDaySlot: false,
        maxTime: "19:00:00",
        themeSystem: 'standard',
        hiddenDays: [0],
        height:640,
        dayClick: function(date) {
          str = date.format();
          var res = str.split("T");
          $("#inicio").val(res[0]);
          $("#hora").val(res[1]);
          $("#modalSkype").modal();
        }
      });
    </script>
  </body>
  <!-- End Body -->
</html>