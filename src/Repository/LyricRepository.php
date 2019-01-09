<?php
declare(strict_types=1);

namespace App\Repository;

use Doctrine\DBAL\DBALException;

use Symfony\Bridge\Doctrine\RegistryInterface as Registry;

use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

use App\Entity\Lyric;
use App\Entity\Portal;
use App\Entity\Language;

use App\Repository\Library\Interfaces\IBasic;

use App\Repository\Library\Traits\Basic as BasicMethods;

/**
 * Class LyricRepository
 *
 * @package App\Repository
 * @author Alexander Saveliev <alex@spbcrew.com>
 * @method Lyric|null find($id, $lockMode = null, $lockVersion = null)
 * @method Lyric|null findOneBy(array $criteria, array $orderBy = null)
 * @method Lyric[]    findAll()
 * @method Lyric[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LyricRepository extends ServiceEntityRepository implements IBasic
{
    use BasicMethods;

    /**
     * LyricRepository constructor
     *
     * @param Registry $registry
     */
    public function __construct(Registry $registry)
    {
        parent::__construct($registry, Lyric::class);
    }

    /**
     * Check if at least one lyric exist for portal
     *
     * @param int $id
     * @return bool
     * @throws DBALException
     */
    public function existForPortal(int $id)
    {
        $em = $this->getEntityManager();
        $conn = $em->getConnection();

        $lyricTableName = $em->getClassMetadata(Lyric::class)->getTableName();
        $portalTableName = $em->getClassMetadata(Portal::class)->getTableName();

        $languageAssociation = $em->getClassMetadata(Lyric::class)
            ->getAssociationsByTargetClass(Language::class);
        $lyricsLanguagesTableName = $languageAssociation['languages']['joinTable']['name'];


        $sql = '
          SELECT lyric.id FROM '.$lyricTableName.' AS lyric
          INNER JOIN '.$portalTableName.' AS portal ON portal.id = :portal_id
          INNER JOIN '.$lyricsLanguagesTableName.' ll ON lyric.id = ll.lyric_id AND ll.language_id = portal.language
          LIMIT 1
        ';

        $stmt = $conn->prepare($sql);
        $stmt->execute(['portal_id' => $id]);

        return (bool)$stmt->fetch();
    }
}
