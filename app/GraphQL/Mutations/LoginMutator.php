<?php

namespace App\GraphQL\Mutations;

use App\Exceptions\GraphqlException;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

use App\User;
use App\Model\AuthOtpCode;

class LoginMutator
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
        $credentials['email'] = $args['username'];
        $credentials['password'] = $args['password'];
        $credentials['role'] = 'CLIENT';

        if(Auth::attempt($credentials)){
            $token = Str::random(60).uniqid();
            $user = Auth::user();
            $user->api_token = $token;
            $user->save();

            if(!$user->is_verified){
                $otp_code = mt_rand(1000, 9999);
                $otp_arr = array(
                    'otp_code' => $otp_code,
                    'user_id'=> $user->id,
                );
                $auth_otp = AuthOtpCode::create($otp_arr);
            }

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
