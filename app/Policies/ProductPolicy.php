<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Product;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy 
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function update(User $user, Product $product)
    {
        return $user->isAuthorOf($product);
    }

    public function destroy(User $user, Product $product)
    {
        return $user->isAuthorOf($product);
    }
}
