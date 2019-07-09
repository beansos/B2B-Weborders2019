<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190207094454 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE products ADD batch DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE order_items RENAME INDEX idx_52ea1f09fcdaeaaa TO IDX_62809DB0FCDAEAAA');
        $this->addSql('ALTER TABLE order_items RENAME INDEX idx_52ea1f09de18e50b TO IDX_62809DB0DE18E50B');
        $this->addSql('ALTER TABLE orderItems RENAME INDEX idx_f52993989d86650f TO IDX_E52FFDEE9D86650F');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE order_items RENAME INDEX idx_62809db0de18e50b TO IDX_52EA1F09DE18E50B');
        $this->addSql('ALTER TABLE order_items RENAME INDEX idx_62809db0fcdaeaaa TO IDX_52EA1F09FCDAEAAA');
        $this->addSql('ALTER TABLE orderItems RENAME INDEX idx_e52ffdee9d86650f TO IDX_F52993989D86650F');
        $this->addSql('ALTER TABLE products DROP batch');
    }
}
