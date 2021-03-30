<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Invoice;
use Illuminate\Auth\Access\HandlesAuthorization;

class InvoicePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */

    /*
 *    public function before(User $user)
 *    {
 *
 *        if ($user->isAdmin()) {
 *            return true;
 *        }
 *    }
 */

    // needs to have same name as on Model
    public function view(User $user, Invoice $invoice)
    {
        return $user->email === $invoice->customer->email;
    }

    public function viewAny(User $user)
    {
        return $user->isCustomer();
    }
}
