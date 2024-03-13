<?php

namespace App\Factory;

use App\Entity\Poll;
use App\Repository\PollRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Poll>
 *
 * @method        Poll|Proxy                     create(array|callable $attributes = [])
 * @method static Poll|Proxy                     createOne(array $attributes = [])
 * @method static Poll|Proxy                     find(object|array|mixed $criteria)
 * @method static Poll|Proxy                     findOrCreate(array $attributes)
 * @method static Poll|Proxy                     first(string $sortedField = 'id')
 * @method static Poll|Proxy                     last(string $sortedField = 'id')
 * @method static Poll|Proxy                     random(array $attributes = [])
 * @method static Poll|Proxy                     randomOrCreate(array $attributes = [])
 * @method static PollRepository|RepositoryProxy repository()
 * @method static Poll[]|Proxy[]                 all()
 * @method static Poll[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static Poll[]|Proxy[]                 createSequence(iterable|callable $sequence)
 * @method static Poll[]|Proxy[]                 findBy(array $attributes)
 * @method static Poll[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static Poll[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 */
final class PollFactory extends ModelFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     */
    protected function getDefaults(): array
    {
        return [
            'question' => self::faker()->text(510),
            'options' => [
                self::faker()->text(16),
                self::faker()->text(16),
                self::faker()->text(16),
                self::faker()->text(16)
            ],
            'createdAt' => \DateTimeImmutable::createFromMutable(self::faker()->dateTime()),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(Poll $poll): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Poll::class;
    }
}
