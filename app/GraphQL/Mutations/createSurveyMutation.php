<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations;

use App\Models\Survey;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Illuminate\Support\Facades\Auth;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\SelectFields;

class createSurveyMutation extends Mutation
{
    protected $attributes = [
        'name' => 'createSurvey'
    ];

    public function type(): Type
    {
        return Type::nonNull(GraphQL::type('Survey'));
    }

    public function args(): array
    {
        return [
            'title' => [
                'type' => Type::nonNull(Type::string())
            ],
            'questions' => [
                'type' => Type::nonNull(Type::listOf(Type::nonNull(Type::string())))
            ]
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        $fields = $getSelectFields();
        $select = $fields->getSelect();
        $with = $fields->getRelations();

        return Survey::create([
            'title' => $args['title'],
            'questions' => $args['questions'],
            'user_id' => Auth::id()
        ]);
    }

    public function authorize($root, array $args, $ctx, ResolveInfo $resolveInfo = null, Closure $getSelectFields = null): bool
    {
        return !Auth::guest();
    }
}
