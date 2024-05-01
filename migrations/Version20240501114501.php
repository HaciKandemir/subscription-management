<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240501114501 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE access_token (id INT AUTO_INCREMENT NOT NULL, device_id INT NOT NULL, app_id INT NOT NULL, subscription_id INT DEFAULT NULL, token VARCHAR(255) NOT NULL, INDEX IDX_B6A2DD6894A4C7D4 (device_id), INDEX IDX_B6A2DD687987212D (app_id), UNIQUE INDEX UNIQ_B6A2DD689A1887DC (subscription_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE access_token ADD CONSTRAINT FK_B6A2DD6894A4C7D4 FOREIGN KEY (device_id) REFERENCES device (id)');
        $this->addSql('ALTER TABLE access_token ADD CONSTRAINT FK_B6A2DD687987212D FOREIGN KEY (app_id) REFERENCES app (id)');
        $this->addSql('ALTER TABLE access_token ADD CONSTRAINT FK_B6A2DD689A1887DC FOREIGN KEY (subscription_id) REFERENCES subscription (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE access_token DROP FOREIGN KEY FK_B6A2DD6894A4C7D4');
        $this->addSql('ALTER TABLE access_token DROP FOREIGN KEY FK_B6A2DD687987212D');
        $this->addSql('ALTER TABLE access_token DROP FOREIGN KEY FK_B6A2DD689A1887DC');
        $this->addSql('DROP TABLE access_token');
    }
}
