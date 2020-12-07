<?php

namespace App\Http\Controllers\Api;

use App\User;
use App\Category;
use App\Subcategory;
use App\Product;
use App\Order;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class DataController extends ApiController
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
			$products=$category->subcategories()->with('products')->get()->pluck('products')->collapse()->unique('id')->values()->map(function($product) {
				return $this->dataProduct($product);
			});
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
				return $this->dataProduct($product);
			});
			return response()->json(["data" => $products], 200);
		}

		return response()->json(["message" => "Esta subcategoría no existe."], 404);
	}

	public function clients() {
		$clients=User::select("id", "name", "lastname", "slug", "photo", "email", "email_verified_at", "state", "type")->where('type', 2)->get()->map(function($client) {
			return $this->dataClient($client);
		});
		return response()->json(["data" => $clients], 200);
	}

	public function client($client) {
		$client=User::select("id", "name", "lastname", "slug", "photo", "email", "email_verified_at", "state", "type")->find($client);
		if (!is_null($client)) {
			$client=$this->dataClient($client);
			return response()->json(["data" => $client], 200);
		}

		return response()->json(["message" => "Este cliente no existe."], 404);
	}

	public function clientOrders($client) {
		$client=User::find($client);
		if (!is_null($client)) {
			$orders=$client->orders->map(function($order) {
				return $this->dataOrder($order);
			});

			return response()->json(["data" => $orders], 200);
		}

		return response()->json(["message" => "Este cliente no existe."], 404);
	}

	public function clientOrder($client, $order) {
		$client=User::find($client);
		if (!is_null($client)) {
			$order=Order::find($order);
			if (!is_null($order)) {
				$order=$client->orders()->where('id', $order->id)->first();
				if (!is_null($order)) {
					$order=$this->dataOrder($order);

					return response()->json(["data" => $order], 200);	
				}

				return response()->json(["message" => "Este pedido no pertenece a este cliente."], 403);
			}
			
			return response()->json(["message" => "Este pedido no existe."], 404);
		}

		return response()->json(["message" => "Este cliente no existe."], 404);
	}

	public function products() {
		$products=Product::select("id", "name", "slug", "code", "description", "qty", "price", "discount", "min", "max", "state")->get()->map(function($product) {
			return $this->dataProduct($product);
		});
		return response()->json(["data" => $products], 200);
	}

	public function product($product) {
		$product=Product::select("id", "name", "slug", "code", "description", "qty", "price", "discount", "min", "max", "state")->find($product);
		if (!is_null($product)) {
			$product=$this->dataProduct($product);
			return response()->json(["data" => $product], 200);
		}

		return response()->json(["message" => "Este producto no existe."], 404);
	}
}
