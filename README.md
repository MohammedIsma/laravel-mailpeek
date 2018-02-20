# Laravel Mail Peek

[![MIT license](https://img.shields.io/badge/License-MIT-blue.svg)](https://lbesson.mit-license.org/) [![Maintenance](https://img.shields.io/badge/Maintained%3F-yes-green.svg)](https://GitHub.com/Naereen/StrapDown.js/graphs/commit-activity)

MailPeek provides a simple local inbox right in your browser to enable you preview  emails being sent from your application. Suport multiple recepients, attachments and more.

## TL:DR;
* For < Laravel 5.5 composer require misma/laravel-mailpeek "1.0.x-dev"
* For Laravel 5.5+ composer require misma/laravel-mailpeek "2.0.x-dev"
* Misma\MailPeek\MailPeekProvider::class,
* Misma\MailPeek\MailPeekMailProvider::class
* php artisan vendor:publish
* MAIL_DRIVER=mailpeek
That's it!

## Installation
#### Step 1/4: Install the package using composer
To install the package simple run one of the below command from your command line

For Laravel versions < 5.5
```bash
composer require misma/laravel-mailpeek "1.0.x-dev"
```
For Laravel versions 5.5 and above
```bash
composer require misma/laravel-mailpeek "2.0.x-dev"
```

#### Step 2/4: Register service providers
Once installation is complete, you will need to register the service providers. 
Open up config/app.php and add the following to the providers array.

* Misma\MailPeek\MailPeekProvider::class,
* Misma\MailPeek\MailPeekMailProvider::class

#### Step 3/4 : Publish assets & config
Publish required asset/config files into your application
```
php artisan vendor:publish
```

#### Step 4/4 : Set MailPeek as your mail driver
Finally, change `MAIL_DRIVER` to `mailpeek` in your `.env` file:

```
MAIL_DRIVER=mailpeek
```

---
## How it works

Once MailPeek is installed and configured, you can navigate to `http://<your-amazing-app-url>/mailpeek` and that will open your 'inbox'. Whenever any email is sent from the application,it will show up in the inbox. It's that easy.

## Package Configuration
Mailpeek pretty much doesn't require any post-installation configuration. After running `php artisan vendor:publish`, available options are contained in the `config/mailpeek.php`.

## Contribution
Contributions are highly welcomed. Please feel free to fork, tweak, send a PR, and "betterize" whatever you can.

## ★
If you like this package show me some star love, ★ this repo.

### Author
Mohammed Isma ([Twitter](https://www.twitter.com/mohammedisma))

### License
Laravel MailPeek is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).