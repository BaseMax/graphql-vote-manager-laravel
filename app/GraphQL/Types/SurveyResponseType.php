<?php

declare(strict_types=1);

namespace App\GraphQL\Types;

use App\Models\SurveyResponse;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class SurveyResponseType extends GraphQLType
{
    protected $attributes = [
        'name' => 'SurveyResponse',
        'model' => SurveyResponse::class
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
            'survey' => [
                'type' => Type::nonNull(GraphQL::type('Survey'))
            ],
            'answers' => [
                'type' => Type::nonNull(Type::listOf(Type::nonNull(Type::string())))
            ]
        ];
    }
}
