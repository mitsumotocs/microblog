<?php

declare(strict_types=1);

namespace Project\Domain;

use DateTimeImmutable;
use Ramsey\Uuid\Uuid;

class Post
{
    const RESOURCE_ID = '';

    public string $id;
    public int $createdAt;
    public string $content = '';

    public function __construct()
    {
        $this->id = (Uuid::uuid4())->toString();
        $this->createdAt = (new DateTimeImmutable())->getTimestamp();
    }

    public function __toString(): string
    {
        return sprintf('Post <%s>', $this->id);
    }

    // don't need these?
    public function __serialize(): array
    {
        return [
            'id' => $this->id,
            'created_at' => $this->createdAt,
            'content' => $this->content,
        ];
    }

    public function __unserialize(array $data): void
    {
        $this->id = $data['id'];
        $this->createdAt = $data['created_at'];
        $this->content = $data['content'];
    }

    /*
    public function toStorable(): string
    {
        return json_encode($this);
    }

    public function fromStorable(string $storable): self
    {
        $data = json_decode($storable, true);
        $entity = new self();

        return $entity;

    }

    public function getResourceId(): string
    {
        return '';
    }
    */
}
