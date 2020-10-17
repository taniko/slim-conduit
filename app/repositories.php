<?php
declare(strict_types=1);

use App\Domain\Model\Article\ArticleRepository;
use App\Domain\Model\Tag\TagRepository;
use App\Domain\User\UserRepository;
use App\Infrastructure\Persistence\Article\InMemoryArticleRepository;
use App\Infrastructure\Persistence\Tag\InMemoryTagRepository;
use App\Infrastructure\Persistence\User\InMemoryUserRepository;
use DI\ContainerBuilder;
use function DI\autowire;

return function (ContainerBuilder $containerBuilder) {
    // Here we map our UserRepository interface to its in memory implementation
    $containerBuilder->addDefinitions([
        UserRepository::class    => autowire(InMemoryUserRepository::class),
        ArticleRepository::class => autowire(InMemoryArticleRepository::class),
        TagRepository::class     => autowire(InMemoryTagRepository::class),
    ]);
};
