# ETL Framwork

Create simple imports with the Extract/Transform/Load pattern.

## Example of use

```php
<?php

namespace App;

use Camillebaronnet\ETL\Extractor\Csv;
use Camillebaronnet\ETL\Strategy\LayerStrategy;
use Camillebaronnet\ETL\Transformer\DateTime;
use Camillebaronnet\ETL\Transformer\Trim;

//...

$etl = (new LayerStrategy)
    ->extract(Csv::class, ['filename' => 'dump.php'])
    ->transform(Trim::class)
    ->transform(DateTime::class, ['format' => 'd/m/Y', 'fields' => ['createAt']])
;

print_r($etl->load(JSON::class));

//...
```
