<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations;

use App\Models\Survey;
use App\Models\SurveyResponse;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Illuminate\Support\Facades\Auth;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\SelectFields;
use Rebing\GraphQL\Support\Facades\GraphQL;

class updateSurveyMutation extends Mutation
{
    protected $attributes = [
        'name' => 'updateSurvey'
    ];

    public function type(): Type
    {
        return GraphQL::type('Survey');
    }

    public function args(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::id())
            ],
            'titel' => [
                'type' => Type::string()
            ],
            'questions' => [
                'type' => Type::listOf(Type::string())
            ]
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        $fields = $getSelectFields();
        $select = $fields->getSelect();
        $with = $fields->getRelations();

        $surveys = Survey::where('id', $args['id'])->get();
        if(count($surveys) > 0 && $surveys[0]->user_id == Auth::id()){
            $survey = $surveys[0];
            if(array_key_exists('title', $args)) $survey->title = $args['title'];
            if(array_key_exists('questions', $args)){
                $survey->questions = $args['questions'];
                SurveyResponse::where('survey_id', $args['id'])->delete();
            }
            $survey->save();
            return $survey;
        }
        return null;
    }

    public function authorize($root, array $args, $ctx, ResolveInfo $resolveInfo = null, Closure $getSelectFields = null): bool
    {
        return !Auth::guest();
    }
}
