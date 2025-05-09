<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250508145550 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE Comments DROP FOREIGN KEY FK_A6E8F47C9D86650F
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE FeedPosts DROP FOREIGN KEY FK_16DF8C1171F7E88B
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE FeedPosts DROP FOREIGN KEY FK_16DF8C11A76ED395
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE GroupMembers DROP FOREIGN KEY FK_B8990FC89D86650F
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE GroupMembers DROP FOREIGN KEY FK_B8990FC82F68B530
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE Likes DROP FOREIGN KEY FK_880B61799D86650F
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE Shares DROP FOREIGN KEY Shares_ibfk_2
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE UserGroups DROP FOREIGN KEY FK_D0662852F05788E9
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE applications DROP FOREIGN KEY FK_F7C966F09D86650F
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE conversion DROP FOREIGN KEY FK_BD9127449D86650F
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE events DROP FOREIGN KEY FK_5387574AE78C696A
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE events DROP FOREIGN KEY FK_5387574A9777D11E
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE historique_points DROP FOREIGN KEY FK_EEF82E759D86650F
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE jobs DROP FOREIGN KEY FK_8A1C2FB3E5F2F7B
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE jobs DROP FOREIGN KEY FK_A8936DC59D86650F
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE participation_events DROP FOREIGN KEY FK_29E2D16F9D6A1065
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE participation_events DROP FOREIGN KEY FK_29E2D16F6ACE3B73
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE participation_users DROP FOREIGN KEY FK_1B5F28626ACE3B73
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE participation_users DROP FOREIGN KEY FK_1B5F286267B3B43D
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reviews DROP FOREIGN KEY FK_6970EB0F9D86650F
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reviews DROP FOREIGN KEY FK_6970EB0F3E5F2F7B
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE roulette DROP FOREIGN KEY FK_D80F9D2E9D86650F
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user_profile DROP FOREIGN KEY FK_D95AB405A76ED395
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE Comments
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE FeedPosts
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE GroupFeedPosts
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE GroupMembers
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE Likes
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE Messages
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE Shares
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE UserFollowers
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE UserGroups
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE UserIntrests
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE VisiteUtilisateur
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE applications
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE category
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE conversion
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE events
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE historique_points
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE jobs
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE participation
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE participation_events
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE participation_users
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE reviews
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE rewards
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE roulette
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE transaction_argent
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE user_profile
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE user_rewards
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE users
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE worker_raitings
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE Comments (id INT AUTO_INCREMENT NOT NULL, user_id_id INT NOT NULL, post_id INT NOT NULL, content VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_0900_ai_ci`, is_deleted INT DEFAULT NULL, time_stamp VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_0900_ai_ci`, INDEX IDX_A6E8F47C9D86650F (user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_0900_ai_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE FeedPosts (post_id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, event_id INT DEFAULT NULL, content VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, timestamp VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, is_deleted INT DEFAULT NULL, created_at VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, updated_at VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, score_popularite INT DEFAULT NULL, image_path VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, group_id INT DEFAULT NULL, INDEX IDX_16DF8C1171F7E88B (event_id), INDEX IDX_16DF8C11A76ED395 (user_id), PRIMARY KEY(post_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE GroupFeedPosts (post_id INT AUTO_INCREMENT NOT NULL, group_id INT NOT NULL, user_id INT NOT NULL, content VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, timestamp VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, media_url VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, is_deleted INT DEFAULT NULL, INDEX IDX_FC4BFDD6A76ED395 (user_id), INDEX IDX_FC4BFDD6FE54D947 (group_id), PRIMARY KEY(post_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE GroupMembers (id INT AUTO_INCREMENT NOT NULL, group_id_id INT NOT NULL, user_id_id INT NOT NULL, role VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_B8990FC82F68B530 (group_id_id), INDEX IDX_B8990FC89D86650F (user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE Likes (id INT AUTO_INCREMENT NOT NULL, user_id_id INT NOT NULL, post_id INT NOT NULL, time_stamp VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_0900_ai_ci`, INDEX IDX_880B61799D86650F (user_id_id), INDEX IDX_880B61794B89032C (post_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_0900_ai_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE Messages (message_id INT AUTO_INCREMENT NOT NULL, sender_id INT NOT NULL, recipient_id INT NOT NULL, content VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_0900_ai_ci`, timestamp DATETIME NOT NULL, type VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_0900_ai_ci`, read_status INT NOT NULL, PRIMARY KEY(message_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_0900_ai_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE Shares (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, post_id INT DEFAULT NULL, created_at DATETIME DEFAULT NULL, INDEX IDX_97F3744AA76ED395 (user_id), INDEX IDX_97F3744A4B89032C (post_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_0900_ai_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE UserFollowers (id INT AUTO_INCREMENT NOT NULL, follower_id INT NOT NULL, followed_id INT NOT NULL, created_at VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, status VARCHAR(20) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_7BCA9591D956F010 (followed_id), INDEX IDX_7BCA9591AC24F853 (follower_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE UserGroups (group_id INT AUTO_INCREMENT NOT NULL, creator_id_id INT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, description VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, profile_picture LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, rules VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, created_at VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_D0662852F05788E9 (creator_id_id), PRIMARY KEY(group_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE UserIntrests (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, category_id INT DEFAULT NULL, INDEX IDX_77BCA4AC12469DE2 (category_id), INDEX IDX_77BCA4ACA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE VisiteUtilisateur (id INT AUTO_INCREMENT NOT NULL, dernier_visite DATE NOT NULL, serie INT NOT NULL, user_id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE applications (id INT AUTO_INCREMENT NOT NULL, user_id_id INT DEFAULT NULL, job_id_id INT DEFAULT NULL, status VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, applied_at DATETIME DEFAULT NULL, rewarded INT DEFAULT NULL, cover_letter VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, resume_path VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, cover_rating INT DEFAULT NULL, INDEX IDX_F7C966F07E182327 (job_id_id), INDEX IDX_F7C966F09D86650F (user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE conversion (id INT AUTO_INCREMENT NOT NULL, user_id_id INT NOT NULL, points_convertis INT NOT NULL, montant NUMERIC(10, 2) NOT NULL, devise VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, date DATETIME NOT NULL, INDEX IDX_BD9127449D86650F (user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE events (id INT AUTO_INCREMENT NOT NULL, organizer_id_id INT NOT NULL, category_id_id INT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, description VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, start_time VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, end_time VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, location VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, image LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, points INT NOT NULL, INDEX IDX_5387574A9777D11E (category_id_id), INDEX IDX_5387574AE78C696A (organizer_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE historique_points (id INT AUTO_INCREMENT NOT NULL, user_id_id INT NOT NULL, type VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, points INT NOT NULL, raison VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, date DATETIME NOT NULL, INDEX IDX_EEF82E759D86650F (user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE jobs (id INT AUTO_INCREMENT NOT NULL, user_id_id INT DEFAULT NULL, event_id_id INT DEFAULT NULL, job_title VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, event_title VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, job_location VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, employment_type VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, application_dead_line VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, min_salary INT NOT NULL, max_salary INT NOT NULL, currency VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, job_descreption VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, recruiter_name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, recruiter_email VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, created_at VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_8A1C2FB3E5F2F7B (event_id_id), INDEX IDX_8A1C2FB9D86650F (user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE participation (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE participation_events (participation_id INT NOT NULL, events_id INT NOT NULL, INDEX IDX_29E2D16F6ACE3B73 (participation_id), INDEX IDX_29E2D16F9D6A1065 (events_id), PRIMARY KEY(participation_id, events_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE participation_users (participation_id INT NOT NULL, users_id INT NOT NULL, INDEX IDX_1B5F286267B3B43D (users_id), INDEX IDX_1B5F28626ACE3B73 (participation_id), PRIMARY KEY(participation_id, users_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE reviews (id INT AUTO_INCREMENT NOT NULL, user_id_id INT NOT NULL, event_id_id INT NOT NULL, rating INT NOT NULL, comment VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, creatid_at VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_6970EB0F3E5F2F7B (event_id_id), INDEX IDX_6970EB0F9D86650F (user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE rewards (id INT AUTO_INCREMENT NOT NULL, action_type VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, points INT NOT NULL, description VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE roulette (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, points_gagnes INT NOT NULL, date DATETIME NOT NULL, INDEX IDX_D80F9D2E9D86650F (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE transaction_argent (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE user_profile (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, bio VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, profile_picture VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, intrests VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, UNIQUE INDEX UNIQ_D95AB405A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE user_rewards (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, reward_id INT NOT NULL, event_id INT NOT NULL, points_earned INT NOT NULL, erned_at VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, password VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, email VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, created_at VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, updated_at VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, points INT DEFAULT NULL, age INT NOT NULL, gender VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, argent NUMERIC(10, 2) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE worker_raitings (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, rater_id INT NOT NULL, job_id INT NOT NULL, raiting INT NOT NULL, comment LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, created_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE Comments ADD CONSTRAINT FK_A6E8F47C9D86650F FOREIGN KEY (user_id_id) REFERENCES users (id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE FeedPosts ADD CONSTRAINT FK_16DF8C1171F7E88B FOREIGN KEY (event_id) REFERENCES events (id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE FeedPosts ADD CONSTRAINT FK_16DF8C11A76ED395 FOREIGN KEY (user_id) REFERENCES users (id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE GroupMembers ADD CONSTRAINT FK_B8990FC89D86650F FOREIGN KEY (user_id_id) REFERENCES users (id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE GroupMembers ADD CONSTRAINT FK_B8990FC82F68B530 FOREIGN KEY (group_id_id) REFERENCES UserGroups (group_id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE Likes ADD CONSTRAINT FK_880B61799D86650F FOREIGN KEY (user_id_id) REFERENCES users (id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE Shares ADD CONSTRAINT Shares_ibfk_2 FOREIGN KEY (user_id) REFERENCES users (id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE UserGroups ADD CONSTRAINT FK_D0662852F05788E9 FOREIGN KEY (creator_id_id) REFERENCES users (id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE applications ADD CONSTRAINT FK_F7C966F09D86650F FOREIGN KEY (user_id_id) REFERENCES users (id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE conversion ADD CONSTRAINT FK_BD9127449D86650F FOREIGN KEY (user_id_id) REFERENCES users (id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE events ADD CONSTRAINT FK_5387574AE78C696A FOREIGN KEY (organizer_id_id) REFERENCES users (id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE events ADD CONSTRAINT FK_5387574A9777D11E FOREIGN KEY (category_id_id) REFERENCES category (id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE historique_points ADD CONSTRAINT FK_EEF82E759D86650F FOREIGN KEY (user_id_id) REFERENCES users (id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE jobs ADD CONSTRAINT FK_8A1C2FB3E5F2F7B FOREIGN KEY (event_id_id) REFERENCES events (id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE jobs ADD CONSTRAINT FK_A8936DC59D86650F FOREIGN KEY (user_id_id) REFERENCES users (id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE participation_events ADD CONSTRAINT FK_29E2D16F9D6A1065 FOREIGN KEY (events_id) REFERENCES events (id) ON UPDATE NO ACTION ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE participation_events ADD CONSTRAINT FK_29E2D16F6ACE3B73 FOREIGN KEY (participation_id) REFERENCES participation (id) ON UPDATE NO ACTION ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE participation_users ADD CONSTRAINT FK_1B5F28626ACE3B73 FOREIGN KEY (participation_id) REFERENCES participation (id) ON UPDATE NO ACTION ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE participation_users ADD CONSTRAINT FK_1B5F286267B3B43D FOREIGN KEY (users_id) REFERENCES users (id) ON UPDATE NO ACTION ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reviews ADD CONSTRAINT FK_6970EB0F9D86650F FOREIGN KEY (user_id_id) REFERENCES users (id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reviews ADD CONSTRAINT FK_6970EB0F3E5F2F7B FOREIGN KEY (event_id_id) REFERENCES events (id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE roulette ADD CONSTRAINT FK_D80F9D2E9D86650F FOREIGN KEY (user_id) REFERENCES users (id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user_profile ADD CONSTRAINT FK_D95AB405A76ED395 FOREIGN KEY (user_id) REFERENCES users (id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
    }
}
