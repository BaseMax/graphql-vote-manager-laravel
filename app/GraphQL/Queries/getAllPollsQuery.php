<?php

declare(strict_types=1);

namespace App\GraphQL\Queries;

use App\Models\Poll;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Illuminate\Support\Facades\Auth;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\SelectFields;
use Illuminate\Support\Facades\Cache;

class getAllPollsQuery extends Query
{
    protected $attributes = [
        'name' => 'getAllPolls'
    ];

    public function type(): Type
    {
        return GraphQL::paginate('Poll');
    }

    public function args(): array
    {
        return [

        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        /** @var SelectFields $fields */
        $fields = $getSelectFields();
        $select = $fields->getSelect();
        $with = $fields->getRelations();

        return Cache::remember('polls', now()->addMinutes(5), function(){
            return Poll::paginate(20);
        });
    }

    public function authorize($root, array $args, $ctx, ResolveInfo $resolveInfo = null, Closure $getSelectFields = null): bool
    {
        return !Auth::guest();
    }
}
