<?php

namespace App\GraphQL\CustomQueries;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\Builder;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Illuminate\Database\Eloquent\Collection;
use App\Model\Invoice;


class InvoiceQuery
{

    public function search($root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $user = \Auth::user();
        $invoiceQuery = Invoice::query();
        $invoiceQuery = $invoiceQuery->where('user_id',$user->id);

        return $invoiceQuery;
        
    }

}