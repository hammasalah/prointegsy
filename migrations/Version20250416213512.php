<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250416213512 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Convertir created_at de VARCHAR en DATETIME en nettoyant d’abord les valeurs invalides';
    }

    public function up(Schema $schema): void
    {
        // 1) Nettoyer les valeurs invalides ('today', 'null', chaîne vide, ou NULL)
        $this->addSql(<<<'SQL'
            UPDATE jobs
            SET created_at = NOW()
            WHERE LOWER(created_at) IN ('today', 'null', '')
               OR created_at IS NULL
        SQL);

        // 2) Modifier le type de la colonne en DATETIME, autoriser NULL
        $this->addSql(<<<'SQL'
            ALTER TABLE jobs
            CHANGE created_at created_at DATETIME DEFAULT NULL
        SQL);
    }

    public function down(Schema $schema): void
    {
        // Revenir à VARCHAR(255) si nécessaire
        $this->addSql(<<<'SQL'
            ALTER TABLE jobs
            CHANGE created_at created_at VARCHAR(255) DEFAULT NULL
        SQL);
    }
}