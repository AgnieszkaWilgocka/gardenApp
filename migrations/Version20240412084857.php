<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240412084857 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vegetable ADD siewing_month VARCHAR(255) NOT NULL, ADD harvest_month VARCHAR(255) NOT NULL, DROP siewing_at, DROP harvest_at');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vegetable ADD siewing_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD harvest_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', DROP siewing_month, DROP harvest_month');
    }
}
