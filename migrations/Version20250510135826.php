<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250510135826 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE genre (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE genre_band (genre_id INT NOT NULL, band_id INT NOT NULL, INDEX IDX_F3327B1B4296D31F (genre_id), INDEX IDX_F3327B1B49ABEB17 (band_id), PRIMARY KEY(genre_id, band_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE genre_album (genre_id INT NOT NULL, album_id INT NOT NULL, INDEX IDX_849E71864296D31F (genre_id), INDEX IDX_849E71861137ABCF (album_id), PRIMARY KEY(genre_id, album_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE genre_band ADD CONSTRAINT FK_F3327B1B4296D31F FOREIGN KEY (genre_id) REFERENCES genre (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE genre_band ADD CONSTRAINT FK_F3327B1B49ABEB17 FOREIGN KEY (band_id) REFERENCES band (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE genre_album ADD CONSTRAINT FK_849E71864296D31F FOREIGN KEY (genre_id) REFERENCES genre (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE genre_album ADD CONSTRAINT FK_849E71861137ABCF FOREIGN KEY (album_id) REFERENCES album (id) ON DELETE CASCADE
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE genre_band DROP FOREIGN KEY FK_F3327B1B4296D31F
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE genre_band DROP FOREIGN KEY FK_F3327B1B49ABEB17
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE genre_album DROP FOREIGN KEY FK_849E71864296D31F
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE genre_album DROP FOREIGN KEY FK_849E71861137ABCF
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE genre
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE genre_band
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE genre_album
        SQL);
    }
}
