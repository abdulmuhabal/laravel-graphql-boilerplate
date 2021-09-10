<?php

namespace App\GraphQL\Mutations;

use App\Exceptions\GraphqlException;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

use App\User;
use App\Model\UserSubscription;
use App\Model\SubscriptionPlan;
use App\Model\InvoicePayment;
use App\Model\Invoice;

class SetSubscriptionMutator
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
        $subscriptionPlan = SubscriptionPlan::find($args['subscription_plan_id']);
        $price = $subscriptionPlan->price;
        $invoiceData = array(
            'user_id' => $user->id,
            'price' => $price,
            'vat' => 0,
            'total_price' => $price,
            'paid' => 'PAID',
        );
        $invoice = Invoice::create($invoiceData);

        $invoicePaymentData = array(
            'user_id' => $user->id,
            'subscription_plan_id' => $subscriptionPlan->id,
            'invoice_id' => $invoice->id,
        );
        $invoicePayment = InvoicePayment::create($invoicePaymentData);

        $userSubscriptionData = array(
            'user_id' => $user->id,
            'invoice_id' => $invoice->id,
            'expiry_date' => date('Y-m-d',strtotime('+1 month'))
        );
        $userSubscription = UserSubscription::create($userSubscriptionData);

        if($userSubscription){
            if(!$userSubscription->isExpired()){
                return array(
                    "subscribed" => 1,
                    "expiry_date" => $userSubscription->expiry_date,
                );
            }
            return array(
                "subscribed" => 0,
                "expiry_date" => $userSubscription->expiry_date,
            );
        }

    }
}
