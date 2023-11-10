<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;
use App\Models\UserCart;

class BasketController extends Controller
{
    /**
     * Retrieve the user's shopping basket.
     */
    public function index()
    {
        try {
            $user = auth()->user();
            $cart = [];

            if ($user) {
                // If the user is authenticated, check if there are items in the session
                $sessionCart = session('cart', []);

                if (!empty($sessionCart)) {
                    // Transfer cart items from the session to the database and empty the session
                    foreach ($sessionCart as $carId => $sessionCartItem) {
                        $cartItem = UserCart::updateOrInsert(
                            [
                                'user_id' => $user->id,
                                'car_id' => $carId,
                                'created_at' => now(),
                                'updated_at' => now(),
                            ],
                            [
                                'quantity' => $sessionCartItem['quantity'],
                            ]
                        );
                    }
                    session(['cart' => []]); // Empty the session after transfer

                    // Retrieve the updated cart from the database
                    $cart = UserCart::where('user_id', $user->id)
                        ->with('car') // Load the 'car' relationship
                        ->get();
                } else {
                    // If there are no items in the session, simply fetch the cart items from the database
                    $cart = UserCart::where('user_id', $user->id)
                        ->with('car') // Load the 'car' relationship
                        ->get();
                }
            } else {
                // If the user is not authenticated, use cart items from the session
                $cart = session('cart', []);
            }

            return response()->json($cart);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while fetching the cart.'], 500);
        }
    }



    /**
     * Add a car to the shopping basket.
     */
    /**
     * Add a car to the shopping basket.
     */
    public function add(Request $request, $carId)
    {
        try {
            $user = auth()->user();

            if ($user) {
                // If the user is authenticated, store cart items in the database
                $cartItem = UserCart::where('user_id', $user->id)
                    ->where('car_id', $carId)
                    ->first();

                if ($cartItem) {
                    // Update the quantity if the item already exists in the database
                    $cartItem->quantity += 1;
                } else {
                    // Create a new cart item if it doesn't exist in the database
                    $cartItem = new UserCart([
                        'user_id' => $user->id,
                        'car_id' => $carId,
                        'quantity' => 1,
                    ]);
                }

                $cartItem->save();
                $cart = UserCart::where('user_id', $user->id)->get();
            } else {
                // If the user is not authenticated, store cart items in the session
                $cart = session('cart', []);

                if (array_key_exists($carId, $cart)) {
                    // If the item already exists in the session, update the quantity
                    $cart[$carId]['quantity'] += 1;
                } else {
                    // Create a new cart item in the session if it doesn't exist
                    $car = Car::find($carId);
                    $cart[$carId] = [
                        'id' => $car->id,
                        'brand' => $car->brand,
                        'model' => $car->model,
                        'price' => $car->price,
                        'engine_size' => $car->engine_size,
                        'car_id' => $carId,
                        'quantity' => 1,
                    ];
                }

                session(['cart' => $cart]);
            }

            return response()->json(['message' => 'Car added to cart', 'cart' => sizeof($cart)]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while adding the car to the cart.'], 500);
        }
    }


    /**
     * Update the quantity of a car in the shopping basket.
     */
    public function update(Request $request, $carId)
    {
        try {
            $user = auth()->user();

            if ($user) {

                $cartItem = UserCart::where('user_id', $user->id)
                    ->where('car_id', $carId)
                    ->first();


                if ($cartItem) {

                    $quantity = $request->input('quantity');

                    if ($quantity > 0) {
                        $cartItem->quantity = $quantity;
                        $cartItem->save();
                    } else {
                        $cartItem->delete();
                    }
                }
                $cart = UserCart::where('user_id', $user->id)->get();
            } else {

                $cart = session('cart', []);

                if (array_key_exists($carId, $cart)) {
                    $quantity = $request->input('quantity');

                    if ($quantity > 0) {
                        $cart[$carId]['quantity'] = $quantity;
                    } else {
                        unset($cart[$carId]);
                    }

                    session(['cart' => $cart]);
                }
            }

            return response()->json(['message' => 'Cart updated']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while updating the cart.'], 500);
        }
    }

    /**
     * Remove a car from the shopping basket.
     */
    public function remove($carId)
    {
        try {
            $user = auth()->user();
            $cart = [];

            if ($user) {
                $cartItem = UserCart::where('user_id', $user->id)
                    ->where('car_id', $carId)
                    ->first();

                if ($cartItem) {
                    $cartItem->delete();
                }
                $cart = UserCart::where('user_id', $user->id)->get();
            } else {
                $cart = session('cart', []);

                if (array_key_exists($carId, $cart)) {
                    unset($cart[$carId]);
                    session(['cart' => $cart]);
                }
            }

            return response()->json(['message' => 'Car removed from cart','cart'=>$cart]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while removing the car from the cart.'], 500);
        }
    }
}
