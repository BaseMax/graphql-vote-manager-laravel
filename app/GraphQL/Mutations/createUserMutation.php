<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations;

use App\Models\User;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\SelectFields;
use Rebing\GraphQL\Support\Facades\GraphQL;

class createUserMutation extends Mutation
{
    protected $attributes = [
        'name' => 'createUser'
    ];

    public function type(): Type
    {
        return Type::nonNull(GraphQL::type('User'));
    }

    public function args(): array
    {
        return [
            'username' => [
                'type' => Type::nonNull(Type::string()),
                'rule' => ['unique:users']
            ],
            'email' => [
                'type' => Type::nonNull(Type::string()),
                'rule' => ['unique:users']
            ],
            'password' => [
                'type' => Type::nonNull(Type::string())
            ]
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        $fields = $getSelectFields();
        $select = $fields->getSelect();
        $with = $fields->getRelations();

        return User::create([
            'username' => $args['username'],
            'email' => $args['email'],
            'password' => Hash::make($args['password']),
        ]);
    }
}
