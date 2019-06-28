$(function() {
    $("#sendMessageButton").jqBootstrapValidation({
        preventSubmit: true,
        submitError: function($form, event, errors) {
            // additional error messages or events
        },
        submitSuccess: function($form, event) {

            event.preventDefault(); // prevent default submit behaviour
            // get values from FORM
            var qtd = $("input#qtd").val();
            var formaPtgo = $("input#formaPgto").val();
            var produto = '0';
            var endereco = '0';
             $('#produto option').each(function () {
               if($(this).attr('selected')) {
                 produto = $(this).val();
               }
             });
             $('#endereco option').each(function () {
               if($(this).attr('selected')) {
                 endereco = $(this).val();
               }
             });
            // Check for white space in name for Success/Fail message
            $this = $("#sendMessageButton");
            $this.prop("disabled", true);
            $.ajax({
                url: "http://127.0.0.1/Togai/Cardapio/Pedido",
                type: "POST",
                data: {
                    qtd: qtd,
                    formaPgto: formaPgto,
                    produto: produto,
                    endereco: endereco
                },
                cache: false,
                datatype: 'json',
                success: function() {
                    // Success message
                    $('.cmsmasters_notice').css('display', 'block');
                    $('#cadastro').trigger("reset");
                },
                error: function() {
                    // Fail message
                    $('#success').html("<div class='alert alert-danger'>");
                    $('#success > .alert-danger').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;")
                        .append("</button>");
                    $('#success > .alert-danger').append($("<strong>").text("Desculpe, parece que o nosso servidor não está respondendo. Por favor tente novamente mais tarde!"));
                    $('#success > .alert-danger').append('</div>');
                    //clear all fields
                    $('#contactForm').trigger("reset");
                },
                complete: function() {
                    setTimeout(function() {
                        $this.prop("disabled", false); // Re-enable submit button when AJAX call is complete
                    }, 1000);
                    $('.cmsmasters_notice').css('display', 'block');
                    $('#cadastro').trigger("reset");
                }
            });
        },
        filter: function() {
            return $(this).is(":visible");
        },
    });

    $("a[data-toggle=\"tab\"]").click(function(e) {
        e.preventDefault();
        $(this).tab("show");
    });
});

/*When clicking on Full hide fail/success boxes */
$('#name').focus(function() {
    $('#success').html('');
});
