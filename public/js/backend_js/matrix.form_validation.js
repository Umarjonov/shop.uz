
$(document).ready(function(){

    $("#current_pwd").keyup(function (){
        var current_pwd = $("#current_pwd").val();
        $.ajax({
            type:'get',
            url:'/admin/check-pwd',
            data:{current_pwd:current_pwd},
            success:function (resp){
                // alert(resp);
                if (resp == "false"){
                    $("#chkPwd").html("<font color='red'>Current Password is Incorrect</font>")
                }else if (resp=="true"){
                    $("#chkPwd").html("<font color='green'>Current Password is Correct</font>")
                }
            },error:function (){
                alert('Error');
            }
        });
    });

	$('input[type=checkbox],input[type=radio],input[type=file]').uniform();

	$('select').select2();

	// Form Validation
    $("#basic_validate").validate({
		rules:{
			required:{
				required:true
			},
			email:{
				required:true,
				email: true
			},
			date:{
				required:true,
				date: true
			},
			url:{
				required:true,
				url: true
			}
		},
		errorClass: "help-inline",
		errorElement: "span",
		highlight:function(element, errorClass, validClass) {
			$(element).parents('.control-group').addClass('error');
		},
		unhighlight: function(element, errorClass, validClass) {
			$(element).parents('.control-group').removeClass('error');
			$(element).parents('.control-group').addClass('success');
		}
	});

    // Add Category Validation
    $("#add_category").validate({
		rules:{
			category_name:{
				required:true
			},
			description:{
				required:true,
			},
			url:{
				required:true,
			}
		},
		errorClass: "help-inline",
		errorElement: "span",
		highlight:function(element, errorClass, validClass) {
			$(element).parents('.control-group').addClass('error');
		},
		unhighlight: function(element, errorClass, validClass) {
			$(element).parents('.control-group').removeClass('error');
			$(element).parents('.control-group').addClass('success');
		}
	});

    // Adit Category Validation
    $("#adit_category").validate({
		rules:{
			category_name:{
				required:true
			},
			description:{
				required:true,
			},
			url:{
				required:true,
			}
		},
		errorClass: "help-inline",
		errorElement: "span",
		highlight:function(element, errorClass, validClass) {
			$(element).parents('.control-group').addClass('error');
		},
		unhighlight: function(element, errorClass, validClass) {
			$(element).parents('.control-group').removeClass('error');
			$(element).parents('.control-group').addClass('success');
		}
	});

    // Add Products Validation
    $("#add_product").validate({
		rules:{
            category_id:{
				required:true
			},
			product_name:{
				required:true
			},
            product_code:{
				required:true,
			},
            product_color:{
				required:true,
			},
            price:{
				required:true,
                number:true,
			}
		},
		errorClass: "help-inline",
		errorElement: "span",
		highlight:function(element, errorClass, validClass) {
			$(element).parents('.control-group').addClass('error');
		},
		unhighlight: function(element, errorClass, validClass) {
			$(element).parents('.control-group').removeClass('error');
			$(element).parents('.control-group').addClass('success');
		}
	});

    // Edit Products Validation
    $("#edit_product").validate({
		rules:{
            category_id:{
				required:true
			},
			product_name:{
				required:true
			},
            product_code:{
				required:true,
			},
            product_color:{
				required:true,
			},
            price:{
				required:true,
                number:true,
			}
		},
		errorClass: "help-inline",
		errorElement: "span",
		highlight:function(element, errorClass, validClass) {
			$(element).parents('.control-group').addClass('error');
		},
		unhighlight: function(element, errorClass, validClass) {
			$(element).parents('.control-group').removeClass('error');
			$(element).parents('.control-group').addClass('success');
		}
	});

    $("#delcat").click(function () {
        if (confirm("Siz rostdan ham bu Categoriyani o`chirmoqchimisiz?")){
            return true;
        }
        return false;
    });

    // $("#delProduct").click(function () {
    //     if (confirm("Siz rostdan ham bu Productni o`chirmoqchimisiz?")){
    //         return true;
    //     }
    //     return false;
    // });
    $(document).on('click','.deleteRecord',function (e){
       var id = $(this).attr('rel');
       var deleteFunction = $(this).attr('rel1');
       // alert(deleteFunction);
        swal({
            title: "Ishonchingiz komilmi?",
            text: "Siz rostdan ham bu malumotni o`chirmoqchimisiz",
            type: "warning",
            showCancelButton: true,
            confirmmButtonClass: "btn btn-success",
            confirmButtonText: "Ha, o`chirilsin!",
            cancelButtonText: "Yo`q, bekor qilinsin!",
            cancelmmButtonClass: "btn btn-danger",
            buttonsStyling: false,
            reverseButtons: true
        },
        function (){
            window.location.href="/admin/"+deleteFunction+"/"+id;
        });

        // swal({
        //     title: "Ishonchingiz komilmi?",
        //     text: "Siz rostdan ham bu malumotni ochirmoqchimisiz",
        //     icon: 'warning',
        //     showCancelButton: true,
        //     confirmButtonColor: '#3085d6',
        //     cancelButtonColor: '#d33',
        //     confirmButtonText: "Ha, o`chirilsin!"
        // }).then((result) => {
        //     if (result.isConfirmed) {
        //         swal(
        //             'Deleted!',
        //             'Your file has been deleted.',
        //             'success'
        //         )
        //         window.location.href="/admin/"+deleteFunction+"/"+id;
        //     }
        // })

    });

    $(document).ready(function(){
        var maxField = 10; //Input fields increment limitation
        var addButton = $('.add_button'); //Add button selector
        var wrapper = $('.field_wrapper'); //Input field wrapper
        var fieldHTML = '<div style="margin-left:180px;"><input type="text"  name="sku[]" id="sku" placeholder="SKU" style="width: 120px;margin-right: 3px;margin-top:3px;"/>' +
            '<input type="text" ame="size[]" id="size" placeholder="size"  style="width: 120px;margin-right: 3px;margin-top:3px;"/>'+
            '<input type="text"  name="price[]" id="price" placeholder="price" style="width: 120px;margin-right: 3px;margin-top:3px;"/>'+
            '<input type="text"  name="stock[]" id="stock" placeholder="stock" style="width: 120px;margin-right: 3px;margin-top:3px;"/>'+
            '<a href="javascript:void(0);" class="remove_button">Remove</a></div>'; //New input field html
        var x = 1; //Initial field counter is 1

        //Once add button is clicked
        $(addButton).click(function(){
            //Check maximum number of input fields
            if(x < maxField){
                x++; //Increment field counter
                $(wrapper).append(fieldHTML); //Add field html
            }
        });

        //Once remove button is clicked
        $(wrapper).on('click', '.remove_button', function(e){
            e.preventDefault();
            $(this).parent('div').remove(); //Remove field html
            x--; //Decrement field counter
        });
    });

	$("#number_validate").validate({
		rules:{
			min:{
				required: true,
				min:10
			},
			max:{
				required:true,
				max:24
			},
			number:{
				required:true,
				number:true
			}
		},
		errorClass: "help-inline",
		errorElement: "span",
		highlight:function(element, errorClass, validClass) {
			$(element).parents('.control-group').addClass('error');
		},
		unhighlight: function(element, errorClass, validClass) {
			$(element).parents('.control-group').removeClass('error');
			$(element).parents('.control-group').addClass('success');
		}
	});

	$("#password_validate").validate({
		rules:{
			current_pwd:{
				required: true,
				minlength:6,
				maxlength:20
			},
            new_pwd:{
				required: true,
				minlength:6,
				maxlength:20
			},
			confirm_pwd:{
				required:true,
				minlength:6,
				maxlength:20,
				equalTo:"#new_pwd"
			}
		},
		errorClass: "help-inline",
		errorElement: "span",
		highlight:function(element, errorClass, validClass) {
			$(element).parents('.control-group').addClass('error');
		},
		unhighlight: function(element, errorClass, validClass) {
			$(element).parents('.control-group').removeClass('error');
			$(element).parents('.control-group').addClass('success');
		}
	});
});
