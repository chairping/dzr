
    function ajax_form(form_obj,success_function) {
        ajax_exec(form_obj.attr('action'),form_obj.attr('method'),success_function,form_obj.serializeArray());
    }

    function ajax_exec(url,type,success_function,data,data_type,loading_text) {
    
        var ajax_option=
        {
                type: type,
                data: data?data:'',
                dataType: data_type?data_type:'json',
                beforeSend  :   function() {
                            //art_loading_start(loading_text?loading_text:'执行中，请稍候...');
                        },
                success     :   success_function ? success_function : function(data) {
                    alert('执行成功！');},
                error       :   function() {
                            //art_alert('执行过程中出错，重新操作或联系管理员！','警告','error');
                        },
                complete    :   function() {
                            //art_loading_stop();
                        }
            };
        
        if(url!=''){
               ajax_option['url']=url; 
            }
        $.ajax(ajax_option);
    }



