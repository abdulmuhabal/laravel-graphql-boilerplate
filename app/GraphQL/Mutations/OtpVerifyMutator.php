<?php

namespace App\GraphQL\Mutations;

use App\Exceptions\GraphqlException;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Illuminate\Support\Str;

use App\Model\AuthOtpCode;
use App\User;

class OtpVerifyMutator
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
        // if(isset($args['phone'])){
        //     $user = User::where('phone',$args['phone'])->first();
        // } 

        // if(isset($args['email'])){
        //     $user = User::where('email',$args['email'])->first();
        // } 
        $minute_interval = date('Y-m-d H:i:s',strtotime('now + 1 minute'));

        $auth_otp = AuthOtpCode::where('otp_code',$args['otp_code'])
        ->where('expired',false)
        ->where('created_at','>=', '(NOW(), INTERVAL 60 SECOND)')
        // ->where('otp_code',$args['otp_code'])
        ->first();
        
        // $user = User::where('otp_code',$args['otp_code'])->first();
        
        
        if(isset($auth_otp)){
            $user = User::find($auth_otp->user_id);
            if($user){
                $user->is_verified = 1;
                $user->save();

                $auth_otp->expired = true;
                $auth_otp->save();

                return array(
                    "status" => 1,
                    "message" => "Success",
                    "token" => $user->api_token,
                    "user" => $user,
                    // "created_at" => $auth_otp->created_at,
                    // "time_now" => $minute_interval
                );
                // if($args['otp_code'] == $user->otp_code){
                //     $user->otp_code = NULL;
                //     $user->is_verified = 1;
                //     $user->save();
                //     return array(
                //         "status" => 1,
                //         "message" => "Success",
                //         "token" => $user->api_token,
                //         "user" => $user,
                //     );
                // } else if($args['otp_code'] == "1212"){
                //     $user->otp_code = NULL;
                //     $user->is_verified = 1;
                //     $user->save();
                //     return array(
                //         "status" => 1,
                //         "message" => "Success",
                //         "token" => $user->api_token,
                //         "user" => $user,
                //     );
                // }
            }  
        }


        return array(
            "status" => 0,
            "message" =>  __('lang.otp_not_found'),
            "token" => "",
            "user" => "",
            // "created_at" => $auth_otp->created_at,
            // "time_now" => $minute_interval
        );
    }
}
