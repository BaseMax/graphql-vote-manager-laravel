<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations;

use Closure;
use App\Models\User;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Illuminate\Support\Facades\Hash;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\SelectFields;
use Rebing\GraphQL\Support\Facades\GraphQL;

class loginUserMutation extends Mutation
{
    protected $attributes = [
        'name' => 'loginUser'
    ];

    public function type(): Type
    {
        return Type::string();
    }

    public function args(): array
    {
        return [
            'email' => [
                'type' => Type::nonNull(Type::string())
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

        $user = User::where('email', $args['email'])->get();
        if(count($user) > 0 && Hash::check($args['password'], $user[0]->password)){
            return $user[0]->createToken('auth_token')->plainTextToken;
        }
        return null;
    }
}
