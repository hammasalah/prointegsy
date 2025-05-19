<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250512184625 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Suppression de toutes les tables existantes pour permettre une réinitialisation complète de la base de données';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        // Désactiver les contraintes de clé étrangère temporairement
        $this->addSql('SET FOREIGN_KEY_CHECKS=0');
        
        // Utilisation de DROP TABLE IF EXISTS pour toutes les tables
        $this->addSql(<<<'SQL'
            DROP TABLE IF EXISTS applications, category, chat_message, chat_participant, comments, conversation, 
            conversion, events, feed_posts, group_feed_posts, group_members, historique_points, jobs, likes, messages, notification, 
            participation, participation_events, participation_users, reviews, rewards, roulette, shares, 
            transaction_argent, user_groups, user_interests, user_intrests, user_messages, user_profile, user_rewards, users, visite_utilisateur, worker_raitings
        SQL);
        
        // Réactiver les contraintes de clé étrangère
        $this->addSql('SET FOREIGN_KEY_CHECKS=1');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        // Les instructions de restauration ont été commentées car les tables n'existent plus
        // et seront recréées par d'autres migrations si nécessaire
    }
}
