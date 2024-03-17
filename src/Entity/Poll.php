<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use App\Repository\PollRepository;
use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PollRepository::class)]
#[ApiResource(
    operations: [
        new Get(
            normalizationContext: ['groups' => 'poll:read']
        ),
        new GetCollection(normalizationContext: ['groups' => 'poll:read']),
        new Post(
            normalizationContext: ['groups' => 'poll:read'],
            denormalizationContext: ["groups" => 'poll:write']
        )
    ],
    order: ['createdAt' => 'DESC'],
    paginationEnabled: false,
)]
class Poll
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['poll:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 510)]
    #[Groups(['poll:read', 'poll:write'])]
    #[Assert\NotBlank]
    #[Assert\NoSuspiciousCharacters]
    #[Assert\Length(min: 3)]
    private ?string $question = null;

    #[ORM\Column(type: Types::ARRAY)]
    #[Groups(['poll:read', 'poll:write'])]
    #[Assert\Count(min: 2, max: 10)]
    private array $options = [];

    #[ORM\Column(type: Types::ARRAY, nullable: true)]
    #[Groups(['poll:read'])]
    private ?array $votes = null;

    #[ORM\Column]
    #[Groups(['poll:read'])]
    private ?DateTimeImmutable $createdAt;

    public function __construct()
    {
        $this->createdAt = new DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuestion(): ?string
    {
        return $this->question;
    }

    public function setQuestion(string $question): static
    {
        $this->question = $question;

        return $this;
    }

    public function getOptions(): array
    {
        return $this->options;
    }

    public function setOptions(array $options): static
    {
        $this->options = $options;
        $this->initializeVotes();
        return $this;
    }

    public function getVotes(): ?array
    {
        return $this->votes;
    }

    public function setVotes(?array $votes): static
    {
        if ($this->isNew()) {
            $this->initializeVotes();
        } else {
            $this->votes = $votes;
        }

        return $this;
    }

    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeImmutable $createdAt): static
    {
        if ($this->isNew()) {
            $this->createdAt = new DateTimeImmutable();
        } else {
            $this->createdAt = $createdAt;
        }
        return $this;
    }

    private function initializeVotes(): void
    {
        $this->votes = array_fill(0, count($this->options), 0);
    }

    private function isNew(): bool
    {
        return $this->id === null;
    }

}
