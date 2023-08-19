<?php

declare(strict_types=1);

namespace App\GraphQL\Types;

use App\Models\Survey;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class SurveyType extends GraphQLType
{
    protected $attributes = [
        'name' => 'Survey',
        'model' => Survey::class
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
            'questions' => [
                'type' => Type::nonNull(Type::listOf(Type::nonNull(Type::string())))
            ],
            'user' => [
                'type' => Type::nonNull(GraphQL::type('User'))
            ],
            'responses' => [
                'type' => Type::nonNull(Type::listOf(Type::nonNull(GraphQL::type('SurveyResponse'))))
            ]
        ];
    }
}
