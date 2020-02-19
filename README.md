# RequestObject

> WARNING! This package under development and cannot be used in real projects. For reference only.

Install this package via composer:

```
composer require seniorcote/request-object
```

Create request object like this:

```php
<?php

declare(strict_types=1);

namespace App\Request;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Seniorcote\RequestObject\RequestObject;
use Seniorcote\RequestObject\Annotation as RO;

final class SomeRequestObject implements RequestObject
{
    /**
     * @var int
     *
     * @Assert\NotNull()
     * @Assert\Type("integer")
     * 
     * @RO\Type(type="integer") 
     */
    public $foo;

    /**
     * @var string
     *
     * @Assert\NotNull()
     * @Assert\Type("string")
     * @Assert\Choice(callback={"App\Enum\SomeType", "getValues"})
     * 
     * @RO\Type(type="string") 
     */
    public $bar;
    
    /**
     * @var string
     * 
     * @Assert\NotNull()
     * @Assert\Type("string")
     * 
     * @RO\QueryParam(name="baz")
     * @RO\Type(type="string") 
     */
    public $baz;

    /**
     * @var \DateTimeImmutable
     * 
     * @Assert\NotNull()
     * @Assert\NotBlank()
     * @Assert\Date()
     * 
     * @RO\Type(type="datetime") 
     */
    public $date;

    /**
     * @var UploadedFile
     * 
     * @Assert\File(
     *     maxSize="2M",
     *     mimeTypes={"image/jpeg", "image/png"}
     * )
     * 
     * @RO\File(key="image")
     */
    public $image;

    /**
     * @var UploadedFile[]
     * 
     * @Assert\All({
     *     @Assert\File(maxSize="2M", mimeTypes={"image/*"})    
     * })
     * 
     * @RO\Files()
     */
    public $files;
}
```

Using in controller:

```php
/**
 * @param SomeRequestObject $request
 *
 * @Route("/action", name="action", methods={"POST"})
 */
public function create(SomeRequestObject $request)
{
    $request->foo; // already valid!
}
```

If you want the controller to return a response containing validation errors, subscribe to the ValidationException and build the response you need:

```php

```

## TODO

- tests
- type cast
- nested objects parsing