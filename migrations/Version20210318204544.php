<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210318204544 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category_serial (category_id INT NOT NULL, serial_id INT NOT NULL, INDEX IDX_DC9C03A712469DE2 (category_id), INDEX IDX_DC9C03A7AF82D095 (serial_id), PRIMARY KEY(category_id, serial_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE category_serial ADD CONSTRAINT FK_DC9C03A712469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE category_serial ADD CONSTRAINT FK_DC9C03A7AF82D095 FOREIGN KEY (serial_id) REFERENCES serial (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE category_serial');
    }
}
