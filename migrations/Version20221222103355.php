<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221222103355 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE commmantaire (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, produit_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, message LONGTEXT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_D2CEC72EA76ED395 (user_id), INDEX IDX_D2CEC72EF347EFB (produit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE commmantaire ADD CONSTRAINT FK_D2CEC72EA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE commmantaire ADD CONSTRAINT FK_D2CEC72EF347EFB FOREIGN KEY (produit_id) REFERENCES product (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commmantaire DROP FOREIGN KEY FK_D2CEC72EA76ED395');
        $this->addSql('ALTER TABLE commmantaire DROP FOREIGN KEY FK_D2CEC72EF347EFB');
        $this->addSql('DROP TABLE commmantaire');
    }
}
