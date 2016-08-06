$(function(){

    "use strict";

    var main = {};

    /**
     * Update contact fields
     */
    main.updateContactFields = function(){
        $(document.body).on('change', '.main-company-form .cont-fields input', function(){
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

    /**
     * Delete all contact group of fields
     */
    main.deleteContact = function(){
        $(document.body).on('click','.del_contact', function(e){
            e.preventDefault();
            var self = this;
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
                        $(self).closest('.contact-group').fadeOut(function(){
                            $(self).remove();
                        });
                    }
                }
            });
        });
    };

    /**
     * Add contact group of fields without phones
     */
    main.addContact = function(){
        $(document.body).on('click', '.add_contact', function(e){
            e.preventDefault();
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
                        alert('Contact was not updated. Save company info before. ' + data.msg)
                    } else {
                        var id = data.cid;
                        var contactWrap = $('.cont_wrap');
                        var contactGroup = $('.contact-group:first');
                        if($('.contact-group').length <= 1)
                            location.reload();
                        var cloneGroup = contactGroup.clone();

                        cloneGroup.attr('data-cid', id);
                        cloneGroup.attr('id', '#c_'+id);
                        cloneGroup.find('.phones-wrap').empty();

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

    /**
     * Add phone field
     */
    main.addPhoneField = function(){
        $(document.body).on('click', '.add_phone', function(){
            var self = this;
            var action = $(this).data('action');
            var cid = $(this).closest('.contact-group').data('cid');

            $.ajax({
                url: action + '?cid=' + cid,
                method: 'put',
                dataType: 'json',
                data:{
                    cid: cid
                },
                success: function(data){
                    if(data.status == 'error'){
                        alert('Error, phone was not added.')
                    }
                    else if(!$('.phone_row').hasClass('rec_11')){
                        location.reload();
                    }
                    else {
                        var phoneWrap = $(self).closest('.contact-group').find('.phones-wrap');
                        var phoneGroup = $('.phone_row:first');
                        var cloneGroup = phoneGroup.clone();

                        cloneGroup.find('input').attr('data-id', data.pid);
                        cloneGroup.attr('data-pid', data.pid);

                        var inputFields = cloneGroup.find('input');

                        inputFields.each(function(num,value){
                            $(value).val('');//clear new values
                        });

                        phoneWrap.append(cloneGroup).html();
                    }
                }
            });
        });
    };

    /**
     * Delete phone field
     */
    main.deletePhoneField = function(){
        $(document.body).on('click','.delete_phone', function(e){
            e.preventDefault();
            var self = this;
            var pid = $(this).closest('.phone_row').data('pid');
            var action = $(this).closest('.phone_row').data('action');

            $.ajax({
                url: action + '?pid=' + pid,
                method: 'delete',
                dataType: 'json',
                success: function(data){
                    if(data.status == 'error'){
                        alert('Error, phone was not deleted.');
                    } else {
                        var phone_row = $(self).closest('.phone_row');
                        phone_row.fadeOut(function(){
                            phone_row.remove();
                        });
                    }
                }
            });
        });
    };

    /**
     * Update any input fields
     * Universal function
     */
    main.updateField = function(){
        $(document.body).on('change', '.update_on_field', function(){
            var id = $(this).data('id');
            var action = $(this).data('action');
            var field = $(this).data('field');
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
                        alert('Error, data was not updated. ' + data.msg)
                    }
                }
            });
        });
    };

    main.updateContactFields();
    main.deleteContact();
    main.addContact();
    main.updateField();
    main.addPhoneField();
    main.deletePhoneField();
});