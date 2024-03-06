<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\PollRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: PollRepository::class)]
#[ApiResource(
    order: ['createdAt' => 'DESC'],
    paginationEnabled: false,
)]
class Poll
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['poll:item', 'poll:list'])]
    private ?int $id = null;

    #[ORM\Column(length: 510)]
    #[Groups(['poll:item', 'poll:list'])]
    private ?string $question = null;

    #[ORM\Column(type: Types::ARRAY)]
    #[Groups(['poll:item', 'poll:list'])]
    private array $options = [];

    #[ORM\Column(type: Types::ARRAY, nullable: true)]
    #[Groups(['poll:item', 'poll:list'])]
    private ?array $votes = null;

    #[ORM\Column]
    #[Groups(['poll:item', 'poll:list'])]
    private ?\DateTimeImmutable $createdAt = null;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
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

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        if ($this->isNew()) {
            $this->createdAt = new \DateTimeImmutable();
        } else {
            $this->createdAt = $createdAt;
        }
        return $this;
    }

    private function initializeVotes(): void
    {
        $this->votes = array_fill(0, count($this->options), 0);
    }

    public function isNew(): bool
    {
        return $this->id === null;
    }

}
