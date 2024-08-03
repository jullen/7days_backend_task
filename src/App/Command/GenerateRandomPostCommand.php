<?php

namespace App\Command;

use Domain\Post\PostManager;
use joshtronic\LoremIpsum;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateRandomPostCommand extends Command
{
    protected static $defaultName = 'app:generate-random-post';
    protected static $defaultDescription = 'Generate a random or extra post';

    private PostManager $postManager;
    private LoremIpsum $loremIpsum;

    public function __construct(PostManager $postManager, LoremIpsum $loremIpsum, string $name = null)
    {
        parent::__construct($name);
        $this->postManager = $postManager;
        $this->loremIpsum = $loremIpsum;
    }

    protected function configure(): void
    {
        $this
            ->addOption(
                'isExtraPost',
                null,
                InputOption::VALUE_NONE,
                'If set, the command will generate an extra post with a specific title and content format'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $isExtraPost = $input->getOption('isExtraPost');

        if ($isExtraPost) {
            $title = 'Summary ' . (new \DateTime())->format('Y-m-d');
            $content = $this->loremIpsum->paragraphs();
        } else {
            $title = $this->loremIpsum->words(mt_rand(4, 6));
            $content = $this->loremIpsum->paragraphs(2);
        }

        $this->postManager->addPost($title, $content);

        $postType = $isExtraPost ? 'An extra' : 'A random';
        $output->writeln($postType . ' post has been generated.');

        return Command::SUCCESS;
    }
}
