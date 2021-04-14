<?php

namespace App\Policies;

use App\Models\LinePayTradeRecord;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RecordPolicy
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


    public function operate(User $user, LinePayTradeRecord $record)
    {
        return $user->isOrderOf($record);
    }
}
