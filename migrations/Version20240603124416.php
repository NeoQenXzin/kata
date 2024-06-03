<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240603124416 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE book ADD published_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT \'now()\' NOT NULL');
        $this->addSql('ALTER TABLE book ADD created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT \'now()\' NOT NULL');
        $this->addSql('ALTER TABLE book ADD updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('ALTER TABLE book ADD isbn VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE book ADD slug VARCHAR(255) DEFAULT NULL');
        $this->addSql('COMMENT ON COLUMN book.published_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN book.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN book.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_CBE5A331CC1CF4E6 ON book (isbn)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_CBE5A331989D9B62 ON book (slug)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP INDEX UNIQ_CBE5A331CC1CF4E6');
        $this->addSql('DROP INDEX UNIQ_CBE5A331989D9B62');
        $this->addSql('ALTER TABLE book DROP published_at');
        $this->addSql('ALTER TABLE book DROP created_at');
        $this->addSql('ALTER TABLE book DROP updated_at');
        $this->addSql('ALTER TABLE book DROP isbn');
        $this->addSql('ALTER TABLE book DROP slug');
    }
}
