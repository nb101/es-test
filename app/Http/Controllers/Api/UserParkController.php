<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserAssociateRequest;
use App\Models\Breed;
use App\Models\Park;
use App\Models\User;
use Illuminate\Http\Request;

class UserParkController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(UserAssociateRequest $request, $user_id)
    {
        $user = User::find($user_id);

        if ($request->input('type') == 'park') {
            $park = Park::find($request->input('park_id'));
            if($user && $park) {
                $user->parks()->save($park);
                return response('park assigned to user', 200);
            }
        } elseif ($request->input('type') == 'breed') {
            $user = User::find($user_id);
            $breed = Breed::where('name', $request->input('breed_id'))->first();
            if($user && $breed) {
                $user->breeds()->save($breed);
                return response('user assigned to breed', 200);
            }
        }

    }
}
