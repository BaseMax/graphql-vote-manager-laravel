<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations;

use App\Models\Poll;
use App\Models\PollOption;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Illuminate\Support\Facades\Auth;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\SelectFields;
use Rebing\GraphQL\Support\Facades\GraphQL;

class createPollMutation extends Mutation
{
    protected $attributes = [
        'name' => 'createPoll'
    ];

    public function type(): Type
    {
        return Type::nonNull(GraphQL::type('Poll'));
    }

    public function args(): array
    {
        return [
            'title' => Type::nonNull(Type::string()),
            'description' => Type::string(),
            'options' => Type::nonNull(Type::listOf(Type::nonNull(Type::string())))
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        $fields = $getSelectFields();
        $select = $fields->getSelect();
        $with = $fields->getRelations();

        $poll = Poll::create([
            'title' => $args['title'],
            'description' => array_key_exists('description', $args) ? $args['description'] : null,
            'user_id' => Auth::id()
        ]);
        foreach($args['options'] as $optionText){
            PollOption::create([
                'text' => $optionText,
                'poll_id' => $poll->id
            ]);
        }
        return $poll;
    }

    public function authorize($root, array $args, $ctx, ResolveInfo $resolveInfo = null, Closure $getSelectFields = null): bool
    {
        return !Auth::guest();
    }
}
