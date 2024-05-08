<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240507100244 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vegetable ADD siewing_month_start VARCHAR(255) NOT NULL, ADD harvest_month_start VARCHAR(255) NOT NULL, ADD siewing_month_end VARCHAR(255) NOT NULL, ADD harvest_month_end VARCHAR(255) NOT NULL, ADD seedling_planting_month VARCHAR(255) NOT NULL, ADD seedling_move_to_ground_month VARCHAR(255) NOT NULL, DROP siewing_month, DROP harvest_month');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vegetable ADD siewing_month VARCHAR(255) NOT NULL, ADD harvest_month VARCHAR(255) NOT NULL, DROP siewing_month_start, DROP harvest_month_start, DROP siewing_month_end, DROP harvest_month_end, DROP seedling_planting_month, DROP seedling_move_to_ground_month');
    }
}
