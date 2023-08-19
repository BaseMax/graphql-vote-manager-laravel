<?php

declare(strict_types=1);

namespace App\GraphQL\Types;

use App\Models\Comment;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class CommentType extends GraphQLType
{
    protected $attributes = [
        'name' => 'Comment',
        'model' => Comment::class
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::id())
            ],
            'text' => [
                'type' => Type::nonNull(Type::string())
            ],
            'user' => [
                'type' => Type::nonNull(GraphQL::type('User'))
            ],
            'poll' => [
                'type' => Type::nonNull(GraphQL::type('Poll'))
            ]
        ];
    }
}
