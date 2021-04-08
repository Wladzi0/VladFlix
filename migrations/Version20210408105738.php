<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210408105738 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category_film (category_id INT NOT NULL, film_id INT NOT NULL, INDEX IDX_9DFC46512469DE2 (category_id), INDEX IDX_9DFC465567F5183 (film_id), PRIMARY KEY(category_id, film_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category_serial (category_id INT NOT NULL, serial_id INT NOT NULL, INDEX IDX_DC9C03A712469DE2 (category_id), INDEX IDX_DC9C03A7AF82D095 (serial_id), PRIMARY KEY(category_id, serial_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE episode (id INT AUTO_INCREMENT NOT NULL, season_id INT DEFAULT NULL, file_id INT NOT NULL, name VARCHAR(255) NOT NULL, year DATE NOT NULL, INDEX IDX_DDAA1CDA4EC001D1 (season_id), UNIQUE INDEX UNIQ_DDAA1CDA93CB796C (file_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE file (id INT AUTO_INCREMENT NOT NULL, path VARCHAR(255) NOT NULL, subtitle LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', audio LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE film (id INT AUTO_INCREMENT NOT NULL, file_id INT NOT NULL, name VARCHAR(255) NOT NULL, country VARCHAR(255) NOT NULL, year DATE NOT NULL, age_category TINYINT(1) DEFAULT NULL, UNIQUE INDEX UNIQ_8244BE2293CB796C (file_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE profile (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, nickname VARCHAR(255) NOT NULL, background_color VARCHAR(50) NOT NULL, age TINYINT(1) DEFAULT NULL, profile_pin VARCHAR(4) DEFAULT NULL, interface_language VARCHAR(255) DEFAULT NULL, preferred_language VARCHAR(20) DEFAULT NULL, preferred_audio VARCHAR(20) DEFAULT NULL, INDEX IDX_8157AA0FA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE season (id INT AUTO_INCREMENT NOT NULL, serial_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, year DATE NOT NULL, INDEX IDX_F0E45BA9AF82D095 (serial_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE serial (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, country VARCHAR(255) NOT NULL, year_start DATE NOT NULL, year_finish DATE DEFAULT NULL, age_category TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE time_data (id INT AUTO_INCREMENT NOT NULL, is_finished TINYINT(1) NOT NULL, cur_time VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE time_data_profile (time_data_id INT NOT NULL, profile_id INT NOT NULL, INDEX IDX_3C5495266372005A (time_data_id), INDEX IDX_3C549526CCFA12B8 (profile_id), PRIMARY KEY(time_data_id, profile_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE time_data_file (time_data_id INT NOT NULL, file_id INT NOT NULL, INDEX IDX_A5A6F62A6372005A (time_data_id), INDEX IDX_A5A6F62A93CB796C (file_id), PRIMARY KEY(time_data_id, file_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, is_verified TINYINT(1) NOT NULL, pin VARCHAR(4) NOT NULL, default_language VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE category_film ADD CONSTRAINT FK_9DFC46512469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE category_film ADD CONSTRAINT FK_9DFC465567F5183 FOREIGN KEY (film_id) REFERENCES film (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE category_serial ADD CONSTRAINT FK_DC9C03A712469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE category_serial ADD CONSTRAINT FK_DC9C03A7AF82D095 FOREIGN KEY (serial_id) REFERENCES serial (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE episode ADD CONSTRAINT FK_DDAA1CDA4EC001D1 FOREIGN KEY (season_id) REFERENCES season (id)');
        $this->addSql('ALTER TABLE episode ADD CONSTRAINT FK_DDAA1CDA93CB796C FOREIGN KEY (file_id) REFERENCES file (id)');
        $this->addSql('ALTER TABLE film ADD CONSTRAINT FK_8244BE2293CB796C FOREIGN KEY (file_id) REFERENCES file (id)');
        $this->addSql('ALTER TABLE profile ADD CONSTRAINT FK_8157AA0FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE season ADD CONSTRAINT FK_F0E45BA9AF82D095 FOREIGN KEY (serial_id) REFERENCES serial (id)');
        $this->addSql('ALTER TABLE time_data_profile ADD CONSTRAINT FK_3C5495266372005A FOREIGN KEY (time_data_id) REFERENCES time_data (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE time_data_profile ADD CONSTRAINT FK_3C549526CCFA12B8 FOREIGN KEY (profile_id) REFERENCES profile (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE time_data_file ADD CONSTRAINT FK_A5A6F62A6372005A FOREIGN KEY (time_data_id) REFERENCES time_data (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE time_data_file ADD CONSTRAINT FK_A5A6F62A93CB796C FOREIGN KEY (file_id) REFERENCES file (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category_film DROP FOREIGN KEY FK_9DFC46512469DE2');
        $this->addSql('ALTER TABLE category_serial DROP FOREIGN KEY FK_DC9C03A712469DE2');
        $this->addSql('ALTER TABLE episode DROP FOREIGN KEY FK_DDAA1CDA93CB796C');
        $this->addSql('ALTER TABLE film DROP FOREIGN KEY FK_8244BE2293CB796C');
        $this->addSql('ALTER TABLE time_data_file DROP FOREIGN KEY FK_A5A6F62A93CB796C');
        $this->addSql('ALTER TABLE category_film DROP FOREIGN KEY FK_9DFC465567F5183');
        $this->addSql('ALTER TABLE time_data_profile DROP FOREIGN KEY FK_3C549526CCFA12B8');
        $this->addSql('ALTER TABLE episode DROP FOREIGN KEY FK_DDAA1CDA4EC001D1');
        $this->addSql('ALTER TABLE category_serial DROP FOREIGN KEY FK_DC9C03A7AF82D095');
        $this->addSql('ALTER TABLE season DROP FOREIGN KEY FK_F0E45BA9AF82D095');
        $this->addSql('ALTER TABLE time_data_profile DROP FOREIGN KEY FK_3C5495266372005A');
        $this->addSql('ALTER TABLE time_data_file DROP FOREIGN KEY FK_A5A6F62A6372005A');
        $this->addSql('ALTER TABLE profile DROP FOREIGN KEY FK_8157AA0FA76ED395');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE category_film');
        $this->addSql('DROP TABLE category_serial');
        $this->addSql('DROP TABLE episode');
        $this->addSql('DROP TABLE file');
        $this->addSql('DROP TABLE film');
        $this->addSql('DROP TABLE profile');
        $this->addSql('DROP TABLE season');
        $this->addSql('DROP TABLE serial');
        $this->addSql('DROP TABLE time_data');
        $this->addSql('DROP TABLE time_data_profile');
        $this->addSql('DROP TABLE time_data_file');
        $this->addSql('DROP TABLE user');
    }
}
