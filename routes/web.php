<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/////////////////////////////////////// AUTH ////////////////////////////////////////////////////

Auth::routes();
Route::get('/administradores/email', 'AdminController@emailVerifyAdmin');
Route::post('/subcategorias/agregar', 'SubcategoryController@addSubcategories');
Route::post('/municipios/agregar', 'AdminController@addMunicipalities');
Route::post('/localidades/agregar', 'AdminController@addLocations');

Route::group(['middleware' => ['auth']], function () {
	Route::post('/salir', 'AuthController@logout')->name('logout.custom');
});

/////////////////////////////////////////////// WEB ////////////////////////////////////////////////
Route::get('/', 'WebController@index')->name('home');
Route::get('/nosotros', 'WebController@about')->name('about');
Route::get('/tienda', 'WebController@shop')->name('shop');
Route::get('/producto/{slug}', 'WebController@product')->name('product');
Route::get('/contacto', 'WebController@contact')->name('contact');
Route::post('/contacto', 'SettingController@send')->name('contact.send');
Route::get('/terminos-y-condiciones', 'WebController@terms')->name('terms');
Route::get('/politicas-de-privacidad', 'WebController@privacity')->name('privacity');
Route::get('/carrito', 'WebController@cart')->name('cart.index');
Route::post('/carrito', 'WebController@cartAdd')->name('cart.add');
Route::post('/carrito/quitar', 'WebController@cartRemove')->name('cart.remove');
Route::post('/carrito/cantidad', 'WebController@cartQty')->name('cart.qty');
Route::get('/comprar', 'WebController@checkout')->name('checkout');
Route::post('/cupon/agregar', 'WebController@couponAdd')->name('coupon.add');
Route::post('/cupon/quitar', 'WebController@couponRemove')->name('coupon.remove');
Route::post('/comprar', 'PaymentController@pay')->name('pay');
Route::get('/paypal/estado', 'PaymentController@paypalStatus')->name('paypal.status');
Route::get('/paypal/cancelado', 'PaymentController@paypalCancel')->name('paypal.cancel');

Route::group(['middleware' => ['auth']], function () {
	Route::get('/perfil', 'WebController@profile')->name('web.profile');
	Route::put('/perfil', 'WebController@profileUpdate')->name('web.profile.update');
	Route::get('/perfil/compras/{slug}', 'WebController@order')->name('order');
});

Route::group(['middleware' => ['auth', 'admin']], function () {
	/////////////////////////////////////// ADMIN ///////////////////////////////////////////////////

	// Inicio
	Route::get('/admin', 'AdminController@index')->name('admin');
	Route::get('/admin/perfil', 'AdminController@profile')->name('profile');
	Route::get('/admin/perfil/editar', 'AdminController@profileEdit')->name('profile.edit');
	Route::put('/admin/perfil/', 'AdminController@profileUpdate')->name('profile.update');

	// Administradores
	Route::get('/admin/administradores', 'AdministratorController@index')->name('administradores.index');
	Route::get('/admin/administradores/registrar', 'AdministratorController@create')->name('administradores.create');
	Route::post('/admin/administradores', 'AdministratorController@store')->name('administradores.store');
	Route::get('/admin/administradores/{slug}', 'AdministratorController@show')->name('administradores.show');
	Route::get('/admin/administradores/{slug}/editar', 'AdministratorController@edit')->name('administradores.edit');
	Route::put('/admin/administradores/{slug}', 'AdministratorController@update')->name('administradores.update');
	Route::delete('/admin/administradores/{slug}', 'AdministratorController@destroy')->name('administradores.delete');
	Route::put('/admin/administradores/{slug}/activar', 'AdministratorController@activate')->name('administradores.activate');
	Route::put('/admin/administradores/{slug}/desactivar', 'AdministratorController@deactivate')->name('administradores.deactivate');

	// Usuarios
	Route::get('/admin/usuarios', 'UserController@index')->name('usuarios.index');
	Route::get('/admin/usuarios/registrar', 'UserController@create')->name('usuarios.create');
	Route::post('/admin/usuarios', 'UserController@store')->name('usuarios.store');
	Route::get('/admin/usuarios/{slug}', 'UserController@show')->name('usuarios.show');
	Route::get('/admin/usuarios/{slug}/editar', 'UserController@edit')->name('usuarios.edit');
	Route::put('/admin/usuarios/{slug}', 'UserController@update')->name('usuarios.update');
	Route::delete('/admin/usuarios/{slug}', 'UserController@destroy')->name('usuarios.delete');
	Route::put('/admin/usuarios/{slug}/activar', 'UserController@activate')->name('usuarios.activate');
	Route::put('/admin/usuarios/{slug}/desactivar', 'UserController@deactivate')->name('usuarios.deactivate');

	// Banners
	Route::get('/admin/banners', 'BannerController@index')->name('banners.index');
	Route::get('/admin/banners/registrar', 'BannerController@create')->name('banners.create');
	Route::post('/admin/banners', 'BannerController@store')->name('banners.store');
	Route::get('/admin/banners/{slug}/editar', 'BannerController@edit')->name('banners.edit');
	Route::put('/admin/banners/{slug}', 'BannerController@update')->name('banners.update');
	Route::delete('/admin/banners/{slug}', 'BannerController@destroy')->name('banners.delete');
	Route::put('/admin/banners/{slug}/activar', 'BannerController@activate')->name('banners.activate');
	Route::put('/admin/banners/{slug}/desactivar', 'BannerController@deactivate')->name('banners.deactivate');

	// Categorias
	Route::get('/admin/categorias', 'CategoryController@index')->name('categorias.index');
	Route::get('/admin/categorias/registrar', 'CategoryController@create')->name('categorias.create');
	Route::post('/admin/categorias', 'CategoryController@store')->name('categorias.store');
	Route::get('/admin/categorias/{slug}/editar', 'CategoryController@edit')->name('categorias.edit');
	Route::put('/admin/categorias/{slug}', 'CategoryController@update')->name('categorias.update');
	Route::delete('/admin/categorias/{slug}', 'CategoryController@destroy')->name('categorias.delete');

	// Subcategorías
	Route::get('/admin/subcategorias', 'SubcategoryController@index')->name('subcategorias.index');
	Route::get('/admin/subcategorias/registrar', 'SubcategoryController@create')->name('subcategorias.create');
	Route::post('/admin/subcategorias', 'SubcategoryController@store')->name('subcategorias.store');
	Route::get('/admin/subcategorias/{slug}/editar', 'SubcategoryController@edit')->name('subcategorias.edit');
	Route::put('/admin/subcategorias/{slug}', 'SubcategoryController@update')->name('subcategorias.update');
	Route::delete('/admin/subcategorias/{slug}', 'SubcategoryController@destroy')->name('subcategorias.delete');

	// Productos
	Route::get('/admin/productos', 'ProductController@index')->name('productos.index');
	Route::get('/admin/productos/registrar', 'ProductController@create')->name('productos.create');
	Route::post('/admin/productos', 'ProductController@store')->name('productos.store');
	Route::get('/admin/productos/{slug}/editar', 'ProductController@edit')->name('productos.edit');
	Route::put('/admin/productos/{slug}', 'ProductController@update')->name('productos.update');
	Route::delete('/admin/productos/{slug}', 'ProductController@destroy')->name('productos.delete');
	Route::put('/admin/productos/{slug}/activar', 'ProductController@activate')->name('productos.activate');
	Route::put('/admin/productos/{slug}/desactivar', 'ProductController@deactivate')->name('productos.deactivate');
	Route::post('/admin/productos/imagenes', 'ProductController@file')->name('productos.store.images');
	Route::post('/admin/productos/imagenes/editar', 'ProductController@fileEdit')->name('productos.edit.images');
	Route::post('/admin/productos/imagenes/eliminar', 'ProductController@fileDestroy')->name('productos.destroy.images');

	// Cupones
	Route::get('/admin/cupones', 'CouponController@index')->name('cupones.index');
	Route::get('/admin/cupones/registrar', 'CouponController@create')->name('cupones.create');
	Route::post('/admin/cupones', 'CouponController@store')->name('cupones.store');
	Route::get('/admin/cupones/{slug}/editar', 'CouponController@edit')->name('cupones.edit');
	Route::put('/admin/cupones/{slug}', 'CouponController@update')->name('cupones.update');
	Route::delete('/admin/cupones/{slug}', 'CouponController@destroy')->name('cupones.delete');

	// Pedidos
	Route::get('/admin/pedidos', 'OrderController@index')->name('pedidos.index');
	Route::get('/admin/pedidos/{slug}', 'OrderController@show')->name('pedidos.show');
	Route::put('/admin/pedidos/{slug}/activar', 'OrderController@activate')->name('pedidos.activate');
	Route::put('/admin/pedidos/{slug}/desactivar', 'OrderController@deactivate')->name('pedidos.deactivate');

	// Pagos
	Route::get('/admin/pagos', 'PaymentController@index')->name('pagos.index');
	Route::get('/admin/pagos/{slug}', 'PaymentController@show')->name('pagos.show');
	Route::put('/admin/pagos/{slug}/activar', 'PaymentController@activate')->name('pagos.activate');
	Route::put('/admin/pagos/{slug}/desactivar', 'PaymentController@deactivate')->name('pagos.deactivate');

	// Tallas
	Route::get('/admin/tallas', 'SizeController@index')->name('tallas.index');
	Route::get('/admin/tallas/registrar', 'SizeController@create')->name('tallas.create');
	Route::post('/admin/tallas', 'SizeController@store')->name('tallas.store');
	Route::get('/admin/tallas/{slug}/editar', 'SizeController@edit')->name('tallas.edit');
	Route::put('/admin/tallas/{slug}', 'SizeController@update')->name('tallas.update');
	Route::delete('/admin/tallas/{slug}', 'SizeController@destroy')->name('tallas.delete');

	// Colores
	Route::get('/admin/colores', 'ColorController@index')->name('colores.index');
	Route::get('/admin/colores/registrar', 'ColorController@create')->name('colores.create');
	Route::post('/admin/colores', 'ColorController@store')->name('colores.store');
	Route::get('/admin/colores/{slug}/editar', 'ColorController@edit')->name('colores.edit');
	Route::put('/admin/colores/{slug}', 'ColorController@update')->name('colores.update');
	Route::delete('/admin/colores/{slug}', 'ColorController@destroy')->name('colores.delete');

	// Envios
	Route::get('/admin/envios/editar', 'SettingController@editDeliveries')->name('envios.edit');
	Route::put('/admin/envios', 'SettingController@updateDeliveries')->name('envios.update');

	// Descuentos
	Route::get('/admin/descuentos/editar', 'SettingController@editDiscounts')->name('descuentos.edit');
	Route::put('/admin/descuentos', 'SettingController@updateDiscounts')->name('descuentos.update');

	// Nosotros
	Route::get('/admin/nosotros/editar', 'SettingController@editAbouts')->name('nosotros.edit');
	Route::put('/admin/nosotros', 'SettingController@updateAbouts')->name('nosotros.update');

	// Términos y condiciones
	Route::get('/admin/terminos/editar', 'SettingController@editTerms')->name('terminos.edit');
	Route::put('/admin/terminos', 'SettingController@updateTerms')->name('terminos.update');

	// Politicas de privacidad
	Route::get('/admin/politicas/editar', 'SettingController@editPolitics')->name('politicas.edit');
	Route::put('/admin/politicas', 'SettingController@updatePolitics')->name('politicas.update');

	// Contactos
	Route::get('/admin/contactos/editar', 'SettingController@editContacts')->name('contactos.edit');
	Route::put('/admin/contactos', 'SettingController@updateContacts')->name('contactos.update');







	// Importar
	Route::get('/admin/importar/productos', 'SettingController@importProducts')->name('importar.products');
	Route::put('/admin/importar', 'SettingController@importProductsData')->name('importar.products.data');
});