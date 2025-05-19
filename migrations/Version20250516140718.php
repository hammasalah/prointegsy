<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250516140718 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE Comments DROP FOREIGN KEY FK_A6E8F47C4B89032C
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE Likes DROP FOREIGN KEY FK_880B61794B89032C
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE Shares DROP FOREIGN KEY FK_97F3744A4B89032C
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE feed_posts (id INT AUTO_INCREMENT NOT NULL, user_id_id INT NOT NULL, event_id_id INT NOT NULL, content VARCHAR(255) NOT NULL, time_stamp VARCHAR(255) NOT NULL, is_deleted INT DEFAULT NULL, created_at VARCHAR(255) NOT NULL, updated_at VARCHAR(255) NOT NULL, score_popularite INT DEFAULT NULL, image_path VARCHAR(255) NOT NULL, group_id INT DEFAULT NULL, INDEX IDX_7DD2E9469D86650F (user_id_id), INDEX IDX_7DD2E9463E5F2F7B (event_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE group_feed_posts (id INT AUTO_INCREMENT NOT NULL, group_id_id INT NOT NULL, user_id_id INT NOT NULL, content VARCHAR(255) NOT NULL, timestamp VARCHAR(255) NOT NULL, media_url VARCHAR(255) NOT NULL, is_deleted INT DEFAULT NULL, INDEX IDX_AA1F88F42F68B530 (group_id_id), INDEX IDX_AA1F88F49D86650F (user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE user_intrests (id INT AUTO_INCREMENT NOT NULL, user_id_id INT DEFAULT NULL, category_id_id INT DEFAULT NULL, INDEX IDX_5A3306759D86650F (user_id_id), INDEX IDX_5A3306759777D11E (category_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE user_messages (id INT AUTO_INCREMENT NOT NULL, user_id_id INT DEFAULT NULL, sent_at DATETIME DEFAULT NULL, last_message VARCHAR(255) DEFAULT NULL, username VARCHAR(255) NOT NULL, INDEX IDX_3B8FFA969D86650F (user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE visite_utilisateur (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, dernier_visite DATE NOT NULL, serie INT NOT NULL, INDEX IDX_A8D52305A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE feed_posts ADD CONSTRAINT FK_7DD2E9469D86650F FOREIGN KEY (user_id_id) REFERENCES users (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE feed_posts ADD CONSTRAINT FK_7DD2E9463E5F2F7B FOREIGN KEY (event_id_id) REFERENCES users (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE group_feed_posts ADD CONSTRAINT FK_AA1F88F42F68B530 FOREIGN KEY (group_id_id) REFERENCES user_groups (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE group_feed_posts ADD CONSTRAINT FK_AA1F88F49D86650F FOREIGN KEY (user_id_id) REFERENCES users (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user_intrests ADD CONSTRAINT FK_5A3306759D86650F FOREIGN KEY (user_id_id) REFERENCES users (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user_intrests ADD CONSTRAINT FK_5A3306759777D11E FOREIGN KEY (category_id_id) REFERENCES category (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user_messages ADD CONSTRAINT FK_3B8FFA969D86650F FOREIGN KEY (user_id_id) REFERENCES users (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE visite_utilisateur ADD CONSTRAINT FK_A8D52305A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE GroupFeedPosts DROP FOREIGN KEY FK_FC4BFDD6A76ED395
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE GroupFeedPosts DROP FOREIGN KEY FK_FC4BFDD6FE54D947
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE UserFollowers DROP FOREIGN KEY FK_7BCA9591D956F010
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE UserFollowers DROP FOREIGN KEY FK_7BCA9591AC24F853
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE chat_message DROP FOREIGN KEY FK_FAB3FC169AC0396
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE chat_message DROP FOREIGN KEY FK_FAB3FC16A76ED395
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE chat_participant DROP FOREIGN KEY FK_E8ED9C899AC0396
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE chat_participant DROP FOREIGN KEY FK_E8ED9C89A76ED395
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE notification DROP FOREIGN KEY FK_BF5476CAA76ED395
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE participation_events DROP FOREIGN KEY FK_29E2D16F6ACE3B73
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE participation_events DROP FOREIGN KEY FK_29E2D16F9D6A1065
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE participation_users DROP FOREIGN KEY FK_1B5F28626ACE3B73
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE participation_users DROP FOREIGN KEY FK_1B5F286267B3B43D
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE transaction_argent DROP FOREIGN KEY FK_C3FE89CEA76ED395
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user_interests DROP FOREIGN KEY FK_C854880E9777D11E
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user_interests DROP FOREIGN KEY FK_C854880E9D86650F
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE FeedPosts
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE GroupFeedPosts
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE UserFollowers
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE chat_message
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE chat_participant
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE conversation
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE notification
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE participation_events
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE participation_users
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE transaction_argent
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE user_interests
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE applications DROP FOREIGN KEY FK_Applications_Job
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE applications CHANGE applied_at applied_at VARCHAR(255) DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE applications ADD CONSTRAINT FK_F7C966F07E182327 FOREIGN KEY (job_id_id) REFERENCES jobs (id)
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_A6E8F47C4B89032C ON Comments
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE Comments CHANGE post_id post_id_id INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE Comments ADD CONSTRAINT FK_5F9E962AE85F12B8 FOREIGN KEY (post_id_id) REFERENCES feed_posts (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE Comments ADD CONSTRAINT FK_5F9E962A9D86650F FOREIGN KEY (user_id_id) REFERENCES users (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_5F9E962AE85F12B8 ON Comments (post_id_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE Comments RENAME INDEX idx_a6e8f47c9d86650f TO IDX_5F9E962A9D86650F
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_880B61794B89032C ON Likes
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE Likes CHANGE post_id post_id_id INT NOT NULL
        SQL);
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
            DROP INDEX IDX_DB021E96E92F8F78 ON messages
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_DB021E96F624B39D ON messages
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
            DROP INDEX IDX_97F3744AA76ED395 ON Shares
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_97F3744A4B89032C ON Shares
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
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE comments DROP FOREIGN KEY FK_5F9E962AE85F12B8
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE likes DROP FOREIGN KEY FK_49CA4E7DE85F12B8
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE shares DROP FOREIGN KEY FK_905F717CE85F12B8
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE FeedPosts (post_id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, event_id INT DEFAULT NULL, content VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, timestamp VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, is_deleted INT DEFAULT NULL, created_at VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, updated_at VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, score_popularite INT DEFAULT NULL, image_path VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, group_id INT DEFAULT NULL, INDEX IDX_16DF8C1171F7E88B (event_id), INDEX IDX_16DF8C11A76ED395 (user_id), PRIMARY KEY(post_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE GroupFeedPosts (post_id INT AUTO_INCREMENT NOT NULL, group_id INT NOT NULL, user_id INT NOT NULL, content VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, timestamp VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, media_url VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, is_deleted INT DEFAULT NULL, INDEX IDX_FC4BFDD6FE54D947 (group_id), INDEX IDX_FC4BFDD6A76ED395 (user_id), PRIMARY KEY(post_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE UserFollowers (id INT AUTO_INCREMENT NOT NULL, follower_id INT NOT NULL, followed_id INT NOT NULL, created_at VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, status VARCHAR(20) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_7BCA9591D956F010 (followed_id), INDEX IDX_7BCA9591AC24F853 (follower_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE chat_message (id INT AUTO_INCREMENT NOT NULL, conversation_id INT NOT NULL, user_id INT NOT NULL, content LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', is_deleted TINYINT(1) NOT NULL, INDEX IDX_FAB3FC16A76ED395 (user_id), INDEX IDX_FAB3FC169AC0396 (conversation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE chat_participant (id INT AUTO_INCREMENT NOT NULL, conversation_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_E8ED9C89A76ED395 (user_id), INDEX IDX_E8ED9C899AC0396 (conversation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE conversation (id INT AUTO_INCREMENT NOT NULL, last_message DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE notification (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, message VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, type VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, created_at VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, is_read TINYINT(1) NOT NULL, link VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_BF5476CAA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE participation_events (participation_id INT NOT NULL, events_id INT NOT NULL, INDEX IDX_29E2D16F9D6A1065 (events_id), INDEX IDX_29E2D16F6ACE3B73 (participation_id), PRIMARY KEY(participation_id, events_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE participation_users (participation_id INT NOT NULL, users_id INT NOT NULL, INDEX IDX_1B5F286267B3B43D (users_id), INDEX IDX_1B5F28626ACE3B73 (participation_id), PRIMARY KEY(participation_id, users_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE transaction_argent (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, type VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, montant NUMERIC(10, 2) NOT NULL, devise VARCHAR(3) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, date DATETIME NOT NULL, point_convertis NUMERIC(10, 2) DEFAULT NULL, INDEX IDX_C3FE89CEA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE user_interests (id INT AUTO_INCREMENT NOT NULL, user_id_id INT DEFAULT NULL, category_id_id INT DEFAULT NULL, INDEX IDX_C854880E9D86650F (user_id_id), INDEX IDX_C854880E9777D11E (category_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE GroupFeedPosts ADD CONSTRAINT FK_FC4BFDD6A76ED395 FOREIGN KEY (user_id) REFERENCES users (id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE GroupFeedPosts ADD CONSTRAINT FK_FC4BFDD6FE54D947 FOREIGN KEY (group_id) REFERENCES user_groups (id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE UserFollowers ADD CONSTRAINT FK_7BCA9591D956F010 FOREIGN KEY (followed_id) REFERENCES users (id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE UserFollowers ADD CONSTRAINT FK_7BCA9591AC24F853 FOREIGN KEY (follower_id) REFERENCES users (id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE chat_message ADD CONSTRAINT FK_FAB3FC169AC0396 FOREIGN KEY (conversation_id) REFERENCES conversation (id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE chat_message ADD CONSTRAINT FK_FAB3FC16A76ED395 FOREIGN KEY (user_id) REFERENCES users (id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE chat_participant ADD CONSTRAINT FK_E8ED9C899AC0396 FOREIGN KEY (conversation_id) REFERENCES conversation (id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE chat_participant ADD CONSTRAINT FK_E8ED9C89A76ED395 FOREIGN KEY (user_id) REFERENCES users (id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE notification ADD CONSTRAINT FK_BF5476CAA76ED395 FOREIGN KEY (user_id) REFERENCES users (id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE participation_events ADD CONSTRAINT FK_29E2D16F6ACE3B73 FOREIGN KEY (participation_id) REFERENCES participation (id) ON UPDATE NO ACTION ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE participation_events ADD CONSTRAINT FK_29E2D16F9D6A1065 FOREIGN KEY (events_id) REFERENCES events (id) ON UPDATE NO ACTION ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE participation_users ADD CONSTRAINT FK_1B5F28626ACE3B73 FOREIGN KEY (participation_id) REFERENCES participation (id) ON UPDATE NO ACTION ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE participation_users ADD CONSTRAINT FK_1B5F286267B3B43D FOREIGN KEY (users_id) REFERENCES users (id) ON UPDATE NO ACTION ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE transaction_argent ADD CONSTRAINT FK_C3FE89CEA76ED395 FOREIGN KEY (user_id) REFERENCES users (id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user_interests ADD CONSTRAINT FK_C854880E9777D11E FOREIGN KEY (category_id_id) REFERENCES category (id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user_interests ADD CONSTRAINT FK_C854880E9D86650F FOREIGN KEY (user_id_id) REFERENCES users (id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE feed_posts DROP FOREIGN KEY FK_7DD2E9469D86650F
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE feed_posts DROP FOREIGN KEY FK_7DD2E9463E5F2F7B
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE group_feed_posts DROP FOREIGN KEY FK_AA1F88F42F68B530
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE group_feed_posts DROP FOREIGN KEY FK_AA1F88F49D86650F
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user_intrests DROP FOREIGN KEY FK_5A3306759D86650F
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user_intrests DROP FOREIGN KEY FK_5A3306759777D11E
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user_messages DROP FOREIGN KEY FK_3B8FFA969D86650F
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE visite_utilisateur DROP FOREIGN KEY FK_A8D52305A76ED395
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE feed_posts
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE group_feed_posts
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE user_intrests
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE user_messages
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE visite_utilisateur
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE comments DROP FOREIGN KEY FK_5F9E962A9D86650F
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_5F9E962AE85F12B8 ON comments
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE comments CHANGE post_id_id post_id INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE comments ADD CONSTRAINT FK_A6E8F47C4B89032C FOREIGN KEY (post_id) REFERENCES FeedPosts (post_id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_A6E8F47C4B89032C ON comments (post_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE comments RENAME INDEX idx_5f9e962a9d86650f TO IDX_A6E8F47C9D86650F
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_49CA4E7DE85F12B8 ON likes
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE likes CHANGE post_id_id post_id INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE likes ADD CONSTRAINT FK_880B61794B89032C FOREIGN KEY (post_id) REFERENCES FeedPosts (post_id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_880B61794B89032C ON likes (post_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE likes RENAME INDEX idx_49ca4e7d9d86650f TO IDX_880B61799D86650F
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
            ALTER TABLE shares ADD post_id INT DEFAULT NULL, ADD user_id INT NOT NULL, DROP post_id_id, DROP user_id_id
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE shares ADD CONSTRAINT FK_97F3744A4B89032C FOREIGN KEY (post_id) REFERENCES FeedPosts (post_id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE shares ADD CONSTRAINT FK_97F3744AA76ED395 FOREIGN KEY (user_id) REFERENCES users (id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_97F3744AA76ED395 ON shares (user_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_97F3744A4B89032C ON shares (post_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE applications DROP FOREIGN KEY FK_F7C966F07E182327
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE applications CHANGE applied_at applied_at DATETIME DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE applications ADD CONSTRAINT FK_Applications_Job FOREIGN KEY (job_id_id) REFERENCES jobs (id) ON UPDATE NO ACTION ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE messages ADD CONSTRAINT FK_DB021E96F624B39D FOREIGN KEY (sender_id) REFERENCES users (id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE messages ADD CONSTRAINT FK_DB021E96E92F8F78 FOREIGN KEY (recipient_id) REFERENCES users (id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_DB021E96E92F8F78 ON messages (recipient_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_DB021E96F624B39D ON messages (sender_id)
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
    }
}
