<?php

namespace App\GraphQL\Mutations;

use App\Exceptions\GraphqlException;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

use App\User;

class LoginServiceProviderMutator
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
        $credentials = array();
        if(is_numeric($args['username']))
            $credentials['phone'] = $args['username'];
            else
                $credentials['email'] = $args['username'];

        $credentials['password'] = $args['password'];

        if(Auth::attempt($credentials)){
            $token = Str::random(60).uniqid();
            $user = Auth::user();
            if(!$user->isServiceProvider()){
                throw new GraphqlException(
                    __('lang.invalid_credentials'),
                __('lang.check_credentials_text')
                );
            }
            $user->api_token = $token;
            $otp_code = mt_rand(1000, 9999);
            $user->otp_code = $otp_code;
            $user->save();

            return [
                'user' => $user,
                'token' => $token
            ];
        }else{
            throw new GraphqlException(
                __('lang.invalid_credentials'),
                __('lang.check_credentials_text')
            );
        }

    }
}
