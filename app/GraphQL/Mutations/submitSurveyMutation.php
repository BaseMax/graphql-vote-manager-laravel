<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations;

use App\Models\Survey;
use App\Models\SurveyAction;
use App\Models\SurveyResponse;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Illuminate\Support\Facades\Auth;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\SelectFields;

class submitSurveyMutation extends Mutation
{
    protected $attributes = [
        'name' => 'submitSurvey'
    ];

    public function type(): Type
    {
        return GraphQL::type('SurveyResponse');
    }

    public function args(): array
    {
        return [
            'surveyId' => [
                'type' => Type::nonNull(Type::id())
            ],
            'answers' => [
                'type' => Type::nonNull(Type::listOf(Type::nonNull(Type::string())))
            ]
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        $fields = $getSelectFields();
        $select = $fields->getSelect();
        $with = $fields->getRelations();

        if(Survey::where('id', $args['surveyId'])->count() == 0){
            return null;
        }
        if(SurveyAction::where('user_id', Auth::id())->where('survey_id', $args['surveyId'])->count() == 0){
            SurveyAction::create([
                'user_id' => Auth::id(),
                'survey_id' => $args['surveyId'],
                'answered' => true
            ]);
        } else {
            SurveyAction::where('user_id', Auth::id())->where('survey_id', $args['surveyId'])->update(['answered' => true]);
        }
        return SurveyResponse::create([
            'user_id' => Auth::id(),
            'survey_id' => $args['surveyId'],
            'answers' => $args['answers']
        ]);
    }

    public function authorize($root, array $args, $ctx, ResolveInfo $resolveInfo = null, Closure $getSelectFields = null): bool
    {
        return !Auth::guest();
    }
}
