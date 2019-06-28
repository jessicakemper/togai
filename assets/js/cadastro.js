$(function() {
  $("#sendMessageButton").jqBootstrapValidation({
    preventSubmit: true,
    submitError: function($form, event, errors) {
      // additional error messages or events
    },
    submitSuccess: function($form, event) {

      event.preventDefault(); // prevent default submit behaviour
      // get values from FORM
      var nome = $("input#nome").val();
      var email = $("input#email").val();
      var telefone = $("input#telefone").val();
      var senha = $("input#senha").val();
      var bairro = $("input#bairro").val();
      var endereco = $("input#endereco").val();
      var numero = $("input#numero").val();
      var complemento = $("input#complemento").val();
      var estado = '1';
      var cidade = '2';
     /* $('#cidade option').each(function () {
        if($(this).attr('selected')) {
          cidade = $(this).val();
        }
      });
      $('#estado option').each(function () {
        if($(this).attr('selected')) {
          estado = $(this).val();
        }
      });*/
      // Check for white space in name for Success/Fail message
      $this = $("#sendMessageButton");
      $this.prop("disabled", true);
      $.ajax({
        url: "http://127.0.0.1/Togai/Cliente/cadastro",
        type: "POST",
        data: {
          nome: nome,
          telefone: telefone,
          email: email,
          senha: senha,
          bairro: bairro,
          complemento: complemento,
          endereco: endereco,
          numero: numero,
          estado: estado,
          cidade: cidade
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
