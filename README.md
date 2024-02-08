<div align="center">
    <h1>Cronos api</h1>
    <img src="/resources/logo.png" alt="logo" width="280px" />
</div>

## Description

Cronos is an innovative social media platform designed with a unique approach to content sharing and user interaction. Emphasizing both the ephemeral nature of digital content and the importance of user privacy, Cronos offers a distinctive experience for its users.

## Requirements

- [Git](https://www.git-scm.com/)
- [Docker](https://www.docker.com/)
- [PHP](https://www.php.net/): ```v8.3.*```
- [Composer](https://getcomposer.org/) : ```v2.6.6```

## Installation

### Recover the project

Get the project from github using :

- https:

```sh
git clone https://github.com/Cronos-B3/api.git
```

or

- ssh:

```sh
git clone git@github.com:Cronos-B3/api.git
```

Then, enter in the project folder

### Install dependencies

```sh
composer install
```

## Configuration

You need to copy the .env.example onto the .env

After, you need to create the docker

```sh
sail up -d
```

Next, generate a key for your app to work

```sh
sail artisan key:generate
```

The app is now configure at [localhost](http://localhost:80), you can access it to try.

## Use

Run it in developer mode under development :

```sh
sail up -d
```

You can access it from [localhost](http://localhost:80)

## Tests

<!-- TODO -->

## Deployement

<!-- TODO -->

## License

Cronos is open source software [or "is licensed"] under the [MIT License](LICENSE). This means that anyone is free to use, copy, modify, and distribute the software for any purpose, subject to the terms outlined in the license.
