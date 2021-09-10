<?php

namespace App\GraphQL\Mutations;

use App\Exceptions\GraphqlException;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

use App\User;
use App\Model\UserSubscription;

class CheckSubscriptionMutator
{
    /**
     * Return a value for the field.
     *
     * @param  null  $rootValue Usually contains the result returned from the parent field. In this case, it is always `null`.
     * @param  mixed[]  $args The arguments that were passed into the field.
     * @param  \Nuwave\Lighthouse\Support\Contracts\GraphQLContext  $context Arbitrary data that is shared between all fields of a single query.
     * @param  \GraphQL\Type\Definition\ResolveInfo  $resolveInfo Information about the query itself, such as the execution state, the field name, path to the field from the root, and more.
     * @return mixed
     */
    public function __invoke($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {

        $user = \Auth::user();
        $usersubscription = UserSubscription::where('user_id', $user->id)->get()->last();

        if($usersubscription){
            if(!$usersubscription->isExpired()){
                return array(
                    "subscribed" => 1,
                    "expiry_date" => $usersubscription->expiry_date,
                );
            }
            return array(
                "subscribed" => 0,
                "expiry_date" => $usersubscription->expiry_date,
            );
        }

        return array(
            "subscribed" => 0,
            "expiry_date" => null,
        );
    }
}
