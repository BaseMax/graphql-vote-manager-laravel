<?php

declare(strict_types=1);

namespace App\GraphQL\Types;

use App\Models\Poll;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class PollType extends GraphQLType
{
    protected $attributes = [
        'name' => 'Poll',
        'model' => Poll::class
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::id())
            ],
            'title' => [
                'type' => Type::nonNull(Type::string())
            ],
            'description' => [
                'type' => Type::string()
            ],
            'options' => [
                'type' => Type::nonNull(Type::listOf(Type::nonNull(GraphQL::type('PollOption'))))
            ],
            'user' => [
                'type' => Type::nonNull(GraphQL::type('User'))
            ],
            'comments' => [
                'type' => Type::nonNull(Type::listOf(Type::nonNull(GraphQL::type('Comment'))))
            ],
            'votes' => [
                'type' => Type::nonNull(Type::listOf(Type::nonNull(GraphQL::type('PollVote'))))
            ]
        ];
    }
}
