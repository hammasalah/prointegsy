<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250516172552 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE Likes ADD CONSTRAINT FK_49CA4E7DE85F12B8 FOREIGN KEY (post_id_id) REFERENCES feed_posts (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_49CA4E7DE85F12B8 ON Likes (post_id_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE Likes RENAME INDEX idx_880b61799d86650f TO IDX_49CA4E7D9D86650F
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE messages DROP FOREIGN KEY FK_DB021E96F624B39D
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE messages DROP FOREIGN KEY FK_DB021E96E92F8F78
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_DB021E96F624B39D ON messages
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_DB021E96E92F8F78 ON messages
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE participation ADD event_id INT DEFAULT NULL, ADD participant_id INT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE participation ADD CONSTRAINT FK_AB55E24F71F7E88B FOREIGN KEY (event_id) REFERENCES events (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE participation ADD CONSTRAINT FK_AB55E24F9D1C3019 FOREIGN KEY (participant_id) REFERENCES users (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_AB55E24F71F7E88B ON participation (event_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_AB55E24F9D1C3019 ON participation (participant_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE Shares DROP FOREIGN KEY FK_97F3744AA76ED395
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_97F3744A4B89032C ON Shares
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_97F3744AA76ED395 ON Shares
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE Shares ADD user_id_id INT DEFAULT NULL, DROP user_id, CHANGE post_id post_id_id INT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE Shares ADD CONSTRAINT FK_905F717CE85F12B8 FOREIGN KEY (post_id_id) REFERENCES feed_posts (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE Shares ADD CONSTRAINT FK_905F717C9D86650F FOREIGN KEY (user_id_id) REFERENCES users (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_905F717CE85F12B8 ON Shares (post_id_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_905F717C9D86650F ON Shares (user_id_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user_groups CHANGE profile_picture profile_picture LONGTEXT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE visite_utilisateur CHANGE user_id user_id INT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE visite_utilisateur RENAME INDEX fk_xxxxxxx TO IDX_A8D52305A76ED395
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE likes DROP FOREIGN KEY FK_49CA4E7DE85F12B8
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_49CA4E7DE85F12B8 ON likes
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE likes RENAME INDEX idx_49ca4e7d9d86650f TO IDX_880B61799D86650F
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE shares DROP FOREIGN KEY FK_905F717CE85F12B8
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE shares DROP FOREIGN KEY FK_905F717C9D86650F
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_905F717CE85F12B8 ON shares
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_905F717C9D86650F ON shares
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE shares ADD user_id INT NOT NULL, ADD post_id INT DEFAULT NULL, DROP post_id_id, DROP user_id_id
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE shares ADD CONSTRAINT FK_97F3744AA76ED395 FOREIGN KEY (user_id) REFERENCES users (id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_97F3744A4B89032C ON shares (post_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_97F3744AA76ED395 ON shares (user_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE messages ADD CONSTRAINT FK_DB021E96F624B39D FOREIGN KEY (sender_id) REFERENCES users (id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE messages ADD CONSTRAINT FK_DB021E96E92F8F78 FOREIGN KEY (recipient_id) REFERENCES users (id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_DB021E96F624B39D ON messages (sender_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_DB021E96E92F8F78 ON messages (recipient_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE participation DROP FOREIGN KEY FK_AB55E24F71F7E88B
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE participation DROP FOREIGN KEY FK_AB55E24F9D1C3019
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_AB55E24F71F7E88B ON participation
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_AB55E24F9D1C3019 ON participation
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE participation DROP event_id, DROP participant_id
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user_groups CHANGE profile_picture profile_picture LONGTEXT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE visite_utilisateur CHANGE user_id user_id INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE visite_utilisateur RENAME INDEX idx_a8d52305a76ed395 TO FK_XXXXXXX
        SQL);
    }
}
