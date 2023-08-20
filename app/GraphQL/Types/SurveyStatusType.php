<?php

declare(strict_types=1);

namespace App\GraphQL\Types;

use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL\Type\Definition\Type;

class SurveyStatusType extends GraphQLType
{
    protected $attributes = [
        'name' => 'SurveyStatus'
    ];

    public function fields(): array
    {
        return [
            'seens' => [
                'type' => Type::nonNull(Type::int())
            ],
            'notSeens' => [
                'type' => Type::nonNull(Type::int())
            ],
            'answereds' => [
                'type' => Type::nonNull(Type::int())
            ],
            'didNotAnswereds' => [
                'type' => Type::nonNull(Type::int())
            ]
        ];
    }
}
