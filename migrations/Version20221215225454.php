<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221215225454 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE answer (id INT AUTO_INCREMENT NOT NULL, question_id INT DEFAULT NULL, content LONGTEXT DEFAULT NULL, iscorrect TINYINT(1) NOT NULL, INDEX IDX_DADD4A251E27F6BF (question_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, tutoriel_id INT DEFAULT NULL, user_id INT DEFAULT NULL, text LONGTEXT DEFAULT NULL, INDEX IDX_9474526C7CB6CDBB (tutoriel_id), INDEX IDX_9474526CA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE favori (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, tutoriel_id INT DEFAULT NULL, INDEX IDX_EF85A2CCA76ED395 (user_id), INDEX IDX_EF85A2CC7CB6CDBB (tutoriel_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game (id INT AUTO_INCREMENT NOT NULL, tutoriel_id INT DEFAULT NULL, user_id INT DEFAULT NULL, created_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_232B318C7CB6CDBB (tutoriel_id), INDEX IDX_232B318CA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game_answer (id INT AUTO_INCREMENT NOT NULL, game_id INT DEFAULT NULL, answer_id INT DEFAULT NULL, question_id INT DEFAULT NULL, INDEX IDX_A7E8E7EDE48FD905 (game_id), INDEX IDX_A7E8E7EDAA334807 (answer_id), INDEX IDX_A7E8E7ED1E27F6BF (question_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE level (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE question (id INT AUTO_INCREMENT NOT NULL, tutoriel_id INT DEFAULT NULL, content LONGTEXT DEFAULT NULL, INDEX IDX_B6F7494E7CB6CDBB (tutoriel_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ticket (id INT AUTO_INCREMENT NOT NULL, tutoriel_id INT DEFAULT NULL, user_id INT DEFAULT NULL, content LONGTEXT DEFAULT NULL, INDEX IDX_97A0ADA37CB6CDBB (tutoriel_id), INDEX IDX_97A0ADA3A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tutoriel (id INT AUTO_INCREMENT NOT NULL, level_id INT DEFAULT NULL, category_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, content LONGTEXT DEFAULT NULL, INDEX IDX_A2073AED5FB14BA7 (level_id), INDEX IDX_A2073AED12469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, avatar VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE answer ADD CONSTRAINT FK_DADD4A251E27F6BF FOREIGN KEY (question_id) REFERENCES question (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C7CB6CDBB FOREIGN KEY (tutoriel_id) REFERENCES tutoriel (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE favori ADD CONSTRAINT FK_EF85A2CCA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE favori ADD CONSTRAINT FK_EF85A2CC7CB6CDBB FOREIGN KEY (tutoriel_id) REFERENCES tutoriel (id)');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318C7CB6CDBB FOREIGN KEY (tutoriel_id) REFERENCES tutoriel (id)');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE game_answer ADD CONSTRAINT FK_A7E8E7EDE48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
        $this->addSql('ALTER TABLE game_answer ADD CONSTRAINT FK_A7E8E7EDAA334807 FOREIGN KEY (answer_id) REFERENCES answer (id)');
        $this->addSql('ALTER TABLE game_answer ADD CONSTRAINT FK_A7E8E7ED1E27F6BF FOREIGN KEY (question_id) REFERENCES question (id)');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT FK_B6F7494E7CB6CDBB FOREIGN KEY (tutoriel_id) REFERENCES tutoriel (id)');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA37CB6CDBB FOREIGN KEY (tutoriel_id) REFERENCES tutoriel (id)');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA3A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE tutoriel ADD CONSTRAINT FK_A2073AED5FB14BA7 FOREIGN KEY (level_id) REFERENCES level (id)');
        $this->addSql('ALTER TABLE tutoriel ADD CONSTRAINT FK_A2073AED12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE answer DROP FOREIGN KEY FK_DADD4A251E27F6BF');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C7CB6CDBB');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CA76ED395');
        $this->addSql('ALTER TABLE favori DROP FOREIGN KEY FK_EF85A2CCA76ED395');
        $this->addSql('ALTER TABLE favori DROP FOREIGN KEY FK_EF85A2CC7CB6CDBB');
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318C7CB6CDBB');
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318CA76ED395');
        $this->addSql('ALTER TABLE game_answer DROP FOREIGN KEY FK_A7E8E7EDE48FD905');
        $this->addSql('ALTER TABLE game_answer DROP FOREIGN KEY FK_A7E8E7EDAA334807');
        $this->addSql('ALTER TABLE game_answer DROP FOREIGN KEY FK_A7E8E7ED1E27F6BF');
        $this->addSql('ALTER TABLE question DROP FOREIGN KEY FK_B6F7494E7CB6CDBB');
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA37CB6CDBB');
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA3A76ED395');
        $this->addSql('ALTER TABLE tutoriel DROP FOREIGN KEY FK_A2073AED5FB14BA7');
        $this->addSql('ALTER TABLE tutoriel DROP FOREIGN KEY FK_A2073AED12469DE2');
        $this->addSql('DROP TABLE answer');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE favori');
        $this->addSql('DROP TABLE game');
        $this->addSql('DROP TABLE game_answer');
        $this->addSql('DROP TABLE level');
        $this->addSql('DROP TABLE question');
        $this->addSql('DROP TABLE ticket');
        $this->addSql('DROP TABLE tutoriel');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
