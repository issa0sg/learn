<?php

namespace App\Services;

use App\Entities\Post;
use DateTimeImmutable;
use Doctrine\DBAL\Connection;
use Exception;
use Learn\Custom\Http\Exceptions\NotFoundException;

class PostService
{
    public function __construct(
        private Connection $connection
    )
    {
    }

    public function find(int $id): ?Post
    {
        $qeuryBuilder = $this->connection->createQueryBuilder();

        $queryResult = $qeuryBuilder->select('*')
            ->from('posts')
            ->where('id = :id')
            ->setParameter('id', $id)
            ->executeQuery();

        $postData = $queryResult->fetchAssociative();

        if (!$postData) {
            return null;
        }

        return Post::create(
            $postData['title'],
            $postData['description'],
            $postData['user_id'],
            $postData['id'],
            new DateTimeImmutable($postData['created_at']),
        );
    }

    public function findOrFail(int $id): Post
    {
        $post = $this->find($id);
        if (!$post) {
            throw new NotFoundException("Post $id not found");
        }

        return $post;
    }

    public function save(Post $post): int
    {
        $queryBuilder = $this->connection->createQueryBuilder();

        $queryBuilder->insert('posts')
            ->values([
                'user_id' => ':user_id',
                'title' => ':title',
                'description' => ':description',
                'created_at' => ':created_at',
            ])
            ->setParameters([
                'user_id' => 1,
                'title' => $post->getTitle(),
                'description' => $post->getDescription(),
                'created_at' => $post->getCreatedAt()->format('Y-m-d H:i:s'),
            ])->executeQuery();

        $id = $this->connection->lastInsertId();

        $post->setId($id);

        return $id;
    }
}