(function($) {

	"use strict";

	$('[data-toggle="tooltip"]').tooltip();

 	// loader
 	var loader = function() {
 		setTimeout(function() { 
 			if($('#ftco-loader').length > 0) {
 				$('#ftco-loader').removeClass('show');
 			}
 		}, 1);
 	};
 	loader();

 })(jQuery);

//////// Scripts ////////
$(document).ready(function() {
	//Validación para introducir solo números
	$('.number').keypress(function() {
		return event.charCode >= 48 && event.charCode <= 57;
	});

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

 	//touchspin
 	if ($('.int').length) {
 		$(".int").TouchSpin({
 			min: 1,
 			max: 99,
 			buttondown_class: 'btn btn-primary px-3 py-1 rounded-0',
 			buttonup_class: 'btn btn-primary px-3 py-1 rounded-0'
 		});
 	}

 	if ($('.qty-max').length) {
 		var max=$(".qty-max").attr('max');
 		$(".qty-max").TouchSpin({
 			min: 1,
 			max: max,
 			buttondown_class: 'btn btn-primary px-3 py-1 rounded-0',
 			buttonup_class: 'btn btn-primary px-3 py-1 rounded-0'
 		});
 	}

 	if ($('.qty').length) {
 		$(".qty").each(function(){
 			var max=$(this).attr('max');
 			$(this).TouchSpin({
 				min: 1,
 				max: max,
 				buttondown_class: 'btn btn-primary px-2 py-1 rounded-0',
 				buttonup_class: 'btn btn-primary px-2 py-1 rounded-0'
 			});
 		});
 	}

 	if ($('.min').length) {
 		$('.min').TouchSpin({
 			min: 0,
 			max: 9999999,
 			buttondown_class: 'btn btn-primary px-2 py-1 rounded-0',
 			buttonup_class: 'btn btn-primary px-2 py-1 rounded-0'
 		});
 	}

 	if ($('.max').length) {
 		$('.max').TouchSpin({
 			min: 0,
 			max: 9999999,
 			buttondown_class: 'btn btn-primary px-2 py-1 rounded-0',
 			buttonup_class: 'btn btn-primary px-2 py-1 rounded-0'
 		});
 	}

	//Lightslider
	if ($("#lightgallery-product").length) {
		$('#lightgallery-product').lightSlider({
			gallery: true,
			item: 1,
			thumbItem: 5,
			vThumbWidth: 70,
			vThumbHeight: 80,
			slideMargin: 0,
			enableDrag: false
		});
	}

	// Lightgallery
	if ($("#lightgallery-product").length) {
		$("#lightgallery-product").lightGallery();
	}
});

// Cambiar min y max de inputs touchspins en tienda
$('.min').change(function() {
	$('.max').trigger("touchspin.updatesettings", {min: $(this).val()});
});

$('.min').keyup(function() {
	$('.max').trigger("touchspin.updatesettings", {min: $(this).val()});
});

$('.max').change(function() {
	if ($('.min').val()!="" && $('.max').val()<$('.min').val()) {
		$('.max').val($('.min').val());
	}
	$('.min').trigger("touchspin.updatesettings", {max: $(this).val()});
});

$('.max').keyup(function() {
	if ($('.min').val()!="" && $('.max').val()<$('.min').val()) {
		$('.max').val($('.min').val());
	}
	$('.min').trigger("touchspin.updatesettings", {max: $(this).val()});
});

// funcion para seleccionar el color en el producto
$('#selectColors div').click(function(event) {
	$('#selectColors div').removeClass('active');
	$(this).addClass('active');
});

// Calcular precio al cambiar la cantidad del producto en las vista de producto
$('#product-qty-cart').change(function() {
	var total=$(this).attr('price')*$(this).val();
	total=new Intl.NumberFormat("de-DE", {style: 'decimal', minimumFractionDigits: 2}).format(total);
	$('#price-product-add-cart').text("$"+total);
});

$('#product-qty-cart').keyup(function() {
	var total=$(this).attr('price')*$(this).val();
	total=new Intl.NumberFormat("de-DE", {style: 'decimal', minimumFractionDigits: 2}).format(total);
	$('#price-product-add-cart').text("$"+total);
});

// Agregar producto del carrito
$('#product-add-cart').click(function(event) {
	var product=$(this).attr('slug'), qty=$('#product-qty-cart').val(), size=null, color=null;
	if ($('#product-size-cart').length) {
		size=$('#product-size-cart').val();
	}
	if ($('#selectColors').length) {
		color=$('#selectColors div.square-color.active').attr('slug');
	}
	$.ajax({
		url: '/carrito',
		type: 'POST',
		dataType: 'json',
		data: {product: product, qty: qty, color: color, size: size},
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	})
	.done(function(obj) {
		if (obj.status) {
			$(".count-cart").text(obj.qty);
			Lobibox.notify('success', {
				title: 'Producto agregado',
				sound: true,
				msg: 'El producto a sido agregado al carrito exitosamente.'
			});
		} else {
			Lobibox.notify('error', {
				title: 'Error',
				sound: true,
				msg: 'Ha ocurrido un problema, intentelo nuevamente.'
			});
		}
	})
	.fail(function() {
		Lobibox.notify('error', {
			title: 'Error',
			sound: true,
			msg: 'Ha ocurrido un problema, intentelo nuevamente.'
		});
	});
});

//Quitar producto del carrito
$('.product-remove a').click(function() {
	var code=$(this).attr('code');
	$.ajax({
		url: '/carrito/quitar',
		type: 'POST',
		dataType: 'json',
		data: {code: code},
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	}).done(function(obj) {
		if (obj.status) {
			$(".cart-product[code='"+code+"']").remove();
			$(".count-cart").text(obj.qty);
			Lobibox.notify('success', {
				title: 'Producto eliminado',
				sound: true,
				msg: 'El producto ha sido removido del carrito exitosamente.'
			});
		} else {
			Lobibox.notify('error', {
				title: 'Error',
				sound: true,
				msg: 'Ha ocurrido un problema, intentelo nuevamente.'
			});
		}
	})
	.fail(function() {
		Lobibox.notify('error', {
			title: 'Error',
			sound: true,
			msg: 'Ha ocurrido un problema, intentelo nuevamente.'
		});
	});
});

//Al cambiar la cantidad de un producto en el carrito cambia el total
$('.qty').change(function() {
	var code=$(this).attr('code'), slug=$(this).attr('slug'), qty=$(this).val();
	$.ajax({
		url: '/carrito/cantidad',
		type: 'POST',
		dataType: 'json',
		data: {qty: qty, slug: slug, code: code},
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	})
	.done(function(obj) {
		if (obj.status) {
			$('.total[code="'+code+'"]').text("$"+obj.subtotal);
			var total=0;
			$(".qty").each(function(){
				var subtotal=$(this).attr('price')*$(this).val();
				total+=subtotal;
			});
			total=new Intl.NumberFormat("de-DE", {style: 'decimal', minimumFractionDigits: 2}).format(total);
			$('#total-cart').text("$"+total);
		} else {
			Lobibox.notify('error', {
				title: 'Error',
				sound: true,
				msg: 'Ha ocurrido un problema, intentelo nuevamente.'
			});
		}
	})
	.fail(function() {
		Lobibox.notify('error', {
			title: 'Error',
			sound: true,
			msg: 'Ha ocurrido un problema, intentelo nuevamente.'
		});
	});
});

$('.qty').keyup(function() {
	var code=$(this).attr('code'), slug=$(this).attr('slug'), qty=$(this).val();
	$.ajax({
		url: '/carrito/cantidad',
		type: 'POST',
		dataType: 'json',
		data: {qty: qty, slug: slug, code: code},
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	})
	.done(function(obj) {
		if (obj.status) {
			$('.total[code="'+code+'"]').text("$"+obj.subtotal);
			var total=0;
			$(".qty").each(function(){
				var subtotal=$(this).attr('price')*$(this).val();
				total+=subtotal;
			});
			total=new Intl.NumberFormat("de-DE", {style: 'decimal', minimumFractionDigits: 2}).format(total);
			$('#total-cart').text("$"+total);
		} else {
			Lobibox.notify('error', {
				title: 'Error',
				sound: true,
				msg: 'Ha ocurrido un problema, intentelo nuevamente.'
			});
		}
	})
	.fail(function() {
		Lobibox.notify('error', {
			title: 'Error',
			sound: true,
			msg: 'Ha ocurrido un problema, intentelo nuevamente.'
		});
	});
});

// Cambiar metodo de envio
$('#selectDelivery').change(function() {
	if ($(this).val()==2) {
		var subtotal=parseFloat($("#subtotal").attr('subtotal')), discount=parseFloat($("#discount").attr('discount'));
		var total=parseFloat(subtotal-discount);
		var totalFormat=new Intl.NumberFormat("de-DE", {style: 'decimal', minimumFractionDigits: 2}).format(total);
		$("#delivery").attr('delivery', '0.00');
		$("#delivery").text('$0,00');
		$("#total").attr('total', total);
		$("#total").text('$'+totalFormat);
	} else {
		var subtotal=parseFloat($("#subtotal").attr('subtotal')), delivery=parseFloat($("#total").attr('delivery')), discountPercentile=parseInt($("#discount").attr('discount'));
		var deliveryFormat=new Intl.NumberFormat("de-DE", {style: 'decimal', minimumFractionDigits: 2}).format(delivery);
		var discount=(parseFloat(subtotal+delivery)*discountPercentile)/100;
		var total=parseFloat(subtotal+delivery)-discount;
		var totalFormat=new Intl.NumberFormat("de-DE", {style: 'decimal', minimumFractionDigits: 2}).format(total);

		$("#delivery").attr('delivery', delivery.toFixed(2));
		$("#delivery").text('$'+deliveryFormat);
		$("#total").attr('total', total.toFixed(2));
		$("#total").text('$'+totalFormat);
	}
});

// Cambiar metodo de pago
$('#selectMethod').change(function() {
	if ($(this).val()==2) {
		$('#transfer input').attr('disabled', true);
		$('#transfer').addClass('d-none');
	} else if ($(this).val()==3) {
		$('#transfer input').attr('disabled', true);
		$('#transfer').addClass('d-none');
	} else {
		$('#transfer input').attr('disabled', false);
		$('#transfer').removeClass('d-none');
	}
});

// Abrir y cerrar agregar cupones
$('#btn-coupon').click(function(event) {
	toggleBtnCoupon();
});

function toggleBtnCoupon() {
	$("#card-add-coupon").toggle(800);
	if ($(this).hasClass('open')) {
		$(this).text('Agregar cupón de descuento');
		$(this).removeClass('open');
	} else {
		$(this).text('Cerrar cupón de descuento');
		$(this).addClass('open');
	}
}

// Agregar cupón
$('#btn-add-coupon').click(function() {
	addCoupon();
});

function addCoupon() {
	$("#card-add-coupon p").addClass('d-none');
	$('#btn-add-coupon').attr('disabled', true);
	var coupon=$('#input-coupon').val();
	if (coupon!="") {
		$.ajax({
			url: '/cupon/agregar',
			type: 'POST',
			dataType: 'json',
			data: {coupon: coupon},
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		})
		.done(function(obj) {
			if (obj.state) {
				$("#div-coupon div").remove();
				$("#div-coupon").html('<div class="alert alert-success">'+
					'<div>'+
					'<p class="mb-1">El cupón de descuendo ha sido agregado</p>'+
					'<a href="javascript:void(0);" id="remove-coupon">Quitar cupón</a>'+
					'</div>'+
					'<div>');

				// Quitar cupón
				$('#remove-coupon').on('click', function() {
					removeCoupon();
				});

				var subtotal=parseFloat($("#subtotal").attr('subtotal')), delivery=parseFloat($("#delivery").attr('delivery'));
				var discount=(parseFloat(subtotal+delivery)*parseInt(obj.discount))/100;
				var discountFormat=new Intl.NumberFormat("de-DE", {style: 'decimal', minimumFractionDigits: 2}).format(discount);
				var total=parseFloat(subtotal+delivery)-discount;
				var totalFormat=new Intl.NumberFormat("de-DE", {style: 'decimal', minimumFractionDigits: 2}).format(total);

				$("#discount").attr('subtotal', discount.toFixed(2));
				$("#discount").text('- $'+discountFormat);
				$("#total").attr('total', total.toFixed(2));
				$("#total").text('$'+totalFormat);
				Lobibox.notify('success', {
					title: 'Cupón agregado',
					sound: true,
					msg: 'El cupón ha sido agregado exitosamente.'
				});
			} else {
				$('#btn-add-coupon').attr('disabled', false);
				Lobibox.notify('error', {
					title: obj.title,
					sound: true,
					msg: obj.message
				});
			}
		})
		.fail(function() {
			$('#btn-add-coupon').attr('disabled', false);
			Lobibox.notify('error', {
				title: 'Error',
				sound: true,
				msg: 'Ha ocurrido un problema, intentelo nuevamente.'
			});
		});
	} else {
		$("#card-add-coupon p").removeClass('d-none');
		$('#btn-add-coupon').attr('disabled', false);
	}
}

// Quitar cupón
$('#remove-coupon').click(function() {
	removeCoupon();
});

function removeCoupon() {
	$.ajax({
		url: '/cupon/quitar',
		type: 'POST',
		dataType: 'json',
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	})
	.done(function(obj) {
		if (obj.state) {
			$("#div-coupon div").remove();
			$("#div-coupon").html('<div>'+
				'<a href="javascript:void(0);" id="btn-coupon">Agregar cupón de descuento</a>'+
				'<div class="row" style="display: none;" id="card-add-coupon">'+
				'<div class="form-group col-lg-8 col-md-8 col-12">'+
				'<input type="text" class="form-control" name="coupon" placeholder="Introduzca un coupon" id="input-coupon">'+
				'<p class="text-danger font-weight-bold d-none mb-0">Este campo es requerido</p>'+
				'</div>'+
				'<div class="form-group col-lg-4 col-md-4 col-12">'+
				'<button type="button" class="btn btn-dark rounded w-100" id="btn-add-coupon">Agregar</button>'+
				'</div>'+
				'</div>'+
				'</div>');

			// Abrir y cerrar agregar cupones
			$('#btn-coupon').on('click', function(event) {
				toggleBtnCoupon();
			});

			// Agregar cupón
			$('#btn-add-coupon').on('click', function() {
				addCoupon();
			});

			var subtotal=parseFloat($("#subtotal").attr('subtotal')), delivery=parseFloat($("#delivery").attr('delivery'));
			var total=parseFloat(subtotal+delivery);
			var totalFormat=new Intl.NumberFormat("de-DE", {style: 'decimal', minimumFractionDigits: 2}).format(total);
			$("#discount").attr('subtotal', '0.00');
			$("#discount").text('- $0,00');
			$("#total").attr('total', total);
			$("#total").text('$'+totalFormat);
			Lobibox.notify('success', {
				title: 'Cupón Removido',
				sound: true,
				msg: 'El cupón ha sido removido exitosamente.'
			});
		} else {
			Lobibox.notify('error', {
				title: 'Error',
				sound: true,
				msg: 'Ha ocurrido un problema, intentelo nuevamente.'
			});
		}
	})
	.fail(function() {
		Lobibox.notify('error', {
			title: 'Error',
			sound: true,
			msg: 'Ha ocurrido un problema, intentelo nuevamente.'
		});
	});
}

// Agregar subcategorías en select del filtro de la tienda
$('#shopCategories').change(function() {
	var slug=$('#shopCategories option:selected').val();
	$('#shopSubcategories option').remove();
	$('#shopSubcategories').append($('<option>', {
		value: '',
		text: 'Todas las subcategorías'
	}));
	if (slug!="") {
		$.ajax({
			url: '/subcategorias/agregar',
			type: 'POST',
			dataType: 'json',
			data: {slug: slug},
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		})
		.done(function(obj) {
			if (obj.state) {
				$('#shopSubcategories option[value!=""]').remove();
				for (var i=obj.data.length-1; i>=0; i--) {
					$('#shopSubcategories').append($('<option>', {
						value: obj.data[i].slug,
						text: obj.data[i].name
					}));
				}
			} else {
				Lobibox.notify('error', {
					title: 'Error',
					sound: true,
					msg: 'Ha ocurrido un problema, intentelo nuevamente.'
				});
			}
		})
		.fail(function() {
			Lobibox.notify('error', {
				title: 'Error',
				sound: true,
				msg: 'Ha ocurrido un problema, intentelo nuevamente.'
			});
		});
	}
});

// Agregar municipios en select
$('#selectStates').change(function() {
	var id=$('#selectStates option:selected').val();
	$('#selectMunicipalities option, #selectLocations option').remove();
	$('#selectMunicipalities, #selectLocations').append($('<option>', {
		value: '',
		text: 'Seleccione'
	}));
	if (id!="") {
		$.ajax({
			url: '/municipios/agregar',
			type: 'POST',
			dataType: 'json',
			data: {id: id},
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		})
		.done(function(obj) {
			if (obj.state) {
				$('#selectMunicipalities option[value!=""]').remove();
				for (var i=obj.data.length-1; i>=0; i--) {
					$('#selectMunicipalities').append($('<option>', {
						value: obj.data[i].id,
						text: obj.data[i].name
					}));
				}
			} else {
				Lobibox.notify('error', {
					title: 'Error',
					sound: true,
					msg: 'Ha ocurrido un problema, intentelo nuevamente.'
				});
			}
		})
		.fail(function() {
			Lobibox.notify('error', {
				title: 'Error',
				sound: true,
				msg: 'Ha ocurrido un problema, intentelo nuevamente.'
			});
		});
	}
});

// Agregar localidades en select
$('#selectMunicipalities').change(function() {
	var id=$('#selectMunicipalities option:selected').val();
	$('#selectLocations option').remove();
	$('#selectLocations').append($('<option>', {
		value: '',
		text: 'Seleccione'
	}));
	if (id!="") {
		$.ajax({
			url: '/localidades/agregar',
			type: 'POST',
			dataType: 'json',
			data: {id: id},
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		})
		.done(function(obj) {
			if (obj.state) {
				$('#selectLocations option[value!=""]').remove();
				for (var i=obj.data.length-1; i>=0; i--) {
					$('#selectLocations').append($('<option>', {
						value: obj.data[i].id,
						text: obj.data[i].name
					}));
				}
			} else {
				Lobibox.notify('error', {
					title: 'Error',
					sound: true,
					msg: 'Ha ocurrido un problema, intentelo nuevamente.'
				});
			}
		})
		.fail(function() {
			Lobibox.notify('error', {
				title: 'Error',
				sound: true,
				msg: 'Ha ocurrido un problema, intentelo nuevamente.'
			});
		});
	}
});