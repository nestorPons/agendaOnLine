$(function(){
$('.btn-danger').click(function(){window.location.href = "index.html"})

  $('form').submit(function(e){
    e.preventDefault();
 
    if($('form')[0].checkValidity()){
      if ($('#pass1').val() != $('#pass2').val()) return false;
      var frm = $(this).find('input:not(:password)').serialize();

      $.post("php/crearAgenda.php",frm,function(r){
        if (r.success){ 
          $.Notify({
            caption: 'Guardado',
            content: 'Se ha creado una Agenda',
            type: 'success',
            icon: 'icon-floppy'
          });
          //window.location.href = "/empresaCreada.php?e="+r.e;
        }else{
          if(r.error == 1){
            $.Notify({
              caption: 'ERROR',
              content: 'Ya existe una empresa con ese nombre',
              type: 'alert',
              icon:'icon-cross'
            });
          }
        }
      })
      .fail(function(r){alert('fallo=>' + r)})
      .always(function(){$('.btnLoad').html('Guardar')})
    }
  })
});
