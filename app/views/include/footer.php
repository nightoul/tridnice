


<script src="https://code.jquery.com/jquery-3.5.1.min.js" ></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

<?php

// since flash messages use Materialize toast they must be called after Materialize JQUERY is loaded
Flash::show_flash_message() ?>

<script>
$(document).ready(function () {

  // modals
  $(".modal").modal();

  // tabs
  $(".tabs").tabs();

  // parallaxes
  $(".parallax").parallax();

  // selects
  $("select").formSelect();

  // timepickers
  $(".timepicker").timepicker({
    twelveHour: false,
  });

  // materialbox
  $(".materialboxed").materialbox();

});

</script>

</body>
</html>