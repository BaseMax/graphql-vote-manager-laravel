<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations;

use App\Models\Comment;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Illuminate\Support\Facades\Auth;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\SelectFields;

class deleteCommentMutation extends Mutation
{
    protected $attributes = [
        'name' => 'deleteComment'
    ];

    public function type(): Type
    {
        return Type::boolean();
    }

    public function args(): array
    {
        return [
            'commentId' => [
                'type' => Type::nonNull(Type::id())
            ]
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        $fields = $getSelectFields();
        $select = $fields->getSelect();
        $with = $fields->getRelations();

        $comments = Comment::where('id', $args['commentId'])->get();
        if(count($comments) > 0 && $comments[0]->user_id == Auth::id()){
            $comments[0]->delete();
            return true;
        }
        return false;
    }

    public function authorize($root, array $args, $ctx, ResolveInfo $resolveInfo = null, Closure $getSelectFields = null): bool
    {
        return !Auth::guest();
    }
}
