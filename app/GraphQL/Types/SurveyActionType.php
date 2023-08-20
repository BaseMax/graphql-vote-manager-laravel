<?php

declare(strict_types=1);

namespace App\GraphQL\Types;

use App\Models\SurveyAction;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class SurveyActionType extends GraphQLType
{
    protected $attributes = [
        'name' => 'SurveyAction',
        'model' => SurveyAction::class
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
            'answered' => [
                'type' => Type::nonNull(Type::boolean())
            ]
        ];
    }
}
