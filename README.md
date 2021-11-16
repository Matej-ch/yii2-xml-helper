Xml helper
==========
Simple xml helper class for loading xml

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require matejch/yii2-xmlhelper:1.0
```

or add

```
"matejch/yii2-xmlhelper": "^1.0"
```

to the require section of your `composer.json` file.

Usage
------------
```php 

(new XmlHelper())->parse($xmlContent);

```

By default, parses as array, change by setting _**asArray**_ parameter to _**false**_