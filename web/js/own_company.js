$(function(){

    "use strict";

    var main = {};

    main.changeFields = function(){
        $(document.body).on('change', '.main-company-form .contact-group input', function(){
            var id = $(this).closest('.contact-group').data('cid');
            var action = $('.cont_wrap').data('action');
            var field = $(this).data('name');
            var value = $(this).val();

            $.ajax({
                url: action + '?id=' + id,
                method: 'post',
                dataType: 'json',
                data: {
                    field: field,
                    value: value
                },
                success: function(data){
                    if(data.status == 'error'){
                        alert('Error, contact was not updated. ' + data.msg)
                    } else {

                    }
                }
            });
        });
    };

    main.deleteContact = function(){
        $('.del_contact').on('click',function(e){
            e.preventDefault();
            var id = $(this).closest('.contact-group').data('cid');
            var action = $('.cont_wrap').data('action');
            var comp_id = $('.cont_wrap').data('comp_id');

            $.ajax({
                url: action + '?id=' + id,
                method: 'delete',
                data:{
                    comp_id: comp_id
                },
                dataType: 'json',
                success: function(data){
                    if(data.status == 'error'){
                        alert('Error, contact was not deleted. ' + data.msg);
                    } else {
                        $('#c_'+id).fadeOut(function(){
                            $(this).remove();
                        });
                    }
                }
            });
        });
    };

    main.addContact = function(){
        $(document.body).on('click', '.add_contact', function(){
            var action = $('.cont_wrap').data('action');
            var comp_id = $('.cont_wrap').data('comp_id');

            $.ajax({
                url: action,
                method: 'put',
                dataType: 'json',
                data:{
                    comp_id: comp_id
                },
                success: function(data){
                    if(data.status == 'error'){
                        alert('Error, contact was not updated. ' + data.msg)
                    } else {
                        var id = data.cid;
                        var contactWrap = $('.cont_wrap');
                        var contactGroup = $('.contact-group:first');
                        var cloneGroup = contactGroup.clone();

                        cloneGroup.attr('data-cid', id);
                        cloneGroup.attr('id', '#c_'+id);

                        var inputFields = cloneGroup.find('input');

                        inputFields.each(function(num,value){
                            $(value).val('');//clear new values
                        });

                        contactWrap.append(cloneGroup).html();
                    }
                }
            });
        });
    };

    main.changeFields();
    main.deleteContact();
    main.addContact();
});