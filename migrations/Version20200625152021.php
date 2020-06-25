<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200625152021 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE patient ADD dad_surname VARCHAR(50) DEFAULT NULL, ADD dad_first_name VARCHAR(50) DEFAULT NULL, ADD dad_phone_number VARCHAR(50) DEFAULT NULL, ADD mom_surname VARCHAR(50) DEFAULT NULL, ADD mom_first_name VARCHAR(50) DEFAULT NULL, ADD mom_phone_number VARCHAR(50) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE patient DROP dad_surname, DROP dad_first_name, DROP dad_phone_number, DROP mom_surname, DROP mom_first_name, DROP mom_phone_number');
    }
}
