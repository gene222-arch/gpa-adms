<?php

namespace App\Http\Controllers\User;

use App\Events\NewReliefAssistance;
use App\Models\User;
use App\Models\ReliefGood;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ReliefGood\StoreReliefGood;
use App\Http\Requests\ReliefGood\UpdateReliefGood;

class VolunteerController extends Controller
{

    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function dashboard()
    {
        return view('users.volunteer.dashboard');
    }


    /*
    |--------------------------------------------------------------------------
    ! GET Requests
    |--------------------------------------------------------------------------
    */

    /**
     * Show all user with a role of 'constituent'
     *
     * @return JSON response
     */
    public function showConstituentsLists(Request $request)
    {
        if ($request->wantsJson())
        {
            return response()->json($this->user->constituents(), 200);
        }
    }

    /**
     * Show all the relief_goods created by the user
     *
     * @return JSON response
     */
    public function showReliefAsstLists(Request $request)
    {
        if ($request->wantsJson())
        {
            return response()->json($request->user('web')->relief_goods);
        }
    }


    /*
    |--------------------------------------------------------------------------
    ! POST Requests
    |--------------------------------------------------------------------------
    */

    /**
     * Storing relief good created/sent by the user
     *
     * @return JSON response
     */
    public function store(StoreReliefGood $request)
    {

        $request->user()->giveReliefAssistanceTo($this->validator($request)->id, $request->to);
        $newReliefAsst = $request->user()->relief_goods()->with('users')->latest()->get()->first();

        event(new NewReliefAssistance($newReliefAsst));

        if ($request->wantsJson())
        {
            return response()->json([], 200);
        }
    }


    /*
    |--------------------------------------------------------------------------
    ! PUT Requests
    |--------------------------------------------------------------------------
    */

    public function update(UpdateReliefGood $request)
    {
        if ($request->wantsJson())
        {
            return response()->json(['message' => 'Success'], 200);
        }
    }



    /*
    |--------------------------------------------------------------------------
    ! DELETE Requests
    |--------------------------------------------------------------------------
    */
    /**
     * Removing the relief assistance created/sent by the User('Volunteer')
     *
     * @return JSON response
     */
    public function destroy(Request $request)
    {
        $isDestroyed = false;

        if ($request->user('web')->removeReliefAssistanceTo($request->id))
        {
            $isDestroyed = true;
        }

        if ($request->wantsJson())
        {
            $message = $isDestroyed ? 'Success' : 'Only volunteers can remove a relief assistance';
            $code = $isDestroyed ? 200 : 401;

            return response()->json([ 'message' => $message ], $code);
        }
    }

    protected function validator($request)
    {
        return ReliefGood::create(
        [
            'category' => $request->category,
            'name' =>  $request->name,
            'quantity' =>  $request->quantity,
            'to' =>  $this->user->find($request->to)->name,
        ]);
    }

}
