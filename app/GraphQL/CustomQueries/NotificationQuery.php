<?php

namespace App\GraphQL\CustomQueries;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\Builder;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Illuminate\Database\Eloquent\Collection;
use App\Model\LogNotification;


class NotificationQuery
{

    public function search($root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        
        $notificationQuery = LogNotification::query();

        $user = \Auth::user();
        if($user){
            $notificationQuery = $notificationQuery->where('user_id_to_notify',$user->id);
            $user->new_notif = false;
            $user->save();
        }

        if(isset($args['id']))
        {
            $notificationQuery = $notificationQuery->where('id', $args['id']);
        }   

         
        return $notificationQuery;
    }

}