<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ActorResource;
use App\Actor;

class ActorController extends Controller
{
    public static function getActorsByCategory(Request $request)
    {
        if (!$request->input('category_id'))
            throw new HttpException(403, 'Missing category_id parameter.');

        return \App\Http\Resources\ActorResource::collection(\App\Actor::actorsByCategory(
            $request->input('category_id'),
            $request->input('per_page')
        ));

    }
}