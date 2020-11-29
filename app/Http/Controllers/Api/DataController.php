<?php

namespace App\Http\Controllers\Api;

use App\User;
use App\Category;
use App\Subcategory;
use App\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class DataController extends Controller
{
	public function categories() {
		$categories=Category::select("id", "name", "slug")->get();
		return response()->json(["data" => $categories], 200);
	}

	public function categorySubcategories($category) {
		$category=Category::find($category);
		if (!is_null($category)) {
			$subcategories=$category->subcategories()->select("id", "name", "slug")->get();
			return response()->json(["data" => $subcategories], 200);
		}

		return response()->json(["message" => "Esta categoría no existe."], 404);
	}

	public function categoryProducts($category) {
		$category=Category::find($category);
		if (!is_null($category)) {
			$num=0;
			$products=[];
			foreach ($category->subcategories()->with('products')->get()->pluck('products')->collapse()->unique('id')->values() as $product) {
				$images=[];
				if (!is_null($product->images)) {
					$images=$product->images->map(function($image) {
						return array("url" => asset('/admins/img/products')."/".$image->only("image")["image"]);
					});
				}
				$product=$product->only("id", "name", "slug", "code", "description", "qty", "price", "discount", "min", "max", "state");
				$product["state"]=($product["state"]==1) ? "Activo" : "Inactivo";
				$product["images"]=$images;
				$products[$num]=$product;
				$num++;
			}

			return response()->json(["data" => $products], 200);
		}

		return response()->json(["message" => "Esta categoría no existe."], 404);
	}

	public function subcategories() {
		$subcategories=Subcategory::select("id", "name", "slug")->get();
		return response()->json(["data" => $subcategories], 200);
	}

	public function subcategoryProducts($subcategory) {
		$subcategory=Subcategory::find($subcategory);
		if (!is_null($subcategory)) {
			$products=$subcategory->products->map(function($product) {
				$images=[];
				if (!is_null($product->images)) {
					$images=$product->images->map(function($image) {
						return array("url" => asset('/admins/img/products')."/".$image->only("image")["image"]);
					});
				}
				$product=$product->only("id", "name", "slug", "code", "description", "qty", "price", "discount", "min", "max", "state");
				$product["state"]=($product["state"]==1) ? "Activo" : "Inactivo";
				$product["images"]=$images;
				return $product;
			});
			return response()->json(["data" => $products], 200);
		}

		return response()->json(["message" => "Esta subcategoría no existe."], 404);
	}

	public function clients() {
		$clients=User::select("id", "name", "lastname", "slug", "photo", "email", "email_verified_at", "state", "type")->where('type', 2)->get()->map(function($client) {
			$client->photo=asset('/admins/img/admins')."/".$client->photo;
			$client->state=($client->state==1) ? "Activo" : "Inactivo";
			$client->type=typeUser($client->type, 0);
			return $client;
		});
		return response()->json(["data" => $clients], 200);
	}

	public function client($client) {
		$client=User::select("id", "name", "lastname", "slug", "photo", "email", "email_verified_at", "state", "type")->find($client);
		if (!is_null($client)) {
			$client->photo=asset('/admins/img/admins')."/".$client->photo;
			$client->state=($client->state==1) ? "Activo" : "Inactivo";
			$client->type=typeUser($client->type, 0);
			return response()->json(["data" => $client], 200);
		}

		return response()->json(["message" => "Este cliente no existe."], 404);
	}

	// public function clientOrders($client) {
	// 	$client=User::find($client);
	// 	if (!is_null($client)) {
	// 		$orders=$client->orders;
	// 		return response()->json(["data" => $orders], 200);
	// 	}

	// 	return response()->json(["message" => "Este cliente no existe."], 404);
	// }

	public function products() {
		$products=Product::select("id", "name", "slug", "code", "description", "qty", "price", "discount", "min", "max", "state")->get()->map(function($product) {
			$images=[];
			if (!is_null($product->images)) {
				$images=$product->images->map(function($image) {
					return array("url" => asset('/admins/img/products')."/".$image->only("image")["image"]);
				});
			}
			$product=$product->only("id", "name", "slug", "code", "description", "qty", "price", "discount", "min", "max", "state");
			$product["state"]=($product["state"]==1) ? "Activo" : "Inactivo";
			$product["images"]=$images;
			return $product;
		});
		return response()->json(["data" => $products], 200);
	}

	public function product($product) {
		$product=Product::select("id", "name", "slug", "code", "description", "qty", "price", "discount", "min", "max", "state")->find($product);
		if (!is_null($product)) {
			$images=[];
			if (!is_null($product->images)) {
				$images=$product->images->map(function($image) {
					return array("url" => asset('/admins/img/products')."/".$image->only("image")["image"]);
				});
			}
			$product=$product->only("id", "name", "slug", "code", "description", "qty", "price", "discount", "min", "max", "state");
			$product["state"]=($product["state"]==1) ? "Activo" : "Inactivo";
			$product["images"]=$images;
			return response()->json(["data" => $product], 200);
		}

		return response()->json(["message" => "Este producto no existe."], 404);
	}
}
