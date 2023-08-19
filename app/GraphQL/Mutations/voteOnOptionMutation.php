<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations;

use App\Models\Poll;
use App\Models\PollOption;
use App\Models\PollVote;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Illuminate\Support\Facades\Auth;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\SelectFields;
use Rebing\GraphQL\Support\Facades\GraphQL;

class voteOnOptionMutation extends Mutation
{
    protected $attributes = [
        'name' => 'voteOnOption'
    ];

    public function type(): Type
    {
        return GraphQL::type('PollVote');
    }

    public function args(): array
    {
        return [
            'pollId' => [
                'type' => Type::nonNull(Type::id())
            ],
            'optionId' => [
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
        $options = PollOption::where('id', $args['optionId'])->get();
        if(count($polls) > 0 || count($options) > 0){
            $poll = $polls[0];
            $option = $options[0];
            $exVotes = PollVote::where('user_id', Auth::id())->where('poll_id', $poll->id)->where('poll_option_id', $option->id)->get();
            if(count($exVotes) > 0){
                return $exVotes[0];
            }
            return PollVote::create([
                'user_id' => Auth::id(),
                'poll_id' => $poll->id,
                'poll_option_id' => $option->id
            ]);
        }
        return null;
    }

    public function authorize($root, array $args, $ctx, ResolveInfo $resolveInfo = null, Closure $getSelectFields = null): bool
    {
        return !Auth::guest();
    }
}
