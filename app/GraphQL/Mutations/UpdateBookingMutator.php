<?php

namespace App\GraphQL\Mutations;

use App\Exceptions\GraphqlException;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Illuminate\Support\Str;

use App\Model\Booking;
use App\Model\Timing;

class UpdateBookingMutator
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
        $id = $args['id'];
        $booking = Booking::find($id);

        if($booking->attended){
            throw new GraphqlException(
                __('lang.already_attended'),
                __('lang.already_attended')
            );
        }
        
        if(!isset($args['status']) || $args['status'] != 'CANCELLED')
            $args['is_updated'] = true;
        
        $booking = $booking->update($args);
        $booking = Booking::find($id);

        return $booking;
    }
}
