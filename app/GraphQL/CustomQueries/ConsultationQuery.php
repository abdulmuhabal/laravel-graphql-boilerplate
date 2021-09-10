<?php

namespace App\GraphQL\CustomQueries;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\Builder;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Illuminate\Database\Eloquent\Collection;
use App\Model\Consultation;


class ConsultationQuery
{

    public function activeQuery($root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $user = \Auth::user();
        $consultationQuery = Consultation::query();
        $consultationQuery = $consultationQuery->where('user_id',$user->id);
        $consultationQuery = $consultationQuery->whereIn('status',['PENDING','IN_PROGRESS']);

        return $consultationQuery;
    }

    public function historyQuery($root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $user = \Auth::user();
        $consultationQuery = Consultation::query();
        $consultationQuery = $consultationQuery->where('user_id',$user->id);
        $consultationQuery = $consultationQuery->whereIn('status',['REJECTED','ANSWERED']);

        return $consultationQuery;
    }

}