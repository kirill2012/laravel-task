<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Actor extends Model
{
    protected $table = 'actor';
    protected $primaryKey = 'actor_id';

    public static function actorsByCategory($category_id, $per_page = 20) {

        $actors = DB::table('actor')
            ->join('film_actor', 'actor.actor_id', '=', 'film_actor.actor_id')
            ->select('actor.first_name', 'actor.last_name', DB::raw('COUNT(film_actor.film_id) as cat_film_app'))
            ->join(DB::raw("(
                    SELECT film_id
                    FROM film_category
                    WHERE category_id = $category_id) as films"),function($join){
                $join->on('film_actor.film_id', '=', 'films.film_id');
            })
            ->groupBy('actor.actor_id')
            ->orderBy('cat_film_app', 'desc')
            ->paginate($per_page);

        return $actors;

    }
}
