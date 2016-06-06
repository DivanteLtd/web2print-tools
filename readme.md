# Web2Print Plugin for pimcore

Adds following additional features to the web2print functionality of pimcore.
- Favorite Output Channels
- Document Editable for Configurable Tables
- Custom Document Areas
- PDFreactor controller plugin
- samples for document areas, css styles, etc.


## Favorite Output Channels
Based on the OutputDataConfigToolkit (https://github.com/pimcore-partner/Elements_OutputDataConfigToolkit) this feature allowes
to save output channels centrally and reuse them in several places.

![favorite-output-channels](doc/img/favorite-output-channels.png)


## Document Editable for Configurable Tables
Editable for adding tables with configurable columns based on the output channels to documents.

![outputputcanneltable](doc/img/outputputcanneltable.png)

Usage:
```php
<?php
echo $this->outputchanneltable("tableconfig");
```
Also see included sample areas PrintColumnAttributeTable and PrintRowAttributeTable.


## Custom Document Areas
Custom Document Areas allow area creation directly in pimcore backend. Users can add frontend and editmode php/css and also can
access list of object data assigned in editmode. The data is available in frontend php file as ```$this->dataArray```

![outputputcanneltable](doc/img/custom-areas.png)


## PDFreactor Controller Plugin
The PDFreactor Controller Plugin allows to integrate web2print functionality directly to an controller action without using
web2print documents. It just renders the action output as PDF and returns it instead of html.

Usage in controller action:
```php
<?php

    public function myAction() {

        //do some stuff...

        $front = Zend_Controller_Front::getInstance();
        $front->registerPlugin(new \Web2Print\Controller\Plugin\ReactorPDF(), 777);

    }
```

With url parameter html=1 pdf rendering is deactivated.
