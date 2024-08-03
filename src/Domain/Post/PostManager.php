<?php

namespace Domain\Post;

use App\Entity\Post;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;

class PostManager
{
    private EntityManagerInterface $em;
    private LoggerInterface $logger;

    public function __construct(EntityManagerInterface $em, LoggerInterface $logger)
    {
        $this->em = $em;
        $this->logger = $logger;
    }

    public function addPost(string $title, string $content): void
    {
        try {
            $post = new Post();
            $post->setTitle($title);
            $post->setContent($content);

            $this->em->persist($post);
            $this->em->flush();
        } catch (\Exception $e) {
            $this->logger->error('Failed to add post: ' . $e->getMessage());
        }
    }

    public function findPost(int $id): ?Post
    {
        return $this->em->getRepository(Post::class)->find($id);
    }
}
