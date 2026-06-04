(function($) {
    "use strict";

    $(".registerform").on('submit', function (e) {
        e.preventDefault();
        var $this = $(this).parent();
        $this.find('button.submit-btn').prop('disabled', true);
        var regdata = $this.find('.mregdata').val();
        $.ajax({
        method: "POST",
        url: $(this).prop('action'),
        data: new FormData(this),
        dataType: 'JSON',
        contentType: false,
        cache: false,
        processData: false,
        success: function (data) {
            if ((data.errors)) {
                toastr.error(data.errors[0]);
            } else {
                toastr.success(data);
            }
            $this.find('button.submit-btn').prop('disabled', false);
            $('.refresh_code').click();
        }
        });
    });

    $(".mloginform").on('submit', function (e) {
        var $this = $(this).parent();
        e.preventDefault();
        $this.find('button.submit-btn').prop('disabled', true);
        $.ajax({
          method: "POST",
          url: $(this).prop('action'),
          data: new FormData(this),
          dataType: 'JSON',
          contentType: false,
          cache: false,
          processData: false,
          success: function (data) {
            if ((data.errors)) {
                toastr.error(data.errors[0]);
            } else {
              toastr.success('Success !');
              window.location = data;
            }
            $this.find('button.submit-btn').prop('disabled', false);
          }
        });
  
      });


})(jQuery);
