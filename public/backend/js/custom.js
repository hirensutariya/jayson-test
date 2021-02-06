jQuery(document).ready((function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('#departmentForm').validate({
        rules: {
            name: {
                required: true
            }
        },
        messages: {
            name: 'Please enter Department Name.',
        },
        submitHandler: function (form) {
            form.submit();
        }
    });
    $('#cityForm').validate({
        rules: {
            name: {
                required: true
            }
        },
        messages: {
            name: 'Please enter City Name.',
        },
        submitHandler: function (form) {
            form.submit();
        }
    });
    $('#countryForm').validate({
        rules: {
            name: {
                required: true
            },
            code: {
                required: true,
                minlength: 2,
                maxlength : 3,
                lettersonly: true
            },
        },
        messages: {
            name: 'Please enter Country Name.',
            code: {
                required: 'Please enter Country Code.',
                minlength: 'Country code must be at least 2 characters long..',
                maxlength: 'Country code must be maximum 3 characters long..',
                lettersonly: 'Insert only Alphabetic.',
            },
        },
        submitHandler: function (form) {
            form.submit();
        }
    });
    $('#stateForm').validate({
        rules: {
            name: {
                required: true
            }
        },
        messages: {
            name: 'Please enter State Name.',
        },
        submitHandler: function (form) {
            form.submit();
        }
    });
    $('#country').change(function(){
        var countryID = $(this).val();
        if(countryID){
            $.ajax({
                url: APP_URL + "/states/getAllState",
                type: 'POST',
                data: {
                    "id": countryID,
                },
                success: function (res) {
                    if(res){
                        $("#state").empty();
                        $.each(res,function(key,value){
                            $("#state").append('<option value="'+key+'">'+value+'</option>');
                        });
                    }else{
                        $("#state").empty();
                    }
                },error:function (){
                    $("#state").empty();
                }
            });
        }else{
            $("#state").empty();
        }
    });

}));
