# TP-Symfony

<!-- TODO description -->

## Install project

1. Clone the project:

```bash
git clone git@github.com:CharlesLLM/TP-Symfony.git
cd TP-Symfony
```

2. Create a `.env.local` file like:

```bash
DATABASE_HOST=tp-db
DATABASE_PORT=3306
DATABASE_USER=admin
DATABASE_PASSWORD=admin
DATABASE_NAME=tp-symfony
DATABASE_VERSION=10.7.8-MariaDB
```

3. Start the project:

```bash
make start
```

Your project is now set up and ready to go!

- Project: [localhost](http://localhost/)
- PhpMyAdmin: [localhost:8080](http://localhost:8080) (user: `admin`, password: `admin`)
- Mailcatcher: [localhost:1080](http://localhost:1080)

| Command       | Description                      |
| ------------- | -------------------------------- |
| make start    | Start the project                |
| make stop     | Stop all containers              |
| make bash     | Connect to app container bash    |
| make assets   | Compile assets                   |
| make db       | Init database with data fixtures |
| make cache    | Clear cache                      |
| make perm     | Set permissions                  |
| make composer | Install dependencies             |

## Users

| Login        | Password     | Roles            |
| ------------ | ------------ | ---------------- |
| `superadmin` | `superadmin` | ROLE_SUPER_ADMIN |
| `admin`      | `admin`      | ROLE_ADMIN       |
| `user{1..5}` | `user`       | ROLE_USER        |
