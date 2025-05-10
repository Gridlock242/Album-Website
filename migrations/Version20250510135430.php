<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250510135430 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE album DROP INDEX UNIQ_39986E4349ABEB17, ADD INDEX IDX_39986E4349ABEB17 (band_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE band CHANGE biography biography VARCHAR(255) DEFAULT NULL
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE album DROP INDEX IDX_39986E4349ABEB17, ADD UNIQUE INDEX UNIQ_39986E4349ABEB17 (band_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE band CHANGE biography biography VARCHAR(255) NOT NULL
        SQL);
    }
}
