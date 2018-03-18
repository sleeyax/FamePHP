# FamePHP
A bot for Facebook Messenger using the official API, written in PHP 7.

# Documentation
There's a lot that needs to be documented. Please be patient, I'm still working on it...

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
    $message->Send(
        new Text("You are " . $user->GetInfo()['first_name'])
    );
}
?>
```
Assuming that you allready know how to set up a testing environment, let's test it out:
![example bot screenshot](https://i.imgur.com/v6CzxOu.png)

# Note
FamePHP is currently in active development. If you just came here, make sure to stay updated!