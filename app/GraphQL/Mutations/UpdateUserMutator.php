<?php

namespace App\GraphQL\Mutations;

use App\Exceptions\GraphqlException;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Illuminate\Support\Str;

use App\Model\Booking;
use App\User;
use App\Model\UserProfile;

class UpdateUserMutator
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
        
        // TODO implement the resolver
        // \Log::debug(print_r($args, true));
        unset($args['directive']); 
        // \Log::debug(print_r($arg\    s, true));

        $auth_user = \Auth::user();
        $user = User::find($auth_user->id);
        $userProfile = UserProfile::where('user_id',$user->id);
        $user->update($args);
        $userProfile->update($args);

        return [
            'user' => $user,
            'token' => $user->token
        ];
    }
}
