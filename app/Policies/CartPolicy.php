<?php

namespace App\Policies;

use App\Models\Cart;
use App\Models\User;

class CartPolicy
{
    public function addToCart(User $user)
    {
        return true; // Atur sesuai kebutuhan
    }

    public function view(User $user, Cart $cart)
    {
        return $cart->user_id == $user->id;
    }

    public function update(User $user, Cart $cart)
    {
        return $user->id === $cart->user_id;
    }

    public function delete(User $user, Cart $cart)
    {
        return $user->id === $cart->user_id;
    }
}
