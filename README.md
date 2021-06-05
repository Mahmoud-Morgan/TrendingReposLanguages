

## About Service
 a REST microservice that list the languages used by trending public repos in the last 30 days on GitHub.
 by calling the API, it will return the trending languages and their number of repos with a list of repos using this language.

### API
Method : GET
https://m-trending-repos-languages.herokuapp.com/api/trending_github_repos_languages


### Used Tools and Tecnologies
- github API : https://api.github.com/search/repositories?q=created:>{date}&sort=stars&order=desc
- PHP / laravel framwork 
- Deploying : Heroku cloud service
- Testing : PHPUnit testing framework


