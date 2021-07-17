<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;

class CartController extends Controller
{
    //
    public function index()
    {
        // Pagina del carrito de compras (cart)
        // Tomar contenido del carro
        $items = \Cart::getContent();

        // devolver contenido
        return response()->json($items, 200);
    }

    public function add($productId)
    {
        // $_SERVER['HTTP_COOKIE']
        // verificar si el producto existe en el carrito
        $item = \Cart::get($productId);

        if ($item) { //si el item existe, actualizamos cantidad para sumar 1
            //obtener cantidad actual del producto
            $currentPdt = Product::findOrFail($productId);
            $currentQty = $currentPdt->quantity;

            //get cart product
            $item = \Cart::get($productId);
            //si la cantidad no excede el inventario entonces proceder

            if (($item->quantity + 1) <= $currentQty) {
                \Cart::update($productId, array(
                    'quantity' => 1, // so if the current product has a quantity of 4, another 2 will be added so this will result to 6
                ));
            } else {
                $items = \Cart::getTotalQuantity();
                // Cart::session($userId)->clear();
                return response()->json(["count" => $items, "id" => $productId], 202);
            }
        } else { //Si el producto no existe en el carro añadimos el producto
            //Buscar el producto requerido
            $product = \App\Product::findOrFail($productId);
            //añadir al carrito
            \Cart::add(array(
                'id' => $product->id,
                'name' => $product->nombre,
                'price' => $product->price,
                'quantity' => 1,
                'attributes' => array('short_des' => $product->short_des, "image" => $product->image),
                'associatedModel' => $product
            ));
        }
        // \Cart::clear();
        $items = \Cart::getTotalQuantity();
        // Cart::session($userId)->clear();
        return response()->json(["count" => $items, "id" => $productId], 200);
    }

    public function subs($productId) //restar item del carrito (siempre q tenga existencia o exista)
    {
        $qty = 0;
        //buscar el producto en el carrito
        $item = \Cart::get($productId);
        if ($item) { //si el item se encuentra en el carrito
            if ($item->quantity > 1) { //si aún hay cantidad en el carrito restar
                \Cart::update($productId, array(
                    'quantity' => -1, // so if the current product has a quantity of 4, it will subtract 1 and will result to 3
                ));
                $item = \Cart::get($productId);
                $qty = $item->quantity;
            } else { //sino, remover
                \Cart::remove($productId);
                $qty = 0;
            }
        }
        $items = \Cart::getTotalQuantity();
        return response()->json(["count" => $items, "id" => $productId, "qty" => intval($qty)], 200);
    }

    public function cartCount()
    {
        $items = \Cart::getTotalQuantity();
        // Cart::session($userId)->clear();
        return response()->json($items, 200);
    }

    public function total()
    {
        $amount = \Cart::getTotal();
        // Cart::session($userId)->clear();
        return response()->json($amount, 200);
    }

    public function countProductInCart($id)
    {
        $qty = 0;
        $item = \Cart::get($id);
        if ($item) { //si el item se encuentra en el carrito
            $qty = $item->quantity;
        }
        return response()->json($qty, 200);
    }

    public function removeItem($id)
    {
        \Cart::remove($id);

        $response = \Cart::isEmpty();
        return response()->json($response, 200);
    }

    public function isInCart($id)
    {
        $item = \Cart::get($id);
        if ($item) {
            $qty = $item->quantity;
            return response()->json(["is" => true, "qty" => $qty], 200);
        } else {
            return response()->json(["is" => false, "qty" => 0], 200);
        }
    }
}
