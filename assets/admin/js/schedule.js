(function($) {
    "use strict";

    $(document).ready(function(){
        $("#headercheck").click(function(){
                if(this.checked){
                    $('.postCheck').each(function(){
                        $(".postCheck").prop('checked', true);
                        var checked = $(".postCheck:checked").length;
                        if(checked > 0){
                            $('.selectPost').css('display','block');
                            
                        }
                    })
                }else{
                    $('.postCheck').each(function(){
                        $(".postCheck").prop('checked', false);
                        $('.selectPost').css('display','none');
                    })
                }
            });
        });

        $(document).on('click','.postCheck',function(){
            var checked = $(".postCheck:checked").length;
            if(checked > 0){
                $('.selectPost').css('display','block');
                
            }else{
                $('.selectPost').css('display','none');
        }
    
    });

})(jQuery);