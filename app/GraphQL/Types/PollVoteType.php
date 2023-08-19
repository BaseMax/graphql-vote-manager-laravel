<?php

declare(strict_types=1);

namespace App\GraphQL\Types;

use App\Models\PollVote;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class PollVoteType extends GraphQLType
{
    protected $attributes = [
        'name' => 'PollVote',
        'model' => PollVote::class
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::id())
            ],
            'user' => [
                'type' => Type::nonNull(GraphQL::type('User'))
            ],
            'poll' => [
                'type' => Type::nonNull(GraphQL::type('Poll'))
            ],
            'pollOption' => [
                'type' => Type::nonNull(GraphQL::type('PollOption'))
            ]
        ];
    }
}
