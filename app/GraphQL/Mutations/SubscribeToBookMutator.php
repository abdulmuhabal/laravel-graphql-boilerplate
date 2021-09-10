<?php

namespace App\GraphQL\Mutations;

use App\Exceptions\GraphqlException;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Illuminate\Support\Str;
use App\Helpers\SMSapp;
use App\User;
use App\Model\ClientSubscription;
use App\Model\Duration;

class SubscribeToBookMutator
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
        $token = Str::random(60).uniqid();

        // $user = new User();
        
        // $args['password'] = bcrypt($args['password']);
        // $user = $user->create($args);
        // $user->api_token = $token;
        // $otp_code = mt_rand(1000, 9999);
        // $user->otp_code = $otp_code;
        // $user->save();

        // $input_arr = array(
        //     "phone" => $user->phone,
        //     "otp_code" => $otp_code
        // );

        // $args['user_id'] = $user->id;
        $duration = Duration::find($args['duration_id']);
        $subcription = ClientSubscription::create($args);
        
        return $subcription;
    }
}
