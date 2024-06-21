<?php

namespace App\Factory;

use App\Entity\Patch;
use App\Repository\PatchRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Patch>
 *
 * @method        Patch|Proxy                     create(array|callable $attributes = [])
 * @method static Patch|Proxy                     createOne(array $attributes = [])
 * @method static Patch|Proxy                     find(object|array|mixed $criteria)
 * @method static Patch|Proxy                     findOrCreate(array $attributes)
 * @method static Patch|Proxy                     first(string $sortedField = 'id')
 * @method static Patch|Proxy                     last(string $sortedField = 'id')
 * @method static Patch|Proxy                     random(array $attributes = [])
 * @method static Patch|Proxy                     randomOrCreate(array $attributes = [])
 * @method static PatchRepository|RepositoryProxy repository()
 * @method static Patch[]|Proxy[]                 all()
 * @method static Patch[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static Patch[]|Proxy[]                 createSequence(iterable|callable $sequence)
 * @method static Patch[]|Proxy[]                 findBy(array $attributes)
 * @method static Patch[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static Patch[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 */
final class PatchFactory extends ModelFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function getDefaults(): array
    {
        return [
            'heightPatch' => PatchRepository::CENTIMETER,
            'title' => self::faker()->word(),
            'widthPatch' => PatchRepository::CENTIMETER,

        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(Patch $patch): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Patch::class;
    }
}
