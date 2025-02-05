<?php

namespace App\Entities;

use DateTimeImmutable;

class Post
{
    public function __construct(
        private ?int $id,
        private ?int $userId,
        private string $title,
        private string $description,
        private ?DateTimeImmutable $createdAt,
    )
    {
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return DateTimeImmutable|null
     */
    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return int|null
     */
    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public static function create(
        string $title,
        string $description,
        ?int $userId = null,
        ?int $id = null,
        ?DateTimeImmutable $createdAt = null
    )
    {
        return new static(
            $id,
            $userId,
            $title,
            $description,
            $createdAt ?? new DateTimeImmutable()
        );
    }
}