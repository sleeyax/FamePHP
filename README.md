# FamePHP
Facebook messenger's platform changed a lot after the completion of FamePHP, so here we are with version 2 of this framework!
It contains the new features added by facebook, upgrades and improvements.

## What's new
* Comply with PSR-2 standard
* Improved code style
```
$listener->hears('who likes callbacks?', function(Sender $sender, Response $response) {
    $response->send(new Text("We do, $sender->firstname! ;)"));
});
```
...