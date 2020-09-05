# RequestObject

> WARNING! This package under development and cannot be used in real projects. For reference only.

Install this package via composer:

```
composer require seniorcote/request-object
```

Create request object like this:

```php
final class SomeRequestObject implements RequestObjectFromJson
{
    /**
     * @var int
     *
     * @Assert\NotNull()
     * @Assert\NotBlank()
     * @Assert\Type("integer")
     */
    public int $foo;

    /**
     * @var string
     *
     * @Assert\NotNull()
     * @Assert\NotBlank()
     * @Assert\Type("string")
     * @Assert\Choice(callback={"App\Enum\SomeType", "getValues"})
     */
    public string $bar;
    
    /**
     * @var string
     * 
     * @Assert\NotNull()
     * @Assert\NotBlank()
     * @Assert\Type("string")
     */
    public string $baz;

    /**
     * @var \DateTimeImmutable
     * 
     * @Assert\NotNull()
     * @Assert\NotBlank()
     * @Assert\Date()
     */
    public \DateTimeImmutable $date;

    /**
     * @var array|UploadedFile[]
     * 
     * @Assert\All({
     *     @Assert\File(maxSize="2M", mimeTypes={"image/*"})    
     * })
     */
    public array $files;
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

## TODO

- tests
- type cast
- nested objects parsing