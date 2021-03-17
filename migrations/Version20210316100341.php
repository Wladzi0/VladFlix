<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210316100341 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE episode DROP file');
        $this->addSql('ALTER TABLE file ADD film_id INT NOT NULL');
        $this->addSql('ALTER TABLE file ADD CONSTRAINT FK_8C9F3610567F5183 FOREIGN KEY (film_id) REFERENCES film (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8C9F3610567F5183 ON file (film_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE episode ADD file VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE file DROP FOREIGN KEY FK_8C9F3610567F5183');
        $this->addSql('DROP INDEX UNIQ_8C9F3610567F5183 ON file');
        $this->addSql('ALTER TABLE file DROP film_id');
    }
}
