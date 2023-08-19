<?php

declare(strict_types=1);

namespace App\GraphQL\Queries;

use App\Models\Poll;
use App\Models\PollVote;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Illuminate\Support\Facades\Auth;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\SelectFields;

class getPollVotesQuery extends Query
{
    protected $attributes = [
        'name' => 'getPollVotes'
    ];

    public function type(): Type
    {
        return Type::int();
    }

    public function args(): array
    {
        return [
            'pollId' => [
                'type' => Type::nonNull(Type::id())
            ]
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        /** @var SelectFields $fields */
        $fields = $getSelectFields();
        $select = $fields->getSelect();
        $with = $fields->getRelations();

        $polls = Poll::where('id', $args['pollId'])->get();
        if(count($polls) > 0){
            return PollVote::where('poll_id', $polls[0]->id)->count();
        }
        return null;
    }

    public function authorize($root, array $args, $ctx, ResolveInfo $resolveInfo = null, Closure $getSelectFields = null): bool
    {
        return !Auth::guest();
    }
}
