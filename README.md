# Ongage API in PHP

[Ongage](https://www.ongage.com) is a vendor agnostc email marketing platform.

This is a simple PHP implementation of the API calls.

### Installation
Update your `composer.json` file
```json
{
    "require": {
        "bcismariu/ongage-php": "0.1.*"
    }
}
```
Run `composer update`

### Usage
```php
use Bcismariu\Ongage\Ongage;

$ongage = new Ongage('USERNAME', 'PASSWORD', 'ACCOUNT_CODE');
$ongage->contacts->add([
    'list_id' => 'your_list_id',
    'email'   => 'contact.email@domain.com',
    'name'    => 'First Contact'
]);

// set a default list id
$ongage->setDefaultListId('your_list_id');
```
The method naming attempts to map the api uri, as described in the [docs](http://apidocs.ongage.net/index.html).
For instance, in order to make a call to `api/reports/query` the following method should be used:
```php
$ongage->reports->query($filter);
```

Read the official [API](https://ongage.atlassian.net/wiki/display/HELP/API) for more details regarding parameters and responses.

### Contributions

This is a very basic implementation that can only handle contacts and reports. Any project contributions are welcomed!
