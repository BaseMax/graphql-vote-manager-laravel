<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class AppTest extends TestCase
{
    private $authToken;
    private $isAuthTokenSet = false;

    private function setAuthToken(){
        if($this->isAuthTokenSet) return;

        $username = uniqid('test');
        $email = uniqid('test').'@test.com';
        $password = "12345678";
        
        $query = "mutation CreateUser { createUser(username: \"$username\", email: \"$email\", password: \"$password\") { id } }";   
        $response = $this->postJson('/graphql', ['query' => $query]);
        $response->assertStatus(200);

        $query = "mutation LoginUser { loginUser(email: \"$email\", password: \"$password\") }";   
        $response = $this->postJson('/graphql', ['query' => $query]);
        $response->assertStatus(200);
        $res_array = json_decode($response->content());
        $this->authToken = "Bearer ".$res_array->data->loginUser;
        $this->isAuthTokenSet = true;
    }

    public function test_unauthorized_getUser_query(){
        $query = "query GetUser { getUser(id: 1) { id } }";   
        $response = $this->postJson('/graphql', ['query' => $query]);
        $response->assertStatus(200);
        $res_array = (array)json_decode($response->content());
        $this->assertArrayHasKey('errors', $res_array);
    }

    public function test_getUser_query(){
        $this->setAuthToken();
        $query = "query GetUser { getUser(id: 1) { id } }";   
        $response = $this->postJson('/graphql', ['query' => $query], ['Authorization' => $this->authToken]);
        $response->assertStatus(200);
        $response->assertJson(fn (AssertableJson $json) =>
            $json->hasAll(['data'])
        );
    }

    public function test_unauthorized_getPoll_query(){
        $query = "query GetPoll { getPoll(id: 1) { id } }";   
        $response = $this->postJson('/graphql', ['query' => $query]);
        $response->assertStatus(200);
        $res_array = (array)json_decode($response->content());
        $this->assertArrayHasKey('errors', $res_array);
    }

    public function test_getPoll_query(){
        $this->setAuthToken();
        $query = "query GetPoll { getPoll(id: 1) { id } }";   
        $response = $this->postJson('/graphql', ['query' => $query], ['Authorization' => $this->authToken]);
        $response->assertStatus(200);
        $response->assertJson(fn (AssertableJson $json) =>
            $json->hasAll(['data'])
        );
    }

    public function test_unauthorized_getAllPolls_query(){
        $query = "query GetAllPolls { getAllPolls { data{ id } } }";   
        $response = $this->postJson('/graphql', ['query' => $query]);
        $response->assertStatus(200);
        $res_array = (array)json_decode($response->content());
        $this->assertArrayHasKey('errors', $res_array);
    }

    public function test_getAllPolls_query(){
        $this->setAuthToken();
        $query = "query GetAllPolls { getAllPolls { data{ id } } }";   
        $response = $this->postJson('/graphql', ['query' => $query], ['Authorization' => $this->authToken]);
        $response->assertStatus(200);
        $response->assertJson(fn (AssertableJson $json) =>
            $json->hasAll(['data'])
        );
    }

    public function test_unauthorized_getUserPolls_query(){
        $query = "query GetUserPolls { getUserPolls { id } }";   
        $response = $this->postJson('/graphql', ['query' => $query]);
        $response->assertStatus(200);
        $res_array = (array)json_decode($response->content());
        $this->assertArrayHasKey('errors', $res_array);
    }

    public function test_getUserPolls_query(){
        $this->setAuthToken();
        $query = "query GetUserPolls { getUserPolls { id } }";   
        $response = $this->postJson('/graphql', ['query' => $query], ['Authorization' => $this->authToken]);
        $response->assertStatus(200);
        $response->assertJson(fn (AssertableJson $json) =>
            $json->hasAll(['data'])
        );
    }

    public function test_unauthorized_getPollComments_query(){
        $query = "query GetPollComments { getPollComments(pollId: 1) { id } }";   
        $response = $this->postJson('/graphql', ['query' => $query]);
        $response->assertStatus(200);
        $res_array = (array)json_decode($response->content());
        $this->assertArrayHasKey('errors', $res_array);
    }

    public function test_getPollComments_query(){
        $this->setAuthToken();
        $query = "query GetPollComments { getPollComments(pollId: 1) { id } }";   
        $response = $this->postJson('/graphql', ['query' => $query], ['Authorization' => $this->authToken]);
        $response->assertStatus(200);
        $response->assertJson(fn (AssertableJson $json) =>
            $json->hasAll(['data'])
        );
    }

    public function test_unauthorized_getSurvey_query(){
        $query = "query GetSurvey { getSurvey(id: 1) { id } }";   
        $response = $this->postJson('/graphql', ['query' => $query]);
        $response->assertStatus(200);
        $res_array = (array)json_decode($response->content());
        $this->assertArrayHasKey('errors', $res_array);
    }

    public function test_getSurvey_query(){
        $this->setAuthToken();
        $query = "query GetSurvey { getSurvey(id: 1) { id } }";   
        $response = $this->postJson('/graphql', ['query' => $query], ['Authorization' => $this->authToken]);
        $response->assertStatus(200);
        $response->assertJson(fn (AssertableJson $json) =>
            $json->hasAll(['data'])
        );
    }

    public function test_unauthorized_getAllSurveys_query(){
        $query = "query GetAllSurveys { getAllSurveys { data{ id } } }";   
        $response = $this->postJson('/graphql', ['query' => $query]);
        $response->assertStatus(200);
        $res_array = (array)json_decode($response->content());
        $this->assertArrayHasKey('errors', $res_array);
    }

    public function test_getAllSurveys_query(){
        $this->setAuthToken();
        $query = "query GetAllSurveys { getAllSurveys { data{ id } } }";   
        $response = $this->postJson('/graphql', ['query' => $query], ['Authorization' => $this->authToken]);
        $response->assertStatus(200);
        $response->assertJson(fn (AssertableJson $json) =>
            $json->hasAll(['data'])
        );
    }

    public function test_unauthorized_getSurveyResponses_query(){
        $query = "query GetSurveyResponses { getSurveyResponses(surveyId: 1) { id } }";   
        $response = $this->postJson('/graphql', ['query' => $query]);
        $response->assertStatus(200);
        $res_array = (array)json_decode($response->content());
        $this->assertArrayHasKey('errors', $res_array);
    }

    public function test_getSurveyResponses_query(){
        $this->setAuthToken();
        $query = "query GetSurveyResponses { getSurveyResponses(surveyId: 1) { id } }";   
        $response = $this->postJson('/graphql', ['query' => $query], ['Authorization' => $this->authToken]);
        $response->assertStatus(200);
        $response->assertJson(fn (AssertableJson $json) =>
            $json->hasAll(['data'])
        );
    }

    public function test_unauthorized_getLoggedinUser_query(){
        $query = "query GetLoggedInUser { getLoggedInUser { id } }";   
        $response = $this->postJson('/graphql', ['query' => $query]);
        $response->assertStatus(200);
        $res_array = (array)json_decode($response->content());
        $this->assertArrayHasKey('errors', $res_array);
    }

    public function test_getLoggedinUser_query(){
        $this->setAuthToken();
        $query = "query GetLoggedInUser { getLoggedInUser { id } }";   
        $response = $this->postJson('/graphql', ['query' => $query], ['Authorization' => $this->authToken]);
        $response->assertStatus(200);
        $response->assertJson(fn (AssertableJson $json) =>
            $json->hasAll(['data'])
        );
    }

    public function test_unauthorized_getPollVotes_query(){
        $query = "query GetPollVotes { getPollVotes(pollId: 1) }";   
        $response = $this->postJson('/graphql', ['query' => $query]);
        $response->assertStatus(200);
        $res_array = (array)json_decode($response->content());
        $this->assertArrayHasKey('errors', $res_array);
    }

    public function test_getPollVotes_query(){
        $this->setAuthToken();
        $query = "query GetPollVotes { getPollVotes(pollId: 1) }";   
        $response = $this->postJson('/graphql', ['query' => $query], ['Authorization' => $this->authToken]);
        $response->assertStatus(200);
        $response->assertJson(fn (AssertableJson $json) =>
            $json->hasAll(['data'])
        );
    }

    public function test_unauthorized_getSurveyStatus_query(){
        $query = "query GetSurveyStatus { getSurveyStatus(surveyId: 1) { seens } }";   
        $response = $this->postJson('/graphql', ['query' => $query]);
        $response->assertStatus(200);
        $res_array = (array)json_decode($response->content());
        $this->assertArrayHasKey('errors', $res_array);
    }

    public function test_getSurveyStatus_query(){
        $this->setAuthToken();
        $query = "query GetSurveyStatus { getSurveyStatus(surveyId: 1) { seens } }";   
        $response = $this->postJson('/graphql', ['query' => $query], ['Authorization' => $this->authToken]);
        $response->assertStatus(200);
        $response->assertJson(fn (AssertableJson $json) =>
            $json->hasAll(['data'])
        );
    }

    public function test_unauthorized_createPoll_mutation(){
        $query = "mutation CreatePoll { createPoll(title: \"test\", options: [\"o1\", \"o2\"]) { id } }";   
        $response = $this->postJson('/graphql', ['query' => $query]);
        $response->assertStatus(200);
        $res_array = (array)json_decode($response->content());
        $this->assertArrayHasKey('errors', $res_array);
    }

    public function test_createPoll_mutation(){
        $this->setAuthToken();
        $query = "mutation CreatePoll { createPoll(title: \"test\", options: [\"o1\", \"o2\"]) { id } }";   
        $response = $this->postJson('/graphql', ['query' => $query], ['Authorization' => $this->authToken]);
        $response->assertStatus(200);
        $response->assertJson(fn (AssertableJson $json) =>
            $json->hasAll(['data'])
        );
    }

    public function test_unauthorized_updatePoll_mutation(){
        $query = "mutation UpdatePoll { updatePoll(id: 1, title: \"new title\") { id } }";   
        $response = $this->postJson('/graphql', ['query' => $query]);
        $response->assertStatus(200);
        $res_array = (array)json_decode($response->content());
        $this->assertArrayHasKey('errors', $res_array);
    }

    public function test_updatePoll_mutation(){
        $this->setAuthToken();
        $query = "mutation UpdatePoll { updatePoll(id: 1, title: \"new title\") { id } }";   
        $response = $this->postJson('/graphql', ['query' => $query], ['Authorization' => $this->authToken]);
        $response->assertStatus(200);
        $response->assertJson(fn (AssertableJson $json) =>
            $json->hasAll(['data'])
        );
    }

    public function test_unauthorized_deletePoll_mutation(){
        $query = "mutation DeletePoll { deletePoll(id: 500) }";   
        $response = $this->postJson('/graphql', ['query' => $query]);
        $response->assertStatus(200);
        $res_array = (array)json_decode($response->content());
        $this->assertArrayHasKey('errors', $res_array);
    }

    public function test_deletePoll_mutation(){
        $this->setAuthToken();
        $query = "mutation DeletePoll { deletePoll(id: 500) }";   
        $response = $this->postJson('/graphql', ['query' => $query], ['Authorization' => $this->authToken]);
        $response->assertStatus(200);
        $response->assertJson(fn (AssertableJson $json) =>
            $json->hasAll(['data'])
        );
    }

    public function test_unauthorized_voteOnOption_mutation(){
        $query = "mutation VoteOnOption { voteOnOption(pollId: 1, optionId: 1) { id } }";   
        $response = $this->postJson('/graphql', ['query' => $query]);
        $response->assertStatus(200);
        $res_array = (array)json_decode($response->content());
        $this->assertArrayHasKey('errors', $res_array);
    }

    public function test_voteOnOption_mutation(){
        $this->setAuthToken();
        $query = "mutation VoteOnOption { voteOnOption(pollId: 1, optionId: 1) { id } }";   
        $response = $this->postJson('/graphql', ['query' => $query], ['Authorization' => $this->authToken]);
        $response->assertStatus(200);
        $response->assertJson(fn (AssertableJson $json) =>
            $json->hasAll(['data'])
        );
    }

    // public function test_createUser_mutation(){
    //     $query = "mutation CreateUser { createUser(username: \"testUser\", email: \"test@test.com\", password: \"12345678\") { id } }";   
    //     $response = $this->postJson('/graphql', ['query' => $query]);
    //     $response->assertStatus(200);
    //     $response->assertJson(fn (AssertableJson $json) =>
    //         $json->hasAll(['data'])
    //     );
    // }

    // public function test_loginUser_mutation(){
    //     $query = "mutation LoginUser { loginUser(email: \"test@test.com\", password: \"12345678\") }";   
    //     $response = $this->postJson('/graphql', ['query' => $query]);
    //     $response->assertStatus(200);
    //     $response->assertJson(fn (AssertableJson $json) =>
    //         $json->hasAll(['data'])
    //     );
    // }

    // public function test_logoutUser_mutation(){
    //     $query = "mutation LogoutUser { logoutUser }";   
    //     $response = $this->postJson('/graphql', ['query' => $query], ['Authorization' => $this->authToken]);
    //     $response->assertStatus(200);
    //     $response->assertJson(fn (AssertableJson $json) =>
    //         $json->hasAll(['data'])
    //     );
    // }

    public function test_unauthorized_createComment_mutation(){
        $query = "mutation CreateComment { createComment(pollId: 1, text: \"test\") { id } }";   
        $response = $this->postJson('/graphql', ['query' => $query]);
        $response->assertStatus(200);
        $res_array = (array)json_decode($response->content());
        $this->assertArrayHasKey('errors', $res_array);
    }

    public function test_createComment_mutation(){
        $this->setAuthToken();
        $query = "mutation CreateComment { createComment(pollId: 1, text: \"test\") { id } }";   
        $response = $this->postJson('/graphql', ['query' => $query], ['Authorization' => $this->authToken]);
        $response->assertStatus(200);
        $response->assertJson(fn (AssertableJson $json) =>
            $json->hasAll(['data'])
        );
    }

    public function test_unauthorized_deleteComment_mutation(){
        $query = "mutation DeleteComment { deleteComment(commentId: 1) }";   
        $response = $this->postJson('/graphql', ['query' => $query]);
        $response->assertStatus(200);
        $res_array = (array)json_decode($response->content());
        $this->assertArrayHasKey('errors', $res_array);
    }

    public function test_deleteComment_mutation(){
        $this->setAuthToken();
        $query = "mutation DeleteComment { deleteComment(commentId: 1) }";   
        $response = $this->postJson('/graphql', ['query' => $query], ['Authorization' => $this->authToken]);
        $response->assertStatus(200);
        $response->assertJson(fn (AssertableJson $json) =>
            $json->hasAll(['data'])
        );
    }

    public function test_unauthorized_createSurvey_mutation(){
        $query = "mutation CreateSurvey { createSurvey(title: \"test\", questions: [\"q1\", \"q2\"]) { id } }";   
        $response = $this->postJson('/graphql', ['query' => $query]);
        $response->assertStatus(200);
        $res_array = (array)json_decode($response->content());
        $this->assertArrayHasKey('errors', $res_array);
    }

    public function test_createSurvey_mutation(){
        $this->setAuthToken();
        $query = "mutation CreateSurvey { createSurvey(title: \"test\", questions: [\"q1\", \"q2\"]) { id } }";   
        $response = $this->postJson('/graphql', ['query' => $query], ['Authorization' => $this->authToken]);
        $response->assertStatus(200);
        $response->assertJson(fn (AssertableJson $json) =>
            $json->hasAll(['data'])
        );
    }

    public function test_unauthorized_updateSurvey_mutation(){
        $query = "mutation UpdateSurvey { updateSurvey(id: 1, titel: \"new\") { id } }";   
        $response = $this->postJson('/graphql', ['query' => $query]);
        $response->assertStatus(200);
        $res_array = (array)json_decode($response->content());
        $this->assertArrayHasKey('errors', $res_array);
    }

    public function test_updateSurvey_mutation(){
        $this->setAuthToken();
        $query = "mutation UpdateSurvey { updateSurvey(id: 1, titel: \"new\") { id } }";   
        $response = $this->postJson('/graphql', ['query' => $query], ['Authorization' => $this->authToken]);
        $response->assertStatus(200);
        $response->assertJson(fn (AssertableJson $json) =>
            $json->hasAll(['data'])
        );
    }

    public function test_unauthorized_deleteSurvey_mutation(){
        $query = "mutation DeleteSurvey {deleteSurvey(id: 1)}";   
        $response = $this->postJson('/graphql', ['query' => $query]);
        $response->assertStatus(200);
        $res_array = (array)json_decode($response->content());
        $this->assertArrayHasKey('errors', $res_array);
    }

    public function test_deleteSurvey_mutation(){
        $this->setAuthToken();
        $query = "mutation DeleteSurvey {deleteSurvey(id: 1)}";   
        $response = $this->postJson('/graphql', ['query' => $query], ['Authorization' => $this->authToken]);
        $response->assertStatus(200);
        $response->assertJson(fn (AssertableJson $json) =>
            $json->hasAll(['data'])
        );
    }

    public function test_unauthorized_submitSurvey_mutation(){
        $query = "mutation SubmitSurvey { submitSurvey(surveyId: 1, answers: [\"n1\", \"n2\"]) { id } }";   
        $response = $this->postJson('/graphql', ['query' => $query]);
        $response->assertStatus(200);
        $res_array = (array)json_decode($response->content());
        $this->assertArrayHasKey('errors', $res_array);
    }

    public function test_submitSurvey_mutation(){
        $this->setAuthToken();
        $query = "mutation SubmitSurvey { submitSurvey(surveyId: 1, answers: [\"n1\", \"n2\"]) { id } }";   
        $response = $this->postJson('/graphql', ['query' => $query], ['Authorization' => $this->authToken]);
        $response->assertStatus(200);
        $response->assertJson(fn (AssertableJson $json) =>
            $json->hasAll(['data'])
        );
    }

    public function test_unauthorized_resetPollVotes_mutation(){
        $query = "mutation ResetPollVotes { resetPollVotes(pollId: 1) }";   
        $response = $this->postJson('/graphql', ['query' => $query]);
        $response->assertStatus(200);
        $res_array = (array)json_decode($response->content());
        $this->assertArrayHasKey('errors', $res_array);
    }

    public function test_resetPollVotes_mutation(){
        $this->setAuthToken();
        $query = "mutation ResetPollVotes { resetPollVotes(pollId: 1) }";   
        $response = $this->postJson('/graphql', ['query' => $query], ['Authorization' => $this->authToken]);
        $response->assertStatus(200);
        $response->assertJson(fn (AssertableJson $json) =>
            $json->hasAll(['data'])
        );
    }

    public function test_unauthorized_resetSurveyResponses_mutation(){
        $query = "mutation ResetSurveyResponses { resetSurveyResponses(surveyId: 1) }";   
        $response = $this->postJson('/graphql', ['query' => $query]);
        $response->assertStatus(200);
        $res_array = (array)json_decode($response->content());
        $this->assertArrayHasKey('errors', $res_array);
    }

    public function test_resetSurveyResponses_mutation(){
        $this->setAuthToken();
        $query = "mutation ResetSurveyResponses { resetSurveyResponses(surveyId: 1) }";   
        $response = $this->postJson('/graphql', ['query' => $query], ['Authorization' => $this->authToken]);
        $response->assertStatus(200);
        $response->assertJson(fn (AssertableJson $json) =>
            $json->hasAll(['data'])
        );
    }
}
