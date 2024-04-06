
# Epresences Restful API

Restful API for employee presences system.


## How to Run Locally

Clone the project

```bash
  git clone https://github.com/ervanchodry112/epresences.git
```


### Logical Test
To run answer of logical test 

```bash
  cd logical-test
```

Run file using node JS

```bash
  node soal1.js
  node soal2.js
```
### Backend Test

To run epresences project

```bash
  cd backend-test
```
Install dependencies

```bash
  composer install
```
Create new database using PostgreSQL with the name **epresences**
Copy the .env.example file and rename it to .env
Configure the .env file to connect with the database, change these line
```bash
DB_CONNECTION=sqlite
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=laravel
# DB_USERNAME=root
# DB_PASSWORD=
```
with
```bash
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=epresences
DB_USERNAME=<your-username>
DB_PASSWORD=<your-password>
```
Run migration to create table in the database
```bash
php artisan migrate
```
Run the seeder to insert initial data to database
```bash
php artisan db:seed
```
Run the server
```bash
php artisan serve
```
Open the API documentation in [http://127.0.0.1:8000/api/documentation](http://127.0.0.1:8000/api/documentation)

---



## Using Documentation
To use all endpoint you need to get the **api key**.
To get the api key you can use the login endpoint.

There is two default account, `spv@email.com` and `bayu@email.com`. The default password for all account is `password`.

You can click the `Try it out` button at **Authorization > Login** endpoint, and change the email and password. If the authorization success, you will get the token from the API response like this.
```bash
{
  "message": "Success",
  "data": {
    "id": ...,
    "nama": ...,
    "email": ...,
    "npp": .,
    "npp_supervisor": ...,
    "created_at": ...,
    "updated_at": ...,
    "token": <your-token-is-here>
  }
}
```

Copy your token, then click the `Authorize` button at the top-right of the page.

Paste your token in the value field and add the word `Bearer` front of the token, so the token will look like this.
```code
Bearer <Your Token>
```
Then hit the authorize button, and you can use all of the endpoint.