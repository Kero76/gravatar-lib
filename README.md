# Gravatar Lib
Gravatar Lib is a small library to help integration of the gravatar service on your app.

## Requirements
* PHP 7.0.0 or newer.
* hash() function must be available, along with md5 algorithm.

## Usage
### Installation
You can install Gravatar Lib with composer to execute the following command : `$ composer require nicolas-gille/gravatar-lib`
Yan can clone or download the source directly from Github, and install it on your app.

### General example
```php
<?php
    // Includes sources or use autoloader to load directly the class.
    include_once('includes/gravatar-lib/src/Gravatar/Gravatar.php');

    // Create an instance of Gravatar with default value.
    $gravatar = new GravatarLib\Gravatar\Gravatar();

    // Set size and rating like this or use it directly on constructor.
    $gravatar->setSize(160);
    $gravatar->setMaxRating('pg');

    // Generate uri to show avatar.
    $uri = $gravatar->getUri('mail@domain.com');

    // Display it.
    echo '<img src="' . $uri . '" alt="Gravatar\'s image">';
```

### Settings the size of the avatar.
Gravatar offer to change the size of your avatar. 
By default, the value provide by Gravatar is 80 pixels, but, you can extends it at 2048 pixels.
To update the size of your avatar, use the method `GravatarLib\Gravatar\Gravatar->setSize(int)`.

You can get an example of set size of the avatar below:
```php
    $gravatar->setSize(160);
``` 

_Nota Bene :_<br>
If you exceed the maximum or the minimum values, this method throw on `\InvalidArgumentException` with the message
_The size must be within 0 and 2048_. 


### Settings the default image.
Gravatar provides several default avatar for people who don't have post their avatar.
Then, you can change the default image with these method `GravatarLib\Gravatar\Gravatar->setDefaultImage(string)`.
The default value offer by Gravatar are : '404', 'mm', 'identicon', 'monsterid', 'retro', 'wavatar' and 'blank'.

Another way to set the default image is to send on correct uri on parameter of the method to 
get the image instead the default value offer by Gravatar.

To use you own avatar, you can leave the constructor without set the default value to use your avatar. 

You can get an example of set default image below:
```php
    $gravatar->setDefaultImage('blank'); // with default value.
    $gravatar->setDefaultImage('http://my-website/my-avatar.jpg'); // with url.
    $gravatar->setDefaultImage(''); // Cannot use default image.
``` 

_Nota Bene :_<br>
If you send on invalid url or a string not contains in Gravatar API, this method throw on `\InvalidArgumentException`
with the message _The default image specified is not a valid URL or present as default value in Gravatar._. 


### Settings the rating image
With Gravatar, you can block certain type of content like ESRB for USA or PEGI for Europe.
Then, if you block specific avatar, you can set the max rating allow in your app with the method 
`GravatarLib\Gravatar\Gravatar->setMaxRating(string)`.
The default value allowed in the method are : 'g', 'pg', 'r', 'x'.

You can get an example of set the rating max below:
```php
    $gravatar->setMaxRating('g');
``` 

_Nota Bene :_<br>
If you send a string different to the valid value, this method throw on `\InvalidArgumentException`
with the message _The rating specified is invalid. Use only "g", "pg", "r" or "x" value._. 


### Settings secure uri.
In fact, Gravatar offer two way to get the image respectively in HTTP and in HTTPS.
By default, the library load the image via HTTP, but if you would, you can change this method by the method 
`GravatarLib\Gravatar\Gravatar->setSecureUri(bool)`.

```php
    $gravatar->setSecureUri(true); // Use HTTPS instead of HTTP.
```

### Force default image
You can force the default image for every people who connect on your app with your email.
To force the default image, you can use the method `GravatarLib\Gravatar\Gravatar->setForceDefaultImage(bool)`.

```php
    $gravatar->setForceDefaultImage(true); // Force all people to show default image instead of account avatar.
```


### Twig integration
You can easily hook this library on you project build with Twig.
In fact, to hook the library, you use a Twig_Environment object, and add it on it as a global attribute.
```php
<?php
    // Includes sources or use autoloader to load directly the class.
    include_once('includes/gravatar-lib/src/Gravatar/Gravatar.php');
    
    // Create an instance of Gravatar with default value.
    $gravatar = new GravatarLib\Gravatar\Gravatar();

    // ... do whatever you want with your settings here
    
    // here, we will assume $twig is an already-created instance of Twig_Environment
    $twig->addGlobal('gravatar', $gravatar);
```

Then, to use it on your template, you must call the object gravatar with the method `gravatar.uri(email)` to display the avatar.
```twig
    <img alt="{{ app.user.username }}'s avatar" src="{{ gravatar.uri(app.user.email)|raw }}">
```
In the example above, `app.user.username` and `app.user.email` contains respectively the username and the mail of the user.


## License
This project is under MIT License.

## Author
- Nicolas GILLE : <nic.gille@gmail.com>
