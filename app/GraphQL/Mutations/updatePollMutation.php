<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations;

use App\Models\Poll;
use App\Models\PollOption;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Illuminate\Support\Facades\Auth;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\SelectFields;
use Rebing\GraphQL\Support\Facades\GraphQL;

class updatePollMutation extends Mutation
{
    protected $attributes = [
        'name' => 'updatePoll'
    ];

    public function type(): Type
    {
        return GraphQL::type('Poll');
    }

    public function args(): array
    {
        return [
            'id' => Type::nonNull(Type::id()),
            'title' => Type::string(),
            'description' => Type::string(),
            'options' => Type::listOf(Type::nonNull(Type::string()))
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        $fields = $getSelectFields();
        $select = $fields->getSelect();
        $with = $fields->getRelations();

        $polls = Poll::where('id', $args['id'])->get();
        if(count($polls) > 0){
            $poll = $polls[0];
            if($poll->user_id != Auth::id()){
                return null;
            }
            if(array_key_exists('title', $args)) $poll->title = $args['title'];
            if(array_key_exists('description', $args)) $poll->title = $args['description'];
            $poll->save();
            if(array_key_exists('options', $args) && $args['options'] != null){
                PollOption::where('poll_id', $poll->id)->delete();
                foreach($args['options'] as $optionText){
                    PollOption::create([
                        'text' => $optionText,
                        'poll_id' => $poll->id
                    ]);
                }
            }
            return $poll;
        }
        return null;
    }

    public function authorize($root, array $args, $ctx, ResolveInfo $resolveInfo = null, Closure $getSelectFields = null): bool
    {
        return !Auth::guest();
    }
}
