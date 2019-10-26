# <p>Telegram Scrapping</p>

[![Software License](https://img.shields.io/badge/license-GPL-brightgreen.svg?style=flat-square)](LICENSE) 

[![Packagist Version](https://img.shields.io/packagist/v/mfarahani/tcrawl.svg?style=flat-square)](https://img.shields.io/packagist/v/mfarahani/tcrawl)


## requirements

- PHP v7.2 or above
- Laravel v5.5 or above

  
## Installation

```
composer require mfarahani/tcrawl
```


## Documentation

### Baseic
find information and last message from public  channel telegram
```
$tCrawl = new TCrawler();
$tCrawl->setProxy("http://username:password@host:port");
$tCrawl->setChannel("channelname telegram");
$info           = $tCrawl->crawler()->getInfo();

$formWithTemplate = false; //you can use 'true' or 'false' for generate template

$lastMessgae    = $tCrawl->crawler()->getLastMessage($formWithTemplate);
$latestMessages = $tCrawl->crawler()->getLatestMessages($formWithTemplate, $fromId);


dump($info , $lastMessgae , $latestMessages );
```

### Create Template output

you can set template and generate message with your template

- Specify your template by inserting it between the [[***]]

example template :
```
$template = "phone number is : [[phone]] , name : [[name]]"
```

```
$tCrawl = new TCrawler();
$tCrawl->setProxy("http://username:password@host:port");
$tCrawl->setChannel("channelname telegram");

$info           = $tCrawl->crawler()->getInfo();

$tCrawl->templateBuilder()->createTemplate($info, $template);
$tCrawl->templateBuilder()->updateTemplate("channelname telegram", $template , $status);
$tCrawl->templateBuilder()->getTemplate("channelname telegram");

$tCrawl->templateBuilder()->build($username, $message);

```



## Contributing

Thank you for considering contributing to the TC Package! 


## License

The Laravel framework is open-source software licensed under the [MIT license](https://opensource.org/licenses/MIT).