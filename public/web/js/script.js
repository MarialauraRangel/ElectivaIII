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
	.fail(function(obj) {
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
	});
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
		});
	}
});