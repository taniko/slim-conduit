<?php
declare(strict_types=1);

use App\Domain\Model\Article\ArticleFactory;
use App\Domain\Service\UserService;
use App\Domain\User\UserFactoryInterface;
use App\Infrastructure\Persistence\Article\InMemoryArticleFactory;
use App\Infrastructure\Persistence\User\InMemoryUserFactory;
use DI\ContainerBuilder;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        LoggerInterface::class      => function (ContainerInterface $c) {
            $settings = $c->get('settings');

            $loggerSettings = $settings['logger'];
            $logger         = new Logger($loggerSettings['name']);

            $processor = new UidProcessor();
            $logger->pushProcessor($processor);

            $handler = new StreamHandler($loggerSettings['path'], $loggerSettings['level']);
            $logger->pushHandler($handler);

            return $logger;
        },
        UserService::class          => function (ContainerInterface $container) {
            return new UserService();
        },
        UserFactoryInterface::class => function (ContainerInterface $container) {
            return new InMemoryUserFactory();
        },
        ArticleFactory::class       => fn(ContainerInterface $container) => new InMemoryArticleFactory(),
    ]);
};
