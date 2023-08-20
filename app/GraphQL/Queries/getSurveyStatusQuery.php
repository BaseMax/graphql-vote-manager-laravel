<?php

declare(strict_types=1);

namespace App\GraphQL\Queries;

use App\Models\Survey;
use App\Models\SurveyAction;
use App\Models\User;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\SelectFields;

class getSurveyStatusQuery extends Query
{
    protected $attributes = [
        'name' => 'getSurveyStatus'
    ];

    public function type(): Type
    {
        return GraphQL::type('SurveyStatus');
    }

    public function args(): array
    {
        return [
            'surveyId' => [
                'type' => Type::nonNull(Type::id())
            ]
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        /** @var SelectFields $fields */
        $fields = $getSelectFields();
        $select = $fields->getSelect();
        $with = $fields->getRelations();

        if(Survey::where('id', $args['surveyId'])->count() != 0){
            $seens = SurveyAction::where('survey_id', $args['surveyId'])->count();
            $notSeens = User::count() - $seens;
            $answereds = SurveyAction::where('survey_id', $args['surveyId'])->where('answered', true)->count();
            $didNotAnswereds = $seens - $answereds;

            return (object) [
                'seens' => $seens,
                'notSeens' => $notSeens,
                'answereds' => $answereds,
                'didNotAnswereds' => $didNotAnswereds
            ];
        }
        return null;
    }
}
