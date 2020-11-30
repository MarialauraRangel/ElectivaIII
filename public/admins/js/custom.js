/*
=========================================
|                                       |
|           Scroll To Top               |
|                                       |
=========================================
*/ 
$('.scrollTop').click(function() {
  $("html, body").animate({scrollTop: 0});
});


$('.navbar .dropdown.notification-dropdown > .dropdown-menu, .navbar .dropdown.message-dropdown > .dropdown-menu ').click(function(e) {
  e.stopPropagation();
});

/*
=========================================
|                                       |
|       Multi-Check checkbox            |
|                                       |
=========================================
*/

function checkall(clickchk, relChkbox) {

  var checker = $('#' + clickchk);
  var multichk = $('.' + relChkbox);


  checker.click(function () {
    multichk.prop('checked', $(this).prop('checked'));
  });    
}


/*
=========================================
|                                       |
|           MultiCheck                  |
|                                       |
=========================================
*/

/*
    This MultiCheck Function is recommanded for datatable
    */

    function multiCheck(tb_var) {
      tb_var.on("change", ".chk-parent", function() {
        var e=$(this).closest("table").find("td:first-child .child-chk"), a=$(this).is(":checked");
        $(e).each(function() {
          a?($(this).prop("checked", !0), $(this).closest("tr").addClass("active")): ($(this).prop("checked", !1), $(this).closest("tr").removeClass("active"))
        })
      }),
      tb_var.on("change", "tbody tr .new-control", function() {
        $(this).parents("tr").toggleClass("active")
      })
    }

/*
=========================================
|                                       |
|           MultiCheck                  |
|                                       |
=========================================
*/

function checkall(clickchk, relChkbox) {

  var checker = $('#' + clickchk);
  var multichk = $('.' + relChkbox);


  checker.click(function () {
    multichk.prop('checked', $(this).prop('checked'));
  });    
}

/*
=========================================
|                                       |
|               Tooltips                |
|                                       |
=========================================
*/

$('.bs-tooltip').tooltip();

/*
=========================================
|                                       |
|               Popovers                |
|                                       |
=========================================
*/

$('.bs-popover').popover();


/*
================================================
|                                              |
|               Rounded Tooltip                |
|                                              |
================================================
*/

$('.t-dot').tooltip({
  template: '<div class="tooltip status rounded-tooltip" role="tooltip"><div class="arrow"></div><div class="tooltip-inner"></div></div>'
})


/*
================================================
|            IE VERSION Dector                 |
================================================
*/

function GetIEVersion() {
  var sAgent = window.navigator.userAgent;
  var Idx = sAgent.indexOf("MSIE");

  // If IE, return version number.
  if (Idx > 0) 
    return parseInt(sAgent.substring(Idx+ 5, sAgent.indexOf(".", Idx)));

  // If IE 11 then look for Updated user agent string.
  else if (!!navigator.userAgent.match(/Trident\/7\./)) 
    return 11;

  else
    return 0; //It is not IE
}

//////// Scripts ////////
$(document).ready(function() {
  //Validación para introducir solo números
  $('.number, #phone').keypress(function() {
    return event.charCode >= 48 && event.charCode <= 57;
  });
  //Validación para introducir solo letras y espacios
  $('#name, #lastname, .only-letters').keypress(function() {
    return event.charCode >= 65 && event.charCode <= 90 || event.charCode >= 97 && event.charCode <= 122 || event.charCode==32;
  });
  //Validación para solo presionar enter y borrar
  $('.date').keypress(function() {
    return event.charCode == 32 || event.charCode == 127;
  });

  //select2
  if ($('.select2').length) {
    $('.select2').select2({
      language: "es",
      placeholder: "Seleccione",
      tags: true
    });
  }

  //Datatables normal
  if ($('.table-normal').length) {
    $('.table-normal').DataTable({
      "oLanguage": {
        "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
        "sInfo": "Resultados del _START_ al _END_ de un total de _TOTAL_ registros",
        "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
        "sSearchPlaceholder": "Buscar...",
        "sLengthMenu": "Mostrar _MENU_ registros",
        "sProcessing":     "Procesando...",
        "sZeroRecords":    "No se encontraron resultados",
        "sEmptyTable":     "Ningún resultado disponible en esta tabla",
        "sInfoEmpty":      "No hay resultados",
        "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
        "sInfoPostFix":    "",
        "sUrl":            "",
        "sInfoThousands":  ",",
        "sLoadingRecords": "Cargando...",
        "oAria": {
          "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
          "sSortDescending": ": Activar para ordenar la columna de manera descendente"
        }
      },
      "stripeClasses": [],
      "lengthMenu": [10, 20, 50, 100, 200, 500],
      "pageLength": 10
    });
  }

  if ($('.table-export').length) {
    $('.table-export').DataTable({
      dom: '<"row"<"col-md-12"<"row"<"col-md-6"B><"col-md-6"f> > ><"col-md-12"rt> <"col-md-12"<"row"<"col-md-5"i><"col-md-7"p>>> >',
      buttons: {
        buttons: [
        { extend: 'copy', className: 'btn' },
        { extend: 'csv', className: 'btn' },
        { extend: 'excel', className: 'btn' },
        { extend: 'print', className: 'btn' }
        ]
      },
      "oLanguage": {
        "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
        "sInfo": "Resultados del _START_ al _END_ de un total de _TOTAL_ registros",
        "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
        "sSearchPlaceholder": "Buscar...",
        "sLengthMenu": "Mostrar _MENU_ registros",
        "sProcessing":     "Procesando...",
        "sZeroRecords":    "No se encontraron resultados",
        "sEmptyTable":     "Ningún resultado disponible en esta tabla",
        "sInfoEmpty":      "No hay resultados",
        "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
        "sInfoPostFix":    "",
        "sUrl":            "",
        "sInfoThousands":  ",",
        "sLoadingRecords": "Cargando...",
        "oAria": {
          "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
          "sSortDescending": ": Activar para ordenar la columna de manera descendente"
        },
        "buttons": {
          "copy": "Copiar",
          "print": "Imprimir"
        }
      },
      "stripeClasses": [],
      "lengthMenu": [10, 20, 50, 100, 200, 500],
      "pageLength": 10
    });
  }

  //dropify para input file más personalizado
  if ($('.dropify').length) {
    $('.dropify').dropify({
      messages: {
        default: 'Arrastre y suelte una imagen o da click para seleccionarla',
        replace: 'Arrastre y suelte una imagen o haga click para reemplazar',
        remove: 'Remover',
        error: 'Lo sentimos, el archivo es demasiado grande'
      },
      error: {
        'fileSize': 'El tamaño del archivo es demasiado grande ({{ value }} máximo).',
        'minWidth': 'El ancho de la imagen es demasiado pequeño ({{ value }}}px mínimo).',
        'maxWidth': 'El ancho de la imagen es demasiado grande ({{ value }}}px máximo).',
        'minHeight': 'La altura de la imagen es demasiado pequeña ({{ value }}}px mínimo).',
        'maxHeight': 'La altura de la imagen es demasiado grande ({{ value }}px máximo).',
        'imageFormat': 'El formato de imagen no está permitido (Debe ser {{ value }}).'
      }
    });
  }

  //datepicker material
  if ($('.dateMaterial').length) {
    $('.dateMaterial').bootstrapMaterialDatePicker({
      lang : 'es',
      time: false,
      cancelText: 'Cancelar',
      clearText: 'Limpiar',
      format: 'DD-MM-YYYY',
      maxDate : new Date()
    });
  }

  // flatpickr
  if ($('#flatpickr').length) {
    flatpickr(document.getElementById('flatpickr'), {
      locale: 'es',
      enableTime: false,
      dateFormat: "d-m-Y",
      maxDate : "today"
    });
  }

  //touchspin
  if ($('.number').length) {
    $(".number").TouchSpin({
      min: 0,
      max: 999999999,
      buttondown_class: 'btn btn-primary pt-2 pb-3',
      buttonup_class: 'btn btn-primary pt-2 pb-3'
    });
  }

  if ($('.decimal').length) {
    $(".decimal").TouchSpin({
      min: 0,
      max: 999999999,
      step: 0.50,
      decimals: 2,
      buttondown_class: 'btn btn-primary pt-2 pb-3',
      buttonup_class: 'btn btn-primary pt-2 pb-3'
    });
  }

  if ($('.discount').length) {
    $(".discount").TouchSpin({
      min: 0,
      max: 100,
      buttondown_class: 'btn btn-primary pt-2 pb-3',
      buttonup_class: 'btn btn-primary pt-2 pb-3'
    });
  }

  //Jquery uploader
  if ($('#drop-area').length) {
    $('#drop-area').dmUploader({
      url: '/admin/productos/imagenes',
      maxFileSize: 20000000,
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      onDragEnter: function(){
        this.addClass('active');
      },
      onDragLeave: function(){
        this.removeClass('active');
      },
      onBeforeUpload: function(){
        $('button[type="submit"]').attr('disabled', true);
        $("#response").text('Subiendo Archivo...');
      },
      onUploadSuccess: function(id, data){
        var obj=data;

        if (obj.status) {
          $("#images").append($('<div>', {
            'class': 'form-group col-lg-3 col-md-3 col-sm-6 col-12',
            'element': id
          }).append($('<img>', {
            'src': '/admins/img/products/'+obj.name,
            'class': 'rounded img-fluid'                            
          })).append($('<input>', {
            'type': 'hidden',
            'name': 'files[]',
            'value': obj.name                        
          })).append($('<button>', {
            'type': 'button',
            'class': 'btn btn-danger btn-sm btn-circle btn-absolute-right',
            'image': id,
            'urlImage': '/admins/img/products/'+obj.name,
            'onclick': 'deleteImageCreate("'+id+'");'
          }).append('<i class="fa fa-trash">')));

          $('button[type="submit"]').attr('disabled', false);
          $("#response").text('Correcto');
        } else {
          $('button[type="submit"]').attr('disabled', false);
          $("#response").text('Error');
        }
      },
      onUploadError: function(id, xhr, status, message){  
        $('button[type="submit"]').attr('disabled', false);
        $("#response").text('Error');
      },
      onFileSizeError: function(file){
        $('button[type="submit"]').attr('disabled', false);
        $("#response").text('El archivo \'' + file.name + '\' excede el tamaño máximo permitido.');
      }
    });
  }

  if ($('#drop-area2').length) {
    $('#drop-area2').dmUploader({
      url: '/admin/productos/imagenes/editar',
      maxFileSize: 20000000,
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      extraData: function() {
        return {
          "slug": $('#slug').val()
        };
      },
      onDragEnter: function(){
        this.addClass('active');
      },
      onDragLeave: function(){
        this.removeClass('active');
      },
      onBeforeUpload: function(){
        $('button[type="submit"]').attr('disabled', true);
        $("#response").text('Subiendo Archivo...');
      },
      onUploadSuccess: function(id, data){
        var obj=data;

        if (obj.status) {
          $("#images").append($('<div>', {
            'class': 'form-group col-lg-3 col-md-3 col-sm-6 col-12',
            'element': id
          }).append($('<img>', {
            'src': '/admins/img/products/'+obj.name,
            'class': 'rounded img-fluid'                            
          })).append($('<button>', {
            'type': 'button',
            'class': 'btn btn-danger btn-sm btn-circle btn-absolute-right removeImage',
            'image': id,
            'urlImage': '/admins/img/products/'+obj.name
          }).append('<i class="fa fa-trash">')));
          $('button[type="submit"]').attr('disabled', false);
          $("#response").text('Correcto');
          Lobibox.notify('success', {
            title: 'Registro exitoso',
            sound: true,
            msg: 'La imagen ha sido agregada exitosamente.'
          });

          //funcion para eliminar imagenes de vehiculos
          $('.removeImage').on('click', function(event) {
            var img=$(this).attr('image'), slug=$('#slug').val(), urlImage=event.currentTarget.attributes[3].value;
            urlImage=urlImage.split('/');
            if (slug!="") {
              $.ajax({
                url: '/admin/productos/imagenes/eliminar',
                type: 'POST',
                dataType: 'json',
                data: {slug: slug, url: urlImage[4]},
                headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
              })
              .done(function(obj) {
                if (obj.status) {
                  $("div[element='"+img+"']").remove();
                  Lobibox.notify('success', {
                    title: 'Eliminación Exitosa',
                    sound: true,
                    msg: 'La imagen ha sido eliminada exitosamente.'
                  });
                } else {
                  Lobibox.notify('error', {
                    title: 'Eliminación Fallida',
                    sound: true,
                    msg: 'Ha ocurrido un problema, intentelo nuevamente.'
                  });
                }
              });
            }
          });
        } else {
          $('button[type="submit"]').attr('disabled', false);
          $("#response").text('Error');
          Lobibox.notify('error', {
            title: 'Registro Fallido',
            sound: true,
            msg: 'Ha ocurrido un problema, intentelo nuevamente.'
          });
        }
      },
      onUploadError: function(id, xhr, status, message){  
        $('button[type="submit"]').attr('disabled', false);
        $("#response").text('Error');
        Lobibox.notify('error', {
          title: 'Registro Fallido',
          sound: true,
          msg: 'Ha ocurrido un problema, intentelo nuevamente.'
        });
      },
      onFileSizeError: function(file){
        $('button[type="submit"]').attr('disabled', false);
        $("#response").text('El archivo \'' + file.name + '\' excede el tamaño máximo permitido.');
      }
    });
  }

  //CKeditor plugin
  if ($('#content-about').length) {
    CKEDITOR.config.height=400;
    CKEDITOR.config.width='auto';
    CKEDITOR.replace('content-about');
  }

  if ($('#content-term').length) {
    CKEDITOR.config.height=400;
    CKEDITOR.config.width='auto';
    CKEDITOR.replace('content-term');
  }

  if ($('#content-privacity').length) {
    CKEDITOR.config.height=400;
    CKEDITOR.config.width='auto';
    CKEDITOR.replace('content-privacity');
  }
});

// funcion para cambiar el input hidden al cambiar el switch de estado
$('#stateCheckbox').change(function(event) {
  if ($(this).is(':checked')) {
    $('#stateHidden').val(1);
  } else {
    $('#stateHidden').val(0);
  }
});

// funcion para cambiar el input hidden al cambiar el switch de boton
$('#buttonCheckbox').change(function(event) {
  if ($(this).is(':checked')) {
    $('#buttonHidden').val(1);
    $('#buttonInputs').removeClass('d-none');
  } else {
    $('#buttonHidden').val(0);
    $('#buttonInputs').addClass('d-none');
  }
});

//funciones para desactivar y activar usuarios
function deactiveAdmin(slug) {
  $("#deactiveAdmin").modal();
  $('#formDeactiveAdmin').attr('action', '/admin/administradores/' + slug + '/desactivar');
}

function activeAdmin(slug) {
  $("#activeAdmin").modal();
  $('#formActiveAdmin').attr('action', '/admin/administradores/' + slug + '/activar');
}

function deactiveUser(slug) {
  $("#deactiveUser").modal();
  $('#formDeactiveUser').attr('action', '/admin/usuarios/' + slug + '/desactivar');
}

function activeUser(slug) {
  $("#activeUser").modal();
  $('#formActiveUser').attr('action', '/admin/usuarios/' + slug + '/activar');
}

function deactiveBanner(slug) {
  $("#deactiveBanner").modal();
  $('#formDeactiveBanner').attr('action', '/admin/banners/' + slug + '/desactivar');
}

function activeBanner(slug) {
  $("#activeBanner").modal();
  $('#formActiveBanner').attr('action', '/admin/banners/' + slug + '/activar');
}

function deactiveProduct(slug) {
  $("#deactiveProduct").modal();
  $('#formDeactiveProduct').attr('action', '/admin/productos/' + slug + '/desactivar');
}

function activeProduct(slug) {
  $("#activeProduct").modal();
  $('#formActiveProduct').attr('action', '/admin/productos/' + slug + '/activar');
}

function deactiveOrder(slug) {
  $("#deactiveOrder").modal();
  $('#formDeactiveOrder').attr('action', '/admin/pedidos/' + slug + '/desactivar');
}

function activeOrder(slug) {
  $("#activeOrder").modal();
  $('#formActiveOrder').attr('action', '/admin/pedidos/' + slug + '/activar');
}

function deactivePayment(slug) {
  $("#deactivePayment").modal();
  $('#formDeactivePayment').attr('action', '/admin/pagos/' + slug + '/desactivar');
}

function activePayment(slug) {
  $("#activePayment").modal();
  $('#formActivePayment').attr('action', '/admin/pagos/' + slug + '/activar');
}

//funciones para preguntar al eliminar
function deleteAdmin(slug) {
  $("#deleteAdmin").modal();
  $('#formDeleteAdmin').attr('action', '/admin/administradores/' + slug);
}

function deleteUser(slug) {
  $("#deleteUser").modal();
  $('#formDeleteUser').attr('action', '/admin/usuarios/' + slug);
}

function deleteBanner(slug) {
  $("#deleteBanner").modal();
  $('#formDeleteBanner').attr('action', '/admin/banners/' + slug);
}

function deleteCategory(slug) {
  $("#deleteCategory").modal();
  $('#formDeleteCategory').attr('action', '/admin/categorias/' + slug);
}

function deleteSubcategory(slug) {
  $("#deleteSubcategory").modal();
  $('#formDeleteSubcategory').attr('action', '/admin/subcategorias/' + slug);
}

function deleteProduct(slug) {
  $("#deleteProduct").modal();
  $('#formDeleteProduct').attr('action', '/admin/productos/' + slug);
}

function deleteCoupon(slug) {
  $("#deleteCoupon").modal();
  $('#formDeleteCoupon').attr('action', '/admin/cupones/' + slug);
}

function deleteColor(slug) {
  $("#deleteColor").modal();
  $('#formDeleteColor').attr('action', '/admin/colores/' + slug);
}

function deleteSize(slug) {
  $("#deleteSize").modal();
  $('#formDeleteSize').attr('action', '/admin/tallas/' + slug);
}

//Funcion para eliminar imagenes de productos
function deleteImageCreate(img){
  $("div[element="+img+"]").remove();
}

//funcion para eliminar imagenes de productos
$('.removeImage').click(function(event) {
  var img=$(this).attr('image'), slug=$('#slug').val(), urlImage=event.currentTarget.attributes[3].value;
  urlImage=urlImage.split('/');
  if (slug!="") {
    $.ajax({
      url: '/admin/productos/imagenes/eliminar',
      type: 'POST',
      dataType: 'json',
      data: {slug: slug, url: urlImage[6]},
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    })
    .done(function(obj) {
      if (obj.status) {
        $("div[element='"+img+"']").remove();
        Lobibox.notify('success', {
          title: 'Eliminación Exitosa',
          sound: true,
          msg: 'La imagen ha sido eliminada exitosamente.'
        });
      } else {
        Lobibox.notify('error', {
          title: 'Eliminación Fallida',
          sound: true,
          msg: 'Ha ocurrido un problema, intentelo nuevamente.'
        });
      }
    });
  }
});

// Cambiar tipo de descuento
$('#typeDiscount').change(function(event) {
  if ($(this).val()==1) {
    $('#categoryDiscount, #subcategoryDiscount').addClass('d-none');
    $('#categoryDiscount input, #categoryDiscount select, #subcategoryDiscount input, #subcategoryDiscount select').attr('disabled', true);
    $('#globalDiscount input').attr('disabled', false);
    $('#globalDiscount').removeClass('d-none');
  } else if ($(this).val()==2) {
    $('#globalDiscount, #subcategoryDiscount').addClass('d-none');
    $('#globalDiscount input, #subcategoryDiscount input, #subcategoryDiscount select').attr('disabled', true);
    $('#categoryDiscount input, #categoryDiscount select').attr('disabled', false);
    $('#categoryDiscount').removeClass('d-none');
  } else if ($(this).val()==3) {
    $('#globalDiscount, #categoryDiscount').addClass('d-none');
    $('#globalDiscount input, #categoryDiscount input, #categoryDiscount select').attr('disabled', true);
    $('#subcategoryDiscount input, #subcategoryDiscount select').attr('disabled', false);
    $('#subcategoryDiscount').removeClass('d-none');
  } else {
    $('#globalDiscount, #categoryDiscount, #subcategoryDiscount').addClass('d-none');
    $('#globalDiscount input, #categoryDiscount input, #categoryDiscount select, #subcategoryDiscount input, #subcategoryDiscount select').attr('disabled', true);
  }
});