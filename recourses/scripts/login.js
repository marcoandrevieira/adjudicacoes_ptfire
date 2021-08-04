


var Login = function () {

    var handleLogin = function () {

        $('.login-form').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            rules: {
                username: {
                    required: true
                },
                password: {
                    required: true
                },
                remember: {
                    required: false
                }
            },

            messages: {
                username: {
                    required: "O Email é obrigatório."
                },
                password: {
                    required: "A Password é obrigatória."
                }
            },

            invalidHandler: function (event, validator) { //display error alert on form submit   
                $('.alert-danger', $('.login-form')).show();
            },

            highlight: function (element) { // hightlight error inputs
                $(element)
                    .closest('.form-group').addClass('has-error'); // set error class to the control group
            },

            success: function (label) {
                label.closest('.form-group').removeClass('has-error');
                label.remove();
            },

            errorPlacement: function (error, element) {
                error.insertAfter(element.closest('.input-icon'));
            },

            submitHandler: function (form) {
                //form.submit(); // form validation success, call ajax form submit
                login(form);
            }



        });

        $('.login-form input').keypress(function (e) {
            if (e.which == 13) {
                if ($('.login-form').validate().form()) {
                    $('.login-form').submit(); //form validation success, call ajax form submit
                }
                return false;
            }
        });


        function login(form) {
            $.ajax({
                url: baseurl + 'login/validate_credentials',
                type: form.method,
                data: $(form).serialize(),
                success: function (response) {
                    var obj = jQuery.parseJSON(response);
                    console.log(obj);
                    if (obj.is_logged_in == true && obj.email) {
                        if (obj.id_tipo) {
                            window.location = baseurl + 'admin/adjudicacoes';
                        } /* else {
                            window.location = baseurl + 'monitores';
                        } */
                    } else {
                        $('.login-form .alert-danger').show();
                        $('.login-form .pwd').val('');
                    }
                }

            });


        }
    }

    var handleForgetPassword = function () {
        $('.forget-form').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "",
            rules: {
                email: {
                    required: true,
                    email: true
                }
            },

            messages: {
                email: {
                    required: "Email é obrigatório."
                }
            },

            invalidHandler: function (event, validator) { //display error alert on form submit   

            },

            highlight: function (element) { // hightlight error inputs
                $(element)
                    .closest('.form-group').addClass('has-error'); // set error class to the control group
            },

            success: function (label) {
                label.closest('.form-group').removeClass('has-error');
                label.remove();
            },

            errorPlacement: function (error, element) {
                error.insertAfter(element.closest('.input-icon'));
            },

            submitHandler: function () {
                //form.submit();
                recuparar();
            }
        });
		
		function recuparar(){
            //alert($("input[name=recuperar_conta]").val())

            $.ajax({
                url: baseurl + "login/recuperar_password",
                type:"post",
                data:{email: $("input[name=recuperar_conta]").val()},
                success:function(bool){
                    if(bool == "true"){
                        window.location.href = "https://adjudicacoes.ptfire.com.pt/login";
                    }else{
                        alert('Não foi possível recuprar password.')
                    }
                }
            })
        }

        $('.forget-form input').keypress(function (e) {
            if (e.which == 13) {
                if ($('.forget-form').validate().form()) {
                    $('.forget-form').submit();
                }
                return false;
            }
        });

        jQuery('#forget-password').click(function () {
            jQuery('.login-form').hide();
            jQuery('.forget-form').show();
        });

        jQuery('#back-btn').click(function () {
            jQuery('.login-form').show();
            jQuery('.forget-form').hide();
        });

    }


    return {
        //main function to initiate the module
        init: function () {

            handleLogin();
            handleForgetPassword();

        }

    };

}();

jQuery(document).ready(function () {
    Login.init();
});