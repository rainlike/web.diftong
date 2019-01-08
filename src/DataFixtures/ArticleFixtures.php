<?php
declare(strict_types=1);

namespace App\DataFixtures;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use Doctrine\Bundle\FixturesBundle\Fixture;

use App\Entity\Article;

/**
 * Class ArticleFixtures
 *
 * @package App\DataFixtures
 * @author Alexander Saveliev <alex@spbcrew.com>
 */
class ArticleFixtures extends Fixture implements OrderedFixtureInterface
{
    /**
     * List of preset articles
     * @var array
     */
    private static $articles = [
        [
            'title' => 'Типичные ошибки при изучении английского языка',
            'uri' => 'common-mistakes',
            'description' => 'В статье рассматриваются наиболее распространенные ошибки и заблуждения, связанные с процессом изучения английского языка. Вы узнаете на какие детали стоит обратить особое внимание и как сделать обучение более эффективным.',
            'content' => 'Изучение английского языка – не настолько сложная и невыполнимая задача, как может показаться на первый взгляд. Для того чтобы добиться желаемого успеха, необходимо правильно организовать рабочий процесс и постараться избегать распространенных ошибок. В данной статье мы рассмотрим причины, по которым даже наиболее старательные люди не достигают хороших результатов.',
            'formatted_content' => 'Изучение английского языка – не настолько сложная и невыполнимая задача, как может показаться на первый взгляд. Для того чтобы добиться желаемого успеха, необходимо правильно организовать рабочий процесс и постараться избегать распространенных ошибок. В данной статье мы рассмотрим причины, по которым даже наиболее старательные люди не достигают хороших результатов. (<b>@FORMATTED_CONTENT</b>)',
            'language' => 'ru',
            'portal' => 'english',
        ]
    ];

    /**
     * Load fixtures
     *
     * @param ObjectManager
     * @return void
     * @throws \BadMethodCallException
     */
    public function load(ObjectManager $manager): void
    {
        $now = new \DateTime();

        foreach (self::$articles as $article) {
            $entity = new Article();
            $entity->setTitle($article['title']);
            $entity->setUri($article['uri']);
            $entity->setDescription($article['description']);
            $entity->setContent($article['content']);
            $entity->setFormattedContent($article['formatted_content']);

            $entity->setLanguage($this->getReference('language-'.\strtolower($article['language'])));
            $entity->setPortal($this->getReference('portal-'.\strtolower($article['portal'])));

            $entity->setEnabled(true);
            $entity->setCreated($now);
            $entity->setUpdated($now);

            $manager->persist($entity);

            $this->addReference('article-'.\str_replace('_', '-', $article['title']), $entity);
        }

        $manager->flush();
    }

    /**
     * Get fixture order
     *
     * @return int
     */
    public function getOrder(): int
    {
        return 2;
    }
}
