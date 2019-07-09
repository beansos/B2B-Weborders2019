<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190124100305 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE admins (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, surname VARCHAR(255) NOT NULL, enterprise VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE products (id INT AUTO_INCREMENT NOT NULL,sku VARCHAR(60) NOT NULL, name VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, weight DOUBLE PRECISION DEFAULT NULL, tax DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `orderItems` (id INT AUTO_INCREMENT NOT NULL, user_id_id INT NOT NULL, total_excluding_tax DOUBLE PRECISION NOT NULL, total_tax DOUBLE PRECISION NOT NULL, total_weight DOUBLE PRECISION DEFAULT NULL, creation_date DATETIME NOT NULL, frequency INT DEFAULT NULL, delivery_date DATETIME NOT NULL, status INT NOT NULL, INDEX IDX_F52993989D86650F (user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE order_items (id INT AUTO_INCREMENT NOT NULL, order_id_id INT NOT NULL, product_id_id INT NOT NULL, sku VARCHAR(60) NOT NULL, quantity INT NOT NULL, price DOUBLE PRECISION NOT NULL, weight DOUBLE PRECISION DEFAULT NULL, tax DOUBLE PRECISION NOT NULL, INDEX IDX_52EA1F09FCDAEAAA (order_id_id), INDEX IDX_52EA1F09DE18E50B (product_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE `orderItems` ADD CONSTRAINT FK_F52993989D86650F FOREIGN KEY (user_id_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE order_items ADD CONSTRAINT FK_52EA1F09FCDAEAAA FOREIGN KEY (order_id_id) REFERENCES `orderItems` (id)');
        $this->addSql('ALTER TABLE order_items ADD CONSTRAINT FK_52EA1F09DE18E50B FOREIGN KEY (product_id_id) REFERENCES products (id)');

    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE admins');
        $this->addSql('DROP TABLE products');
        $this->addSql('ALTER TABLE order_items DROP FOREIGN KEY FK_52EA1F09FCDAEAAA');
        $this->addSql('ALTER TABLE `orderItems` DROP FOREIGN KEY FK_F52993989D86650F');
        $this->addSql('DROP TABLE `orderItems`');
        $this->addSql('DROP TABLE order_items');
        $this->addSql('DROP TABLE users');
    }
}
