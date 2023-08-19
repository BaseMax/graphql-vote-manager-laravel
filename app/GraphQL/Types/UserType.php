<?php

declare(strict_types=1);

namespace App\GraphQL\Types;

use App\Models\User;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class UserType extends GraphQLType
{
    protected $attributes = [
        'name' => 'User',
        'model' => User::class
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::id())
            ],
            'username' => [
                'type' => Type::nonNull(Type::string())
            ],
            'email' => [
                'type' => Type::nonNull(Type::string())
            ],
            'polls' => [
                'type' => Type::nonNull(Type::listOf(Type::nonNull(GraphQL::type('Poll'))))
            ],
            'surveys' => [
                'type' => Type::nonNull(Type::listOf(Type::nonNull(GraphQL::type('Survey'))))
            ]
        ];
    }
}
