# FamePHP
Facebook messenger's platform changed a lot after the completion of FamePHP, so here we are with version 2 of this framework!
It contains the new features added by facebook, upgrades and improvements.

## What's new
Before adding anything new, we require a huge cleanup
* PHP 7.2+
* Comply with PSR-2 standard
* Improved code style
```
$listener->hears('who likes callbacks?', function(Sender $sender, Response $response) {
    $response->send(new Text("We do, $sender->firstname! ;)"));
});
```
* Autoload using composer (finally)
* Replace plain curl with GuzzleHttp
* Added MonoLog
* Refactored GraphRequest class

TODO: rewrite asset handler, test quick_reply 'whisper' method
