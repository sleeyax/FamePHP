# FamePHP
FamePHP is a PHP7 framework for creating Facebook messenger bots. It uses the official Facebook API and is structured in a way that allows you to add or remove functionality at your wish.

# Documentation
You can view the full code reference at <a href="https://sleeyax.github.io/FamePHP">github pages</a>!<br>
For a quick setup guide and some examples, head over to <a href="https://github.com/sleeyax/FamePHP/wiki">the wiki</a>.

# Quickstart
Can't wait to try it out? Edit `api/Config.php` to your requirements and use this code snippet in your callback file (`index.php`)
```php
<?php
// Load required components
require_once 'core/Bootstrap.php';
use Famephp\core\User;
use Famephp\core\Message;

// Specify modules we want to use
require_once 'core/attachments/Text.php';
use Famephp\core\attachments\Text;

// Read message & Send response
$user = new User();
$message = new Message($user->GetInfo()['id']);
if ($user->GetMessageText() == "what's my name?") 
{
    $firstname = $user->GetInfo()['first_name'];
    $message->Send(
        new Text("You are $firstname")
    );
}

```
Assuming that you've allready set up a testing environment, let's test it out:
![example bot screenshot](https://i.imgur.com/v6CzxOu.png)

# Changelog
V 1.0
* Initial release

V 1.0.1
* Added docs
* Update wiki

V 1.1
* Fixed asset upload bug: you can now manually specify PDO datatype instead of relying on automatic detection
* Fixed GenericTemplate error when specifying a nested array instead of a normal array (or the other way around)
* Upgraded to latest standard of may 7 2018, see: https://developers.facebook.com/docs/messenger-platform/send-messages for details 
* Complete wiki
* Exported database SQL file to 'api/' folder