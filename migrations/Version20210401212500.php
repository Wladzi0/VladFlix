<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210401212500 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE time_data (id INT AUTO_INCREMENT NOT NULL, is_finished TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE time_data_profile (time_data_id INT NOT NULL, profile_id INT NOT NULL, INDEX IDX_3C5495266372005A (time_data_id), INDEX IDX_3C549526CCFA12B8 (profile_id), PRIMARY KEY(time_data_id, profile_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE time_data_file (time_data_id INT NOT NULL, file_id INT NOT NULL, INDEX IDX_A5A6F62A6372005A (time_data_id), INDEX IDX_A5A6F62A93CB796C (file_id), PRIMARY KEY(time_data_id, file_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE time_data_profile ADD CONSTRAINT FK_3C5495266372005A FOREIGN KEY (time_data_id) REFERENCES time_data (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE time_data_profile ADD CONSTRAINT FK_3C549526CCFA12B8 FOREIGN KEY (profile_id) REFERENCES profile (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE time_data_file ADD CONSTRAINT FK_A5A6F62A6372005A FOREIGN KEY (time_data_id) REFERENCES time_data (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE time_data_file ADD CONSTRAINT FK_A5A6F62A93CB796C FOREIGN KEY (file_id) REFERENCES file (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE time_data_profile DROP FOREIGN KEY FK_3C5495266372005A');
        $this->addSql('ALTER TABLE time_data_file DROP FOREIGN KEY FK_A5A6F62A6372005A');
        $this->addSql('DROP TABLE time_data');
        $this->addSql('DROP TABLE time_data_profile');
        $this->addSql('DROP TABLE time_data_file');
    }
}
