<?php

declare(strict_types=1);

namespace App\GraphQL\Queries;

use App\Models\Survey;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Illuminate\Support\Facades\Auth;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\SelectFields;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Illuminate\Support\Facades\Cache;

class getAllSurveysQuery extends Query
{
    protected $attributes = [
        'name' => 'getAllSurveys'
    ];

    public function type(): Type
    {
        return GraphQL::paginate('Survey');
    }

    public function args(): array
    {
        return [

        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        /** @var SelectFields $fields */
        $fields = $getSelectFields();
        $select = $fields->getSelect();
        $with = $fields->getRelations();
        
        return Cache::remember('surveys', now()->addMinutes(5), function(){
            return Survey::paginate(20);
        });
    }

    public function authorize($root, array $args, $ctx, ResolveInfo $resolveInfo = null, Closure $getSelectFields = null): bool
    {
        return !Auth::guest();
    }
}
