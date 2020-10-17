<?php
namespace Tests\Application\Usecase;

use App\Application\Usecase\Article\ArticleApplicationService;
use App\Application\Usecase\Article\Create\CreateArticleCommand;
use App\Application\Usecase\Article\Delete\DeleteArticleCommand;
use App\Application\Usecase\UsecaseException\ForbiddenException;
use App\Domain\DomainException\DomainRecordNotFoundException;
use App\Domain\Model\Article\ArticleFactory;
use App\Domain\Model\Article\ArticleRepository;
use App\Domain\Model\Tag\TagRepository;
use Tests\TestCase;

class ArticleApplicationServiceTest extends TestCase
{
    public function testCreate()
    {
        try {
            $container = $this->getAppInstance()->getContainer();
        } catch (\Exception $e) {
            $this->fail();
            return;
        }
        $service = new ArticleApplicationService(
            $container->get(ArticleFactory::class),
            $container->get(ArticleRepository::class),
            $container->get(TagRepository::class),
        );

        $title = 'title';
        $body = 'test body';
        $user_id = 1;
        $tags = ['test', 'php'];
        $command = new CreateArticleCommand($user_id, $title, $body, $tags);
        try {
            $article = $service->create($command)->jsonSerialize();
        } catch (\Exception $e) {
            $this->fail($e->getMessage());
            return;
        }
        $this->assertEquals($title, $article['title']);
    }

    public function testDeleteArticle()
    {
        try {
            $container = $this->getAppInstance()->getContainer();
        } catch (\Exception $e) {
            $this->fail();
            return;
        }
        $service = new ArticleApplicationService(
            $container->get(ArticleFactory::class),
            $container->get(ArticleRepository::class),
            $container->get(TagRepository::class),
        );

        $title = 'title';
        $body = 'test body';
        $user_id = 1;
        $tags = ['test', 'php'];
        $command = new CreateArticleCommand($user_id, $title, $body, $tags);
        try {
            $article = $service->create($command)->jsonSerialize();
        } catch (\Exception $e) {
            $this->fail($e->getMessage());
            return;
        }
        $command = new DeleteArticleCommand($user_id, $article['id']);
        try {
            $service->delete($command);
            $this->assertTrue(true);
        } catch (ForbiddenException $e) {
            $this->fail("ForbiddenException: {$e->getMessage()}");
        } catch (DomainRecordNotFoundException $e) {
            $this->fail("DomainRecordNotFoundException: {$e->getMessage()}");
        }
    }
}