<?php


namespace App\Application\Usecase\Article;


use App\Application\Usecase\Article\Create\CreateArticleCommand;
use App\Application\Usecase\Article\Create\CreateArticleResult;
use App\Application\Usecase\Article\Delete\DeleteArticleCommand;
use App\Application\Usecase\Article\Get\GetArticleQuery;
use App\Application\Usecase\Article\Update\UpdateArticleCommand;
use App\Application\Usecase\Article\Update\UpdateArticleResult;
use App\Application\Usecase\UsecaseException\ForbiddenException;
use App\Domain\DomainException\DomainRecordNotFoundException;
use App\Domain\Model\Article\Article;
use App\Domain\Model\Article\ArticleFactory;
use App\Domain\Model\Article\ArticleRepository;
use App\Domain\Model\Article\ArticleService;
use App\Domain\Model\Article\Body;
use App\Domain\Model\Article\Title;
use App\Domain\Model\Tag\Name;
use App\Domain\Model\Tag\Tag;
use App\Domain\Model\Tag\TagRepository;
use Exception;

class ArticleApplicationService
{
    private ArticleFactory $articleFactory;
    private ArticleRepository $articleRepository;
    private ArticleService $articleService;
    /**
     * @var TagRepository
     */
    private TagRepository $tagRepository;

    /**
     * ArticleApplicationService constructor.
     *
     * @param ArticleFactory    $articleFactory
     * @param ArticleRepository $articleRepository
     * @param TagRepository     $tagRepository
     */
    public function __construct(ArticleFactory $articleFactory, ArticleRepository $articleRepository, TagRepository $tagRepository)
    {
        $this->articleFactory    = $articleFactory;
        $this->articleRepository = $articleRepository;
        $this->tagRepository     = $tagRepository;
    }

    /**
     * @param CreateArticleCommand $command
     * @return CreateArticleResult
     * @throws Exception
     */
    public function create(CreateArticleCommand $command)
    {
        $tags = $this->tagRepository->findByNames(array_unique($command->getTags()));
        foreach ($command->getTags() as $name) {
            $exist = false;
            foreach ($tags as $tag) {
                if ($name === $tag->getName()) {
                    $exist = true;
                    break;
                }
            }
            if (!$exist) {
                $tag    = new Tag(null, new Name($name));
                $tags[] = $this->tagRepository->save($tag);
            }
        }
        $article = $this->articleRepository->save($this->articleFactory->create(
            $command->getUserId(),
            $command->getTitle(),
            $command->getBody(),
            $tags,
        ));
        return new CreateArticleResult($article);
    }

    /**
     * @param DeleteArticleCommand $command
     * @throws ForbiddenException|DomainRecordNotFoundException
     */
    public function delete(DeleteArticleCommand $command)
    {
        $article = $this->articleRepository->findById($command->getArticleId());
        if ($article->getUserId() !== $command->getUserId()) {
            throw new ForbiddenException();
        }
    }

    /**
     * @param GetArticleQuery $query
     * @return Article
     * @throws DomainRecordNotFoundException
     */
    public function get(GetArticleQuery $query): Article
    {
        return $this->articleRepository->findById($query->getId());
    }

    /**
     * @return Article[]
     */
    public function getArticlesOrderByLatest(): array
    {
        return $this->articleRepository->getAllByLatest();
    }

    /**
     * @param UpdateArticleCommand $command
     * @return UpdateArticleResult
     * @throws DomainRecordNotFoundException
     * @throws ForbiddenException
     * @throws Exception
     */
    public function update(UpdateArticleCommand $command): UpdateArticleResult
    {
        $article = $this->articleRepository->findById($command->getArticleId());
        if ($article->getUserId() !== $command->getUserId()) {
            throw new ForbiddenException();
        }
        $tags = $this->tagRepository->findByNames($command->getTags());
        $names = array_map(fn(Tag $tag) => $tag->getName(), $tags);
        foreach ($command->getTags() as $name) {
            if (!in_array($name, $names, true)) {
                $tags[] = $this->tagRepository->save(new Tag(null, new Name($name)));
            }
        }
        $article = $this->articleRepository->save(new Article(
            $command->getArticleId(),
            $command->getUserId(),
            new Title($command->getTitle()),
            new Body($command->getBody()),
            $tags,
            $article->getDatetime(),
        ));
        $article = $this->articleRepository->save($article);
        return new UpdateArticleResult($article);
    }
}