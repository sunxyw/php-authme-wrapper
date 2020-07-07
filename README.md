# PHP Authme Wrapper

\*\* A simple php wrapper of authme, only verify password and hash password. Don't include database actions.

## Installation

You will need composer to install it.

```shell
$ composer require sunxyw/authme-wrapper
```

## Usage

```php
use Sunxyw\AuthmeWrapper\Wrapper;

$wrapper = Wrapper::getInstance();
$wrapper->use('Sha256'); // Now support: Sha256, Pbkdf2, Bcrypt
$inputPassword = '1234567';
$passwordHash = '$SHA$...'; // Usually stored in database
if ($wrapper->verify($inputPassword, $passwordHash)) {
    // Password is correct.
}
$generatedHash = $wrapper->hash($inputPassword);
```

You can also use it simplify:

```php
Wrapper::getInstance()->use('Sha256')->verify();
```

If you ignore the `use` method, if will be set to `Sha256` by default.

## Contributing

If you have any feature or improvement want to submit, please send a pr.
