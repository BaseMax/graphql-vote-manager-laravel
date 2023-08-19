<?php

declare(strict_types=1);

namespace App\GraphQL\Types;

use App\Models\PollOption;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class PollOptionType extends GraphQLType
{
    protected $attributes = [
        'name' => 'PollOption',
        'model' => PollOption::class
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
            'poll' => [
                'type' => Type::nonNull(GraphQL::type('Poll'))
            ],
            'votes' => [
                'type' => Type::nonNull(Type::listOf(Type::nonNull(GraphQL::type('PollVote'))))
            ]
        ];
    }
}
