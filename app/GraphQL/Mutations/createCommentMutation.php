<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations;

use App\Models\Comment;
use App\Models\Poll;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Illuminate\Support\Facades\Auth;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\SelectFields;
use Rebing\GraphQL\Support\Facades\GraphQL;

class createCommentMutation extends Mutation
{
    protected $attributes = [
        'name' => 'createComment'
    ];

    public function type(): Type
    {
        return GraphQL::type('Comment');
    }

    public function args(): array
    {
        return [
            'pollId' => [
                'type' => Type::nonNull(Type::id())
            ],
            'text' => [
                'type' => Type::nonNull(Type::string())
            ]
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        $fields = $getSelectFields();
        $select = $fields->getSelect();
        $with = $fields->getRelations();

        if(Poll::where('id', $args['pollId'])->count() == 0){
            return null;
        }
        return Comment::create([
            'text' => $args['text'],
            'user_id' => Auth::id(),
            'poll_id' => $args['pollId']
        ]);
    }

    public function authorize($root, array $args, $ctx, ResolveInfo $resolveInfo = null, Closure $getSelectFields = null): bool
    {
        return !Auth::guest();
    }
}
