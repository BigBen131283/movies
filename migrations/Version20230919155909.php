<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230919155909 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE movies_user (movies_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_DE9A798353F590A4 (movies_id), INDEX IDX_DE9A7983A76ED395 (user_id), PRIMARY KEY(movies_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE movies_user ADD CONSTRAINT FK_DE9A798353F590A4 FOREIGN KEY (movies_id) REFERENCES movies (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE movies_user ADD CONSTRAINT FK_DE9A7983A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE movies_user DROP FOREIGN KEY FK_DE9A798353F590A4');
        $this->addSql('ALTER TABLE movies_user DROP FOREIGN KEY FK_DE9A7983A76ED395');
        $this->addSql('DROP TABLE movies_user');
    }
}
