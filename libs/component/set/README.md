# Doctrine Set

Simple library for Doctrine Custom Collections.

## Requirements

- PHP 8.4+

## Usage

### Custom Collection

For example, if you want to define a custom `SomeReferenceSet` collection for 
relation `SomeReference`, you should describe it as follows.

```php
use Local\Component\Set\RelationSet;

/**
 * @template-extends RelationSet<SomeReference>
 */
final class SomeReferenceSet extends RelationSet {}
```

## Usage

### OneToMany Relation

If an entity field contains a relation, then access to it 
should be described as follows:

```php
#[ORM\Entity]
class SomeReferenceOwner
{
    #[ORM\OneToMany(targetEntity: SomeReference::class, ...)]
    public private(set) Collection $references {
        get => SomeReferenceSet::for($this->references);
    }

    public function __construct(...)
    {
        $this->references = new SomeReferenceSet();
    }
}
```

### Array Type

If an entity field contains an array, then access to it
should be described as follows:

```php
#[ORM\Entity]
class SomeReferenceOwner
{
    #[ORM\Column(type: 'string[]')]
    private array $referenceValues = [];

    public private(set) SomeReferenceSet $references {
        get => SomeReferenceSet::for($this->referenceValues);
    }

    public function __construct(...)
    {
        $this->referenceValues = [1, 2, 3];
    }
}
```


