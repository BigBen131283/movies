<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230929230651 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_movies (user_id INT NOT NULL, movies_id INT NOT NULL, INDEX IDX_A34CF60DA76ED395 (user_id), INDEX IDX_A34CF60D53F590A4 (movies_id), PRIMARY KEY(user_id, movies_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_movies ADD CONSTRAINT FK_A34CF60DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_movies ADD CONSTRAINT FK_A34CF60D53F590A4 FOREIGN KEY (movies_id) REFERENCES movies (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE movies_spectator DROP FOREIGN KEY FK_7C2DD93453F590A4');
        $this->addSql('ALTER TABLE movies_spectator DROP FOREIGN KEY FK_7C2DD934523FB688');
        $this->addSql('ALTER TABLE movies_user DROP FOREIGN KEY FK_DE9A798353F590A4');
        $this->addSql('ALTER TABLE movies_user DROP FOREIGN KEY FK_DE9A7983A76ED395');
        $this->addSql('DROP TABLE spectator');
        $this->addSql('DROP TABLE movies_spectator');
        $this->addSql('DROP TABLE movies_user');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE spectator (id INT AUTO_INCREMENT NOT NULL, pseudo VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, password VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, roles JSON CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE movies_spectator (movies_id INT NOT NULL, spectator_id INT NOT NULL, INDEX IDX_7C2DD93453F590A4 (movies_id), INDEX IDX_7C2DD934523FB688 (spectator_id), PRIMARY KEY(movies_id, spectator_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE movies_user (movies_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_DE9A7983A76ED395 (user_id), INDEX IDX_DE9A798353F590A4 (movies_id), PRIMARY KEY(movies_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE movies_spectator ADD CONSTRAINT FK_7C2DD93453F590A4 FOREIGN KEY (movies_id) REFERENCES movies (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE movies_spectator ADD CONSTRAINT FK_7C2DD934523FB688 FOREIGN KEY (spectator_id) REFERENCES spectator (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE movies_user ADD CONSTRAINT FK_DE9A798353F590A4 FOREIGN KEY (movies_id) REFERENCES movies (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE movies_user ADD CONSTRAINT FK_DE9A7983A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_movies DROP FOREIGN KEY FK_A34CF60DA76ED395');
        $this->addSql('ALTER TABLE user_movies DROP FOREIGN KEY FK_A34CF60D53F590A4');
        $this->addSql('DROP TABLE user_movies');
    }
}
