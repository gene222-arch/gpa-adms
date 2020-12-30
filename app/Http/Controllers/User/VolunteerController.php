<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use App\Models\ReliefGood;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Events\NewReliefAssistanceEvent;
use App\Events\OnRemoveReliefAssistanceEvent;
use App\Http\Controllers\ReliefGoodController;
use App\Http\Requests\ReliefGood\StoreReliefGood;
use App\Http\Requests\ReliefGood\UpdateReliefGood;

class VolunteerController extends Controller
{

    private $user;
    private $reliefGoodController;

    public function __construct(User $user, ReliefGoodController $reliefGoodController)
    {
        $this->user = $user;
        $this->reliefGoodController = $reliefGoodController;
    }


/*
|--------------------------------------------------------------------------
* GET Requests
|--------------------------------------------------------------------------
*/

    /**
     * Show all user with a role of 'constituent'
     *
     * @return JSON response
     */
    public function showVolunteerRecipientsLists(Request $request)
    {
        if ($request->wantsJson())
        {
            return response()->json($this->user->recipients(), 200);
        }
    }

    /**
     * Show all the reliefGoods created by the user
     *
     * @return JSON response
     */
    public function showReliefAsstLists(Request $request)
    {
        if ($request->wantsJson())
        {
            return response()->json($request->user('web')->reliefGoods);
        }
    }


/*
|--------------------------------------------------------------------------
* POST Requests
|--------------------------------------------------------------------------
*/

    /**
     * Storing relief good created/sent by the user
     *
     * @return JSON response
     */
    public function store(StoreReliefGood $request)
    {
        $request->user()->giveReliefAssistanceTo(
            $this->reliefGoodController->store($request),
            $request->to
        );

        $reliefAsst = $request->user()->getLastCreatedReliefAsst();

        event(new NewReliefAssistanceEvent($reliefAsst));

        if ($request->wantsJson())
        {
            return response()->json([], 200);
        }
    }


/*
|--------------------------------------------------------------------------
* PUT Requests
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
* DELETE Requests
|--------------------------------------------------------------------------
*/
    /**
     * Removing the relief assistance created/sent by the User('Volunteer')
     *
     * @return JSON response
     */
    public function destroyReliefAsst(Request $request, $reliefGoodId)
    {
        $reliefAsstInfo = $request->user()->findReliefAsst($reliefGoodId);
        $recipient = User::find($reliefAsstInfo->pivot->recipient_id);
        $reliefGood = ReliefGood::find($reliefGoodId);

        $isReliefAsstRemoved = $request->user()->removeReliefAssistanceTo($reliefGoodId);

        if ($isReliefAsstRemoved)
        {
            $this->reliefGoodController->destroyReliefGood($reliefGoodId);

            event(new OnRemoveReliefAssistanceEvent(
                    $recipient,
                    $reliefGood
            ));
        }

        if ($request->wantsJson())
        {
            return response()->json([], 200);
        }
    }

}
