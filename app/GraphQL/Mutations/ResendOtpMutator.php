<?php

namespace App\GraphQL\Mutations;

use App\Exceptions\GraphqlException;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Illuminate\Support\Str;
use App\Helpers\SMSapp;
use App\User;
use App\Model\AuthOtpCode;

class ResendOtpMutator
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
        if(isset($args['phone'])){
            $user = User::where('phone',$args['phone'])->first();
        } 

        if(isset($args['email'])){
            $user = User::where('email',$args['email'])->first();
        }

        if($user){
            $otp_code = mt_rand(1000, 9999);
            $otp_arr = array(
                'otp_code' => $otp_code,
                'user_id'=> $user->id,
            );
            $auth_otp = AuthOtpCode::create($otp_arr);
            
            return array(
                "status" => 1,
                "message" => "Success",
                
            );
        }
        
        // $user = User::where('phone', $args['phone'])->where('role','CLIENT')->first();
        // if(isset($user)){
        //     $otp_code = mt_rand(1000, 9999);
        //     $user->otp_code = $otp_code;
        //     $user->save();
        //     $input_arr = array(
        //         "phone" => $user->phone,
        //         "otp_code" => $otp_code
        //     );
        //     // SMSapp::sendSMS($input_arr);
        //     return array(
        //         "status" => 1,
        //         "message" => "Success",
        //     );
        // }

        return array(
            "status" => 0,
            "message" => __('lang.user_not_registered'),
        );
    }
}