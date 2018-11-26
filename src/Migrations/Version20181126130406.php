<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181126130406 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE comment CHANGE user_id user_id BIGINT DEFAULT NULL, CHANGE item_id item_id BIGINT DEFAULT NULL');
        $this->addSql('ALTER TABLE item CHANGE user_id user_id BIGINT DEFAULT NULL, CHANGE status_id status_id BIGINT DEFAULT NULL, CHANGE county_id county_id BIGINT DEFAULT NULL, CHANGE category_id category_id BIGINT DEFAULT NULL, CHANGE created_at created_at DATETIME DEFAULT NULL, CHANGE updated_at updated_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE pm CHANGE user_to user_to BIGINT DEFAULT NULL, CHANGE user_from user_from BIGINT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\'');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE comment CHANGE item_id item_id BIGINT NOT NULL, CHANGE user_id user_id BIGINT NOT NULL');
        $this->addSql('ALTER TABLE item CHANGE category_id category_id BIGINT NOT NULL, CHANGE county_id county_id BIGINT NOT NULL, CHANGE status_id status_id BIGINT NOT NULL, CHANGE user_id user_id BIGINT NOT NULL, CHANGE created_at created_at DATETIME NOT NULL, CHANGE updated_at updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE pm CHANGE user_to user_to BIGINT NOT NULL, CHANGE user_from user_from BIGINT NOT NULL');
        $this->addSql('ALTER TABLE user DROP roles');
    }
}
