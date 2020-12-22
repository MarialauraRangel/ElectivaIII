<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApiController extends Controller
{
	public function dataProduct($product) {
		$categories=[];
		$subcategories=[];
		if (!is_null($product->subcategories)) {
			$subcategories=$product->subcategories->map(function($subcategory) {
				return array("name" => $subcategory->only("name")["name"]);
			});

			$categories=$product->subcategories()->with('category')->get()->pluck('category')->unique('id')->values()->map(function($category) {
				return array("name" => $category->only("name")["name"]);
			});
		}
		$colors=[];
		if (!is_null($product->colors)) {
			$colors=$product->colors->map(function($color) {
				$data=$color->only("name", "color");
				return array("name" => $data["name"], "color" => $data["color"]);
			});
		}
		$sizes=[];
		if (!is_null($product->sizes)) {
			$sizes=$product->sizes->map(function($size) {
				return array("name" => $size->only("name")["name"]);
			});
		}
		$images=[];
		if (!is_null($product->images)) {
			$images=$product->images->map(function($image) {
				return array("url" => asset('/admins/img/products')."/".$image->only("image")["image"]);
			});
		}
		$product=$product->only("id", "name", "slug", "code", "description", "qty", "price", "discount", "min", "max", "state");
		$product["state"]=($product["state"]==1) ? "Activo" : "Inactivo";
		$product["categories"]=$categories;
		$product["subcategories"]=$subcategories;
		$product["colors"]=$colors;
		$product["sizes"]=$sizes;
		$product["images"]=$images;

		return $product;
	}

	public function dataClient($client) {
		$client->photo=asset('/admins/img/admins')."/".$client->photo;
		$client->state=($client->state==1) ? "Activo" : "Inactivo";
		$client->type=typeUser($client->type, 0);

		return $client;
	}

	public function dataOrder($order) {
		$items=$order->items->map(function($item) {
			$product=(!is_null($item->product()->withTrashed()->first())) ? $item->product()->withTrashed()->first()->name : "";
			$size=(!is_null($item->size()->withTrashed()->first())) ? $item->size()->withTrashed()->first()->name : "";
			$color=(!is_null($item->color()->withTrashed()->first())) ? $item->color()->withTrashed()->first()->name : "";
			$item=$item->only("price", "discount", "qty", "subtotal");
			$item['product']=$product;
			$item['size']=$size;
			$item['color']=$color;
			return $item;
		});

		$user=[];
		if (!is_null($order->user()->withTrashed()->first())) {
			$user=$order->user()->withTrashed()->first()->only("id", "name", "lastname", "slug", "photo", "email", "email_verified_at", "state", "type");
			$user["photo"]=asset('/admins/img/admins')."/".$user["photo"];
			$user["state"]=(!is_null($order->user)) ? ($user["state"]==1) ? "Activo" : "Inactivo" : "Eliminado";
			$user["type"]=typeUser($user["type"], 0);
		}

		$payment=[];
		if (!is_null($order->payment)) {
			$payment=$order->payment->only("id", "slug", "subject", "subtotal", "delivery", "discount", "total", "fee", "balance", "method", "currency", "state", "created_at");
			$payment["method"]=methodPayment($payment["method"]);
			if ($payment["state"]==0) {
				$payment["state"]='Rechazado';
			} elseif ($payment["state"]==1) {
				$payment["state"]='Confirmado';
			} else {
				$payment["state"]='Pendiente';
			}
			$payment["created_at"]=$payment["created_at"]->format("d-m-Y H:i:s");
		}

		$shipping="";
		if (!is_null($order->shipping)) {
			$shipping=array('address' => $order->shipping->location()->withTrashed()->first()->municipality()->withTrashed()->first()->state()->withTrashed()->first()->country()->withTrashed()->first()->name.", ".$order->shipping->location()->withTrashed()->first()->municipality()->withTrashed()->first()->state()->withTrashed()->first()->name.", ".$order->shipping->location()->withTrashed()->first()->municipality()->withTrashed()->first()->name.", ".$order->shipping->location()->withTrashed()->first()->name.", ".$order->shipping->street.", casa número ".$order->shipping->house, 'aditional_information' => $order->shipping->address);
		}

		$order=$order->only("id", "slug", "phone", "type_delivery", "state", "created_at");
		if ($order["state"]==0) {
			$order["state"]='Rechazado';
		} elseif ($order["state"]==1) {
			$order["state"]='Confirmado';
		} else {
			$order["state"]='Pendiente';
		}
		$order["shipping"]=typeDelivery($order['type_delivery'], 0);
		$order['delivery_address']=$shipping;
		$order["created_at"]=$order["created_at"]->format("d-m-Y H:i:s");
		$order["items"]=$items;
		$order["user"]=$user;
		$order["payment"]=$payment;

		return $order;
	}
}