(function($) {
    "use strict";

    $(document).on('change','#is_talkto',function(){
        var active = $(this).val();
        if(active){
          var  url = mainurl+'admin/generalsettings/tawakto/'+active;
          $.ajax({
              url         : url,
              type        : 'get',
              contentType : false,
              processData : false,
              data        :{},
              success     : function(data){
                            if(data==1){
                              toastr.success("Tawk to activated");
                              location.reload();
                            }else{
                              toastr.error("Tawk to deactivated");
                              location.reload();
                            }       

              }
          }) 
        }
    })

    $(document).on('change','#is_disqus',function(){
        var active = $(this).val();
        if(active){
          var  url = mainurl+'admin/generalsettings/disqus/'+active;
          $.ajax({
              url         : url,
              type        : 'get',
              contentType : false,
              processData : false,
              data        :{},
              success     : function(data){
                            if(data==1){
                              toastr.success("Disqus activated");
                              location.reload();
                            }else{
                              toastr.error("Disqus deactivated");
                              location.reload();
                            }       
    
              }
          }) 
        }
    })

    $(document).on('change','#is_capcha',function(){
      var active = $(this).val();
      
      if(active){
        var  url = mainurl+'admin/generalsettings/capcha/'+active;
        $.ajax({
            url         : url,
            type        : 'get',
            contentType : false,
            processData : false,
            data        :{},
            success     : function(data){
                          if(data==1){
                            toastr.success("Captcha activated");
                            location.reload();
                          }else{
                            toastr.error("Captcha deactivated");
                            location.reload();
                          }       
  
            }
        })
      }
    })

    $(document).on('change','#is_verification_email',function(){
      var active = $(this).val();
      
      if(active){
        var  url = mainurl+'admin/generalsettings/emailverfication/'+active;
        $.ajax({
            url         : url,
            type        : 'get',
            contentType : false,
            processData : false,
            data        :{},
            success     : function(data){
                          if(data==1){
                            toastr.success("Email verification activated");
                            location.reload();
                          }else{
                            toastr.error("Email verification deactivated");
                            location.reload();
                          }       
  
            }
        })
      }
    })

    $(document).on('change','#is_smtp',function(){
      var active = $(this).val();
      if(active){
        var  url = mainurl+'admin/generalsettings/smtp/'+active;
        $.ajax({
            url         : url,
            type        : 'get',
            contentType : false,
            processData : false,
            data        :{},
            success     : function(data){
                          if(data==1){
                            toastr.success("SMTP activated");
                            location.reload();
                          }else{
                            toastr.error("SMTP deactivated");
                            location.reload();
                          }       
  
            }
        })
      }
  })

  $(document).on('change','#is_loader',function(){
    var active = $(this).val();
    if(active){
      var  url = mainurl+'admin/generalsettings/isLoader/'+active;
      $.ajax({
          url         : url,
          type        : 'get',
          contentType : false,
          processData : false,
          data        :{},
          success     : function(data){
                        if(data==1){
                          toastr.success("Loader activated");
                          location.reload();
                        }else{
                          toastr.error("Loader deactivated");
                          location.reload();
                        }       

          }
      }) 
    }
  })

  $(document).on('change','#is_adminloader',function(){
    var active = $(this).val();
    if(active){
      var  url = mainurl+'admin/generalsettings/isAdminLoader/'+active;
      $.ajax({
          url         : url,
          type        : 'get',
          contentType : false,
          processData : false,
          data        :{},
          success     : function(data){
                        if(data==1){
                          toastr.success("Admin loader activated");
                          location.reload();
                        }else{
                          toastr.error("Admin loader deactivated");
                          location.reload();
                        }       

          }
      }) 
    }
  })


})(jQuery);
