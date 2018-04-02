# FamePHP
A bot for Facebook Messenger using the official API, written in PHP 7.

# Documentation
You can view the full code reference at <a href="https://sleeyax.github.io/FamePHP">github pages</a>!<br>
For a quick setup guide and some examples, head over to <a href="https://github.com/sleeyax/FamePHP/wiki">this repo's wiki</a>

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
Assuming that you've already set up a testing environment, let's test it out:
![example bot screenshot](https://i.imgur.com/v6CzxOu.png)

# Note
FamePHP is currently in active development. If you just came here, make sure to stay updated!
