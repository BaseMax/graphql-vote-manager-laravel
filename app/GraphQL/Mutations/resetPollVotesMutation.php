<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations;

use App\Models\Poll;
use App\Models\PollVote;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Illuminate\Support\Facades\Auth;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\SelectFields;

class resetPollVotesMutation extends Mutation
{
    protected $attributes = [
        'name' => 'resetPollVotes'
    ];

    public function type(): Type
    {
        return Type::boolean();
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
        $fields = $getSelectFields();
        $select = $fields->getSelect();
        $with = $fields->getRelations();

        $polls = Poll::where('id', $args['pollId'])->get();
        if(count($polls) > 0 && $polls[0]->user_id == Auth::id()){
            PollVote::where('poll_id', $args['pollId'])->delete();
            return true;
        }
        return false;
    }

    public function authorize($root, array $args, $ctx, ResolveInfo $resolveInfo = null, Closure $getSelectFields = null): bool
    {
        return !Auth::guest();
    }
}
