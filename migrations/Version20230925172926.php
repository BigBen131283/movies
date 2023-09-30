<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230925172926 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE master (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE master_slave (master_id INT NOT NULL, slave_id INT NOT NULL, INDEX IDX_304DA3D813B3DB11 (master_id), INDEX IDX_304DA3D82B29BD08 (slave_id), PRIMARY KEY(master_id, slave_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE slave (id INT AUTO_INCREMENT NOT NULL, tool VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE master_slave ADD CONSTRAINT FK_304DA3D813B3DB11 FOREIGN KEY (master_id) REFERENCES master (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE master_slave ADD CONSTRAINT FK_304DA3D82B29BD08 FOREIGN KEY (slave_id) REFERENCES slave (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE master_slave DROP FOREIGN KEY FK_304DA3D813B3DB11');
        $this->addSql('ALTER TABLE master_slave DROP FOREIGN KEY FK_304DA3D82B29BD08');
        $this->addSql('DROP TABLE master');
        $this->addSql('DROP TABLE master_slave');
        $this->addSql('DROP TABLE slave');
    }
}
