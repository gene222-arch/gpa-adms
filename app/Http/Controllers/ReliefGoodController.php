<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ReliefGood;
use Illuminate\Http\Request;

class ReliefGoodController extends Controller
{

    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Store Relief Assistance
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request)
    {
        return ReliefGood::create(
        [
            'category' => $request->category,
            'name' =>  $request->name,
            'quantity' =>  $request->quantity,
            'to' =>  $this->getRecipientNameById($request->to),
        ])->id;
    }


    /**
     * Remove a relief good by id
     *
     * @param [int] $id
     * @return boolean
     */
    public function destroyReliefGood(int $id)
    {
        return ReliefGood::find($id)->delete();
    }

    /**
     * Get Recipient name by user id
     *
     * @param [int] $id
     * @return string
     */
    public function getRecipientNameById(int $id): string
    {
        return $this->user->find($id)->name;
    }

}
