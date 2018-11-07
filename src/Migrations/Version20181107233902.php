<?php
declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Migrations\AbortMigrationException;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Class Version20181107233902
 *
 * Add next theory item for `Verb` record (hardcoded)
 * @package DoctrineMigrations
 * @author Alexander Saveliev <alex@spbcrew.com>
 */
class Version20181107233902 extends AbstractMigration
{
    /**
     * Apply migration
     *
     * @param Schema $schema
     * @return void
     * @throws DBALException
     * @throws AbortMigrationException
     */
    public function up(Schema $schema): void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('UPDATE app_theory SET app_theory.next_id = 4 WHERE app_theory.id = 2');
    }

    /**
     * Reverse migration
     *
     * @param Schema $schema
     * @return void
     * @throws DBALException
     * @throws AbortMigrationException
     */
    public function down(Schema $schema): void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('UPDATE app_theory SET app_theory.next_id = NULL WHERE app_theory.id = 2');
    }
}
