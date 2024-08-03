<?php

namespace App\Command;

use Domain\Post\PostManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AddPostCommand extends Command
{
    protected static $defaultName = 'app:add-post';
    protected static $defaultDescription = 'Add a post with specified title and content';

    private PostManager $postManager;

    public function __construct(PostManager $postManager, string $name = null)
    {
        parent::__construct($name);
        $this->postManager = $postManager;
    }

    protected function configure(): void
    {
        $this
            ->addArgument('title', InputArgument::REQUIRED, 'Title of the post')
            ->addArgument('content', InputArgument::REQUIRED, 'Content of the post');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $title = $input->getArgument('title');
        $content = $input->getArgument('content');

        $this->postManager->addPost($title, $content);

        $output->writeln('The post has been added.');

        return Command::SUCCESS;
    }
}
