<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200624164010 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE drug (id INT AUTO_INCREMENT NOT NULL, recurrence_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_43EB7A3E2C414CE8 (recurrence_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE images (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, path VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recurrence (id INT AUTO_INCREMENT NOT NULL, morning INT NOT NULL, noon INT NOT NULL, evening INT NOT NULL, start DATETIME NOT NULL, end DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE totem (id INT AUTO_INCREMENT NOT NULL, image_id INT DEFAULT NULL, name VARCHAR(50) NOT NULL, score INT NOT NULL, UNIQUE INDEX UNIQ_D14414CC3DA5256D (image_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE treatment (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE treatment_recurrence (treatment_id INT NOT NULL, recurrence_id INT NOT NULL, INDEX IDX_CC94F34471C0366 (treatment_id), INDEX IDX_CC94F342C414CE8 (recurrence_id), PRIMARY KEY(treatment_id, recurrence_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, totem_id INT DEFAULT NULL, treatment_id INT DEFAULT NULL, email VARCHAR(100) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', password VARCHAR(255) NOT NULL, name VARCHAR(50) NOT NULL, lastname VARCHAR(50) NOT NULL, sex VARCHAR(255) NOT NULL, birth_date DATE DEFAULT NULL, score INT DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), UNIQUE INDEX UNIQ_8D93D649A1EBF819 (totem_id), UNIQUE INDEX UNIQ_8D93D649471C0366 (treatment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE drug ADD CONSTRAINT FK_43EB7A3E2C414CE8 FOREIGN KEY (recurrence_id) REFERENCES recurrence (id)');
        $this->addSql('ALTER TABLE totem ADD CONSTRAINT FK_D14414CC3DA5256D FOREIGN KEY (image_id) REFERENCES images (id)');
        $this->addSql('ALTER TABLE treatment_recurrence ADD CONSTRAINT FK_CC94F34471C0366 FOREIGN KEY (treatment_id) REFERENCES treatment (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE treatment_recurrence ADD CONSTRAINT FK_CC94F342C414CE8 FOREIGN KEY (recurrence_id) REFERENCES recurrence (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649A1EBF819 FOREIGN KEY (totem_id) REFERENCES totem (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649471C0366 FOREIGN KEY (treatment_id) REFERENCES treatment (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE totem DROP FOREIGN KEY FK_D14414CC3DA5256D');
        $this->addSql('ALTER TABLE drug DROP FOREIGN KEY FK_43EB7A3E2C414CE8');
        $this->addSql('ALTER TABLE treatment_recurrence DROP FOREIGN KEY FK_CC94F342C414CE8');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649A1EBF819');
        $this->addSql('ALTER TABLE treatment_recurrence DROP FOREIGN KEY FK_CC94F34471C0366');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649471C0366');
        $this->addSql('DROP TABLE drug');
        $this->addSql('DROP TABLE images');
        $this->addSql('DROP TABLE recurrence');
        $this->addSql('DROP TABLE totem');
        $this->addSql('DROP TABLE treatment');
        $this->addSql('DROP TABLE treatment_recurrence');
        $this->addSql('DROP TABLE user');
    }
}
