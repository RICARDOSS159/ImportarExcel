(function($) {
  $.fn.dateInput = function() {
    return this.on('input', function(event) {
      var value = $(this).val();
      if (/^\d{2}$/.test(value)) {
        var day = parseInt(value, 10);
        if (day > 31) {
          $(this).val('31/');
        } else {
          $(this).val(value + '/');
        }
      } else if (/^\d{2}\/\d{2}$/.test(value)) {
        var parts = value.split('/');
        var month = parseInt(parts[1], 10);
        if (month > 12) {
          $(this).val(parts[0] + '/12/');
        } else {
          $(this).val(value + '/');
        }
      } else if (/^\d{2}\/\d{2}\/\d{4}$/.test(value)) {
        var yearIndex = value.lastIndexOf('/') + 1;
        var year = value.substring(yearIndex);
        if (year.length >= 4) {
          event.preventDefault();
        }
        var parts = value.split('/');
        var day = parseInt(parts[0], 10);
        var month = parseInt(parts[1], 10);
        var maxDays = new Date(parts[2], month, 0).getDate();
        if (day > maxDays) {
          $(this).val(maxDays + '/' + parts[1] + '/' + parts[2]);
        }
      } else {
        // Manejar casos donde se borra el día o mes
        var parts = value.split('/');
        if (parts.length === 3 && parts[0] && parts[1] && parts[2]) {
          var day = parseInt(parts[0], 10);
          var month = parseInt(parts[1], 10);
          var maxDays = new Date(parts[2], month, 0).getDate();
          if (day > maxDays) {
            $(this).val(maxDays + '/' + parts[1] + '/' + parts[2]);
          }
        }
      }
    });
  };
}(jQuery));

$(document).ready(function() {
  $('input[data-name="tuCampoDeFecha"]').dateInput();
});