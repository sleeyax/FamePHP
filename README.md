# FamePHP
Facebook messenger's platform changed a lot after the completion of FamePHP, so here we are with version 2 of this framework! 
V2 is not a complete rewrite, but it has too many changes to be merged with the master branch at this point in time.

## What's new
* PHP 7.2+
* Comply with PSR-2 standard
* Improved code style/syntax
```
$listener->hears('who likes callbacks?', function(Sender $sender, Response $response) {
    $response->send(new Text("We do, $sender->firstname! ;)"));
});
```
* Autoload using composer
* Replace plain curl with GuzzleHttp
* Added MonoLog (+-)
* Refactored GraphRequest class
* Unit tests (+-)
* Database drivers (mysql_pdo, sqlite)
* Improved GraphRequest class
* Improved AssetManager class
