# FamePHP
FamePHP is a framework for creating Facebook messenger bots. It uses the official Facebook API and requires PHP 7.2 or higher.

# Documentation
For a quick setup guide and some examples, head over to <a href="https://github.com/sleeyax/FamePHP/wiki">the wiki</a>.

# Quickstart
Can't wait to try it out? Edit `api/Config.php` to your requirements and use this code snippet in `index.php`
```php
<?php
require_once 'core/Bootstrap.php';
use Famephp\core\Response;
use Famephp\core\Sender;
use Famephp\core\attachments\Text;

$listener->hears('hi', function(Sender $sender, Response $response) {
    $response->send(new Text("Hello, $sender->firstname! :D"));
});
```
![quickstart result image](https://i.imgur.com/F8eKY3J.png)
