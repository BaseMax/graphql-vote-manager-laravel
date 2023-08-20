# Secure Online Voting System using GraphQL Laravel

This project is a secure online voting system built using Laravel 10 and PHP 8.2, with the added feature of caching using Redis. The system allows users to create and participate in polls and surveys through a GraphQL API. This README provides an overview of the project, setup instructions, and usage guidelines.

A comprehensive GraphQL-powered voting system developed with Laravel 10 and PHP 8.2. Manage polls, surveys, and user votes securely, utilizing Redis caching for optimized responsiveness.

## Introduction

The Secure Online Voting System is a web application that leverages GraphQL to provide a flexible and efficient API for creating, managing, and participating in polls and surveys. The system is built on top of Laravel 10 and PHP 8.2, ensuring a robust and modern backend architecture.

## Features

- User authentication and authorization
- Create, read, update, and delete polls/surveys
- Vote on poll options
- Real-time updates using GraphQL subscriptions
- Caching with Redis for improved performance
- Comprehensive API documentation

## Prerequisites

Before you begin, ensure you have the following installed on your system:

- PHP 8.2
- Composer
- Laravel 10
- Redis
- Git

## Installation

Clone the repository:

```bash
git clone https://github.com/basemax/graphql-vote-manager-laravel.git
```

Navigate to the project directory:

```bash
cd graphql-vote-manager-laravel
```

Install project dependencies:

```bash
composer install
```

Copy the `.env.example` file to `.env`:

```bash
cp .env.example .env
```

Generate an application key:

```bash
php artisan key:generate
```

Set up your database configuration in the `.env` file.

Run database migrations:

```bash
php artisan migrate
```

Start the Laravel development server:

```bash
php artisan serve
```

Access the application in your browser at `http://localhost:8000`.

## Configuration

You can configure various settings in the .env file, including database connections, caching, and GraphQL related configurations.

## Usage

Once the application is up and running, you can interact with the GraphQL API using tools like Insomnia or Postman. Refer to the API documentation for details on the available queries, mutations, and subscriptions.

## API Documentation

For detailed information about the available API operations, refer to the API documentation.

## GraphQL Queries and Mutations

## GraphQL Queries and Mutations

| Type     | Name                     | Description                                    | Example                                                                                     |
|----------|--------------------------|------------------------------------------------|---------------------------------------------------------------------------------------------|
| Query    | `getUser`                | Retrieve user details based on their ID.       | `getUser(id: 123)`                                                                          |
| Query    | `getPoll`                | Get information about a specific poll.         | `getPoll(id: 456)`                                                                          |
| Query    | `getAllPolls`            | Get a list of all available polls.             | `getAllPolls`                                                                               |
| Query    | `getUserPolls`           | Retrieve polls created by the user.            | `getUserPolls`                                                                              |
| Mutation | `createPoll`             | Create a new poll with options.                | `createPoll(title: "Favorite Color", options: ["Red", "Blue", "Green"])`                    |
| Mutation | `updatePoll`             | Update poll details and options.               | `updatePoll(id: 456, title: "New Title", options: ["Option A", "Option B"])`                |
| Mutation | `deletePoll`             | Delete a poll using its ID.                   | `deletePoll(id: 789)`                                                                       |
| Mutation | `voteOnOption`           | Cast a vote on a specific poll option.         | `voteOnOption(pollId: 456, optionId: 2)`                                                      |
| Mutation | `createUser`             | Register a new user with credentials.          | `createUser(username: "john_doe", email: "john@example.com", password: "securepassword")`   |
| Mutation | `loginUser`              | Authenticate a user and get an access token.  | `loginUser(email: "john@example.com", password: "securepassword")`                           |
| Mutation | `logoutUser`             | Log out the authenticated user.                | `logoutUser`                                                                                |
| Mutation | `createComment`          | Add a comment to a poll.                       | `createComment(pollId: 456, text: "Great poll!")`                                            |
| Mutation | `deleteComment`          | Remove a comment from a poll.                  | `deleteComment(commentId: 123)`                                                              |
| Query    | `getPollComments`        | Get all comments associated with a poll.      | `getPollComments(pollId: 456)`                                                              |
| Mutation | `createSurvey`           | Create a new survey with questions.            | `createSurvey(title: "Feedback Survey", questions: ["How satisfied are you?", "Suggestions"])` |
| Mutation | `updateSurvey`           | Update survey details and questions.           | `updateSurvey(id: 789, title: "Updated Survey", questions: ["New Question"])`                |
| Mutation | `deleteSurvey`           | Delete a survey using its ID.                 | `deleteSurvey(id: 789)`                                                                     |
| Query    | `getSurvey`              | Get information about a specific survey.       | `getSurvey(id: 789)`                                                                        |
| Query    | `getAllSurveys`          | Get a list of all available surveys.           | `getAllSurveys`                                                                             |
| Mutation | `submitSurvey`           | Submit responses for a specific survey.        | `submitSurvey(surveyId: 789, responses: ["Satisfied", "Great suggestions"])`                 |
| Query    | `getSurveyResponses`     | Get all responses for a specific survey.      | `getSurveyResponses(surveyId: 789)`                                                        |
| Query    | `getLoggedInUser`        | Get details of the currently logged-in user.  | `getLoggedInUser`                                                                           |
| Query    | `getPollVotes`           | Get the total number of votes for a poll.      | `getPollVotes(pollId: 456)`                                                                 |
| Query    | `getSurveyStats`         | Get statistical information about a survey.    | `getSurveyStats(surveyId: 789)`                                                             |
| Mutation | `resetPollVotes`         | Reset votes for a poll (admin use).            | `resetPollVotes(pollId: 456)`                                                               |
| Mutation | `resetSurveyResponses`   | Reset survey responses (admin use).            | `resetSurveyResponses(surveyId: 789)`                                                       |

## GraphQL Structure

```graphql
type User {
  id: ID!
  username: String!
  email: String!
  polls: [Poll!]!
  surveys: [Survey!]!
}

type Poll {
  id: ID!
  title: String!
  description: String
  options: [PollOption!]!
  user: User!
  comments: [Comment!]!
  votes: [PollVote!]!
}

type PollOption {
  id: ID!
  text: String!
  poll: Poll!
  votes: [PollVote!]!
}

type PollVote {
  id: ID!
  user: User!
  poll: Poll!
  pollOption: PollOption!
}

type Comment {
  id: ID!
  text: String!
  user: User!
  poll: Poll!
}

type Survey {
  id: ID!
  title: String!
  questions: [String!]!
  user: User!
  responses: [SurveyResponse!]!
}

type SurveyResponse {
  id: ID!
  user: User!
  survey: Survey!
  answers: [String!]!
}

type SurveyAction {
  id: ID!
  user: User!
  survey: Survey!
  answered: Boolean
}

type SurveyStatus {
  seens: Int!
  notSeens: Int!
  answereds: Int!
  didNotAnswereds: Int!
}

type Query {
  getUser(id: ID!): User
  getPoll(id: ID!): Poll
  getAllPolls: [Poll!]!
  getUserPolls: [Poll!]!
  getPollComments(pollId: ID!): [Comment!]!
  getLoggedInUser: User
  getPollVotes(pollId: ID!): Int
  getSurvey(id: ID!): Survey
  getAllSurveys: [Survey!]!
  getSurveyResponses(surveyId: ID!): [SurveyResponse!]!
  getSurveyStatus(surveyId: ID!): SurveyStatus
}

type Mutation {
  createPoll(title: String!, description: String, options: [String!]!): Poll!
  updatePoll(id: ID!, title: String, description: String): Poll
  deletePoll(id: ID!): Boolean
  voteOnOption(pollId: ID!, optionId: ID!): PollVote
  createUser(username: String!, email: String!, password: String!): User
  loginUser(email: String!, password: String!): String
  logoutUser: Boolean
  createComment(pollId: ID!, text: String!): Comment
  deleteComment(commentId: ID!): Boolean
  createSurvey(title: String!, questions: [String!]!): Survey!
  updateSurvey(id: ID!, title: String, questions: [String!]!): Survey
  deleteSurvey(id: ID!): Boolean
  submitSurvey(surveyId: ID!, answers: [String!]!): SurveyResponse
  resetPollVotes(pollId: ID!): Boolean
  resetSurveyResponses(surveyId: ID!): Boolean
}

```

## Security

Security is a top priority in this project. User authentication and authorization mechanisms are implemented to ensure that only authorized users can perform certain actions.

## Contributing

Contributions to the project are welcome. If you find any bugs, security vulnerabilities, or have suggestions for improvements, please open an issue or submit a pull request.

## License

This project is open-source and available under the GPL-3.0 License. Feel free to use, modify, and distribute it as per the terms of the license.

Copyright 2023, Max Base
