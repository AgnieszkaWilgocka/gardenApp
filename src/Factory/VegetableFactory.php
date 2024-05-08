<?php

namespace App\Factory;

use App\Entity\Vegetable;
use App\Repository\VegetableRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Vegetable>
 *
 * @method        Vegetable|Proxy                     create(array|callable $attributes = [])
 * @method static Vegetable|Proxy                     createOne(array $attributes = [])
 * @method static Vegetable|Proxy                     find(object|array|mixed $criteria)
 * @method static Vegetable|Proxy                     findOrCreate(array $attributes)
 * @method static Vegetable|Proxy                     first(string $sortedField = 'id')
 * @method static Vegetable|Proxy                     last(string $sortedField = 'id')
 * @method static Vegetable|Proxy                     random(array $attributes = [])
 * @method static Vegetable|Proxy                     randomOrCreate(array $attributes = [])
 * @method static VegetableRepository|RepositoryProxy repository()
 * @method static Vegetable[]|Proxy[]                 all()
 * @method static Vegetable[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static Vegetable[]|Proxy[]                 createSequence(iterable|callable $sequence)
 * @method static Vegetable[]|Proxy[]                 findBy(array $attributes)
 * @method static Vegetable[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static Vegetable[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 */
final class VegetableFactory extends ModelFactory
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
            'description' => self::faker()->sentence(4, 20),
            'harvestMonthStart' => self::faker()->monthName('+12 weeks'),
            'highLineSpace' => self::faker()->numberBetween(1, 5),
            'horizontalSpace' => self::faker()->numberBetween(1, 5),
            'siewingMonthStart' => self::faker()->monthName('+12 weeks'),
            'siewingMonthEnd' => self::faker()->monthName('+12 weeks'),
            'harvestMonthEnd' => self::faker()->monthName('+12 weeks'),
            'seedlingPlantingMonth' => self::faker()->monthName('+12 weeks'),
            'seedlingMoveToGroundMonth' => self::faker()->monthName('+12 weeks'),
            'title' => self::faker()->word(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(Vegetable $vegetable): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Vegetable::class;
    }
}
