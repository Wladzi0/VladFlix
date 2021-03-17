<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210316094745 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE profile CHANGE interface_language interface_language VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE default_language default_language VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE profile CHANGE interface_language interface_language TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE default_language default_language TINYINT(1) NOT NULL');
    }
}
