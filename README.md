# Phone Book

---

### [Local App](http://localhost)
### [Local PhpMyAdmin](http://localhost:8088)

---
#### To run application locally using <span style="color:chocolate; font-style: italic">docker compose</span> and <span style="color:chocolate; font-style: italic">make</span> next commands must be executed from the root folder:


<span style="color:chocolate; font-style: italic">
clone this repository
</span>

```shell
git clone git@github.com:kimiriecs/phone-book.git
```

<span style="color:chocolate; font-style: italic">
move into the root directory of the project
</span>

```shell
cd ./phone-book
```

<span style="color:chocolate; font-style: italic">
run application
</span>

```shell
make up
```

<span style="color:chocolate; font-style: italic">
install application composer dependencies
</span>

```shell
make composer-install
```

<span style="color:chocolate; font-style: italic">
list available commands
</span>

```shell
make command list
```

<span style="color:chocolate; font-style: italic">
run database migrations
</span>

```shell
make command db:migrate
```

<span style="color:chocolate; font-style: italic">
seed database
</span>

```shell
make command db:seed
```

<span style="color:chocolate; font-style: italic">
stop application and remove containers
</span>

```shell
make down
```

## Description

For testing purposes application already contains 15 test users:

```json
{
    "email": "user1@example.com",
    "password": "password"
}
```
. . .

```json
{
  "email": "user15@example.com",
  "password": "password"
}
```

### Access

#### To login, logout and registration:

    use "Profile" tab in navigation bar