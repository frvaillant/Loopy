<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200624155833 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE award (id INT AUTO_INCREMENT NOT NULL, patient_id INT NOT NULL, badge_id INT NOT NULL, obtained_at DATETIME NOT NULL, INDEX IDX_8A5B2EE76B899279 (patient_id), INDEX IDX_8A5B2EE7F7A2C2FC (badge_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE badge (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(100) NOT NULL, image LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE data (id INT AUTO_INCREMENT NOT NULL, patient_id INT NOT NULL, data_category_id INT NOT NULL, value INT NOT NULL, added_at DATETIME NOT NULL, INDEX IDX_ADF3F3636B899279 (patient_id), INDEX IDX_ADF3F363ED86C2A8 (data_category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE data_category (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE doctor (id INT AUTO_INCREMENT NOT NULL, surname VARCHAR(50) NOT NULL, first_name VARCHAR(50) NOT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE patient (id INT AUTO_INCREMENT NOT NULL, doctor_id INT NOT NULL, surname VARCHAR(50) NOT NULL, first_name VARCHAR(50) NOT NULL, birthday DATE NOT NULL, weight INT NOT NULL, limit_up INT NOT NULL, limit_down INT NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_1ADAD7EB87F4FB17 (doctor_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE award ADD CONSTRAINT FK_8A5B2EE76B899279 FOREIGN KEY (patient_id) REFERENCES patient (id)');
        $this->addSql('ALTER TABLE award ADD CONSTRAINT FK_8A5B2EE7F7A2C2FC FOREIGN KEY (badge_id) REFERENCES badge (id)');
        $this->addSql('ALTER TABLE data ADD CONSTRAINT FK_ADF3F3636B899279 FOREIGN KEY (patient_id) REFERENCES patient (id)');
        $this->addSql('ALTER TABLE data ADD CONSTRAINT FK_ADF3F363ED86C2A8 FOREIGN KEY (data_category_id) REFERENCES data_category (id)');
        $this->addSql('ALTER TABLE patient ADD CONSTRAINT FK_1ADAD7EB87F4FB17 FOREIGN KEY (doctor_id) REFERENCES doctor (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE award DROP FOREIGN KEY FK_8A5B2EE7F7A2C2FC');
        $this->addSql('ALTER TABLE data DROP FOREIGN KEY FK_ADF3F363ED86C2A8');
        $this->addSql('ALTER TABLE patient DROP FOREIGN KEY FK_1ADAD7EB87F4FB17');
        $this->addSql('ALTER TABLE award DROP FOREIGN KEY FK_8A5B2EE76B899279');
        $this->addSql('ALTER TABLE data DROP FOREIGN KEY FK_ADF3F3636B899279');
        $this->addSql('DROP TABLE award');
        $this->addSql('DROP TABLE badge');
        $this->addSql('DROP TABLE data');
        $this->addSql('DROP TABLE data_category');
        $this->addSql('DROP TABLE doctor');
        $this->addSql('DROP TABLE patient');
    }
}
