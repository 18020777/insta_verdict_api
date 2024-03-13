<?php

namespace App\Tests;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\Poll;
use App\Factory\PollFactory;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

use function Zenstruck\Foundry\faker;

class PollTest extends ApiTestCase
{
    use ResetDatabase, Factories;

    public function testCreatePoll(): void
    {
        static::createClient()->request('POST', '/api/polls', [
            'json' => [
                'question' => 'question',
                'options' => [
                    'option 1',
                    'option 2'
                ]
            ]
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertJsonContains([
            'question' => 'question',
            'options' => [
                'option 1',
                'option 2'
            ]
        ]);
    }

    public function testListPolls(): void
    {
        PollFactory::createMany(100);

        $response = static::createClient()->request('GET', '/api/polls');

        $this->assertResponseIsSuccessful();
        $this->assertJsonContains([
            '@context' => '/api/contexts/Poll',
            '@id' => '/api/polls',
            '@type' => 'hydra:Collection',
            'hydra:totalItems' => 100
        ]);
        $this->assertGreaterThanOrEqual(100, $response->toArray()['hydra:member']);
    }

    public function testVote(): void
    {
        $question = faker()->uuid();
        PollFactory::createOne(['question' => $question]);
        $iri = $this->findIriBy(Poll::class, ['question' => $question]);

        static::createClient()->request('PATCH', $iri . '/vote/0');

        $this->assertResponseIsSuccessful();
        $this->assertJsonEquals(["status" => "done"]);
    }

    public function testGetPoll(): void
    {
        $question = faker()->uuid();
        PollFactory::createOne(['question' => $question]);
        $iri = $this->findIriBy(Poll::class, ['question' => $question]);

        static::createClient()->request('GET', $iri);

        $this->assertResponseIsSuccessful();
        $this->assertJsonContains(["question" => $question]);
    }
}
