$(function ($) {
    "use strict";
    $("li.nav-item.dropdown.mega-menu .nav-link").on('mouseover', function(){
        $(this).parents("li.nav-item.dropdown.mega-menu").find(".go-tab-c").removeClass('active');
        $(this).parents("li.nav-item.dropdown.mega-menu").find(".go-tab-c").first().addClass('active');
        
    });
    
    
    
    $('.dropdown-menu .tab-link').on('mouseover', function(){
        let targerLink =$(this).data('tab');
        
        $(this).parents('li.nav-item.dropdown.mega-menu').find(".go-tab-c").each(function() {
            $(this).removeClass('active');
        });
        
        $(targerLink).addClass('active');
        
    });


    // FORGOT FORM
    $("#forgotform").on('submit', function (e) {
        e.preventDefault();
        var $this = $(this).parent();
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
                toastr.success(data);
                $this.find('input[type=email]').val('');
            }
                $this.find('button.submit-btn').prop('disabled', false);
            }
    
        });
    
        });
 

});
