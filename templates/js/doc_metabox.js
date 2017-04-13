// This code helps set up the doc-creation page
$(document).ready(function() {

    // Set up the date and timepickers
    function updateDateTime() {
        $('.time').timepicker();
        $('.date').datepicker({dateFormat: "yy-mm-dd"});
    }
    updateDateTime();
  });
