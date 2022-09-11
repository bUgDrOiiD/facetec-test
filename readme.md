# FaceTec Exercise

## Running the project

Using docker (Install [Docker](https://www.docker.com/) if needed):

1. Git clone this project

2. Fill docker-composer.yml "database" service with your desired credentials. Example:

```
environment:
    MYSQL_ROOT_PASSWORD: secret
    MYSQL_DATABASE: facetec
    MYSQL_USER: symfony
    MYSQL_PASSWORD: symfony
```

3. Create .env file with database connection string. Example if using the docker DB service:

```
cd /app
touch .env
```

Add the following variables to .env, for this project these are enough:


```
APP_ENV=dev
APP_SECRET=

MESSENGER_TRANSPORT_DSN=doctrine://default?auto_setup=0

# Docker DB service
DATABASE_URL="mysql://root:secret@mysql_database:3306/facetec?serverVersion=8.0"
```

4. Run the docker containers (from the root folder):

```
docker-compose up --build
```

**_NOTE:_**  Use -d flag to detach the console

5. SSH into docker container (Use docker dashboard "Open in terminal" option or use this command: ```
docker exec -it <container name> /bin/bash```) and run the following commands:

```
cd /var/www/app
composer install
php bin/console doctrine:database:create # might not be needed
php bin/console doctrine:migrations:migrate
```
**_NOTE:_**  We could add these commands to the Dockerfile so they would be run automatically but for the sake of knowing whats going on lets run them manually.

## The final result should be the following:

3 different containers:

- Database
- PHP / Project
- Ngnix server

![Docker containers](get-started-guide-images/docker-containers.png "Docker containers")

You can now access **localhost:8080** to see the symfony default page.


# Check if the test requirements are met

## Symfony verstion is the LTS :

![Docker containers](get-started-guide-images/LTS.png "Docker containers")

You can also run the following command to check if our environment has everything we need:

```
symfony check:requirements
```
![Docker containers](get-started-guide-images/symfony-requirements.png "Docker containers")

# Project

What is included in this project :

- MySql database
- User entity, controller, repo, form and more.
- Custom validation constraint called "FacetecString", about this validator:

The validation constraint should test that a string contains either the text “Face” (case sensitive) or the text “Tec” (case insensitive)

- Twig template that lists existing users in BD.
- Twig template that allows the creation of new users.
- Application of the FacetecString constraint in the user name field on the User entity.
- Unit tests for the FacetecString constraint, you can run them:

``` 
php bin/phpunit tests/Validator
```

![Docker containers](get-started-guide-images/unit-tests.png "Docker containers")

# User form 

Navigate to localhost:8080/user/create.
Heres a video demostrating the form working and validating the user name using the constraing mentioned above :

https://user-images.githubusercontent.com/104202635/189536193-3756a00f-60d1-4f75-9951-d2e0008a364a.mov

