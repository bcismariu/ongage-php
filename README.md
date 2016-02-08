# Ongage API in PHP

[Ongage](https://www.ongage.com) is a vendor agnostc email marketing platform.

This is a simple PHP implementation of the API calls.

### Installation
Update your `composer.json` file
```json
{
    "require": {
        "bcismariu/ongage-php": "0.*"
    }
}
```
Run `composer update`

### Usage
```php
use Bcismariu\Ongage\Ongage;

$ongage = new Ongage('USERNAME', 'PASSWORD', 'ACCOUNT_CODE');
$ongage->useList('YOUR_LIST_ID')->addContact([
    'email'  => 'contact.email@domain.com',
    'name'   => 'First Contact'
]);
```
Read the official [API](https://ongage.atlassian.net/wiki/display/HELP/API) for more details regarding parameters and responses.

### Contributions

This is a very basic implementation that can only handle email validations. Any project contributions are welcomed!
