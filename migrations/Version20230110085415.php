<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230110085415 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_tutoriel (user_id INT NOT NULL, tutoriel_id INT NOT NULL, INDEX IDX_428ADEEDA76ED395 (user_id), INDEX IDX_428ADEED7CB6CDBB (tutoriel_id), PRIMARY KEY(user_id, tutoriel_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_tutoriel ADD CONSTRAINT FK_428ADEEDA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_tutoriel ADD CONSTRAINT FK_428ADEED7CB6CDBB FOREIGN KEY (tutoriel_id) REFERENCES tutoriel (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_tutoriel DROP FOREIGN KEY FK_428ADEEDA76ED395');
        $this->addSql('ALTER TABLE user_tutoriel DROP FOREIGN KEY FK_428ADEED7CB6CDBB');
        $this->addSql('DROP TABLE user_tutoriel');
    }
}
