

## About Service
 a REST microservice that list the languages used by trending public repos in the last 30 days on GitHub.
 by calling the API, it will return the trending languages and their number of repos with a list of repos using this language.

### API
Method : GET
https://m-trending-repos-languages.herokuapp.com/api/trending_github_repos_languages

##### response items structure will be like :
```json
{
    "data": [
        {
            "language": "C++",
            "number_of_repos": 4,
            "repos_using_the_language": [
                {
                    "full_name": "oceanbase/oceanbase",
                    "language": "C++",
                    "url": "https://api.github.com/repos/oceanbase/oceanbase"
                },
                {
                    "full_name": "binji/pokegb",
                    "language": "C++",
                    "url": "https://api.github.com/repos/binji/pokegb"
                },
                {
                    "full_name": "Tencent/flare",
                    "language": "C++",
                    "url": "https://api.github.com/repos/Tencent/flare"
                },
                {
                    "full_name": "GuitarML/NeuralPi",
                    "language": "C++",
                    "url": "https://api.github.com/repos/GuitarML/NeuralPi"
                }
            ]
        }      
    ]
}
```

### Used Tools and Tecnologies
- github API : https://api.github.com/search/repositories?q=created:>{date}&sort=stars&order=desc
- PHP / laravel framwork 
- Deploying : Heroku cloud service
- Testing : PHPUnit testing framework


