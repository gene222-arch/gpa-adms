<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ReliefGood;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ReliefGood\StoreReliefGood;
use App\Http\Requests\ReliefGood\UpdateReliefGood;

class ReliefGoodController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index(Request $request)
    {
        if ($request->wantsJson())
        {
            return response()->json($request->user('web')->relief_goods);
        }
        return view('users.dashboard', [
            'relief_goods' => $request->user('web')->relief_goods
        ]);
    }

    /**
     * Storing relief good created/sent by the User who's role is 'Volunteer'
     *
     * @return JSON response
     */
    public function store(StoreReliefGood $request)
    {
        $isStored = false;

        if ($request->user('web')->isVolunteer())
        {
            $request->user()->giveReliefAssistanceTo($this->validator($request));
            $isStored = true;
        }

        if ($request->wantsJson())
        {
            $message = $isStored ? 'Success' : 'Only volunteers can send a relief assistance';
            $code = $isStored ? 200 : 401;

            return response()->json([ 'message' => $message ], $code);
        }
    }


    public function update(UpdateReliefGood $request)
    {
        if ($request->wantsJson())
        {
            return response()->json(['message' => 'Success'], 200);
        }
    }

    /**
     * Removing the relief assistance created/sent by the User('Volunteer')
     *
     * @return JSON response
     */
    public function destroy(Request $request)
    {
        $isDestroyed = false;

        if ($request->user('web')->isVolunteer())
        {
            $request->user('web')->removeReliefAssistanceTo($request->id);
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
        return ReliefGood::create([
            'category' => $request->category,
            'name' =>  $request->name,
            'quantity' =>  $request->quantity,
            'to' =>  $request->to,
        ]);
    }

}
