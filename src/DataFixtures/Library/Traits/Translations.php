<?php
declare(strict_types=1);

namespace App\DataFixtures\Library\Traits;

use Doctrine\Common\Persistence\ObjectManager;

use App\Entity\Library\Interfaces\ITranslatable;

use App\Service\Library;

/**
 * Trait Translations
 *
 * @package App\DataFixtures\Library\Traits
 */
trait Translations
{
    /**
     * Save all translations
     *
     * @param array $translations
     * @param ITranslatable $entity
     * @param ObjectManager $manager
     */
    private function saveAllTranslations(
        array $translations,
        ITranslatable $entity,
        ObjectManager $manager
    ): void
    {
        foreach ($translations as $field => $fieldTranslations) {
            foreach ($fieldTranslations as $locale => $translation) {
                $setter = 'set'.\ucfirst(Library::snakeToCamelCase($field));

                $entity->setTranslatableLocale($locale);
                $entity->$setter($translation);
                $manager->persist($entity);
                $manager->flush();
                $manager->refresh($entity);
            }
        }
    }

    /**
     * Save translations for one field
     *
     * @param string $field
     * @param array $translations
     * @param ITranslatable $entity
     * @param ObjectManager $manager
     */
    private function saveTranslations(
        string $field,
        array $translations,
        ITranslatable $entity,
        ObjectManager $manager
    ): void
    {
        foreach ($translations as $locale => $translation) {
            $setter = 'set'.\ucfirst(Library::snakeToCamelCase($field));

            $entity->setTranslatableLocale($locale);
            $entity->$setter($translation);
            $manager->persist($entity);
            $manager->flush();
            $manager->refresh($entity);
        }
    }

    /**
     * Save translation
     *
     * @param string $field
     * @param string $locale
     * @param string $translation
     * @param ITranslatable $entity
     * @param ObjectManager $manager
     */
    private function saveTranslation(
        string $field,
        string $locale,
        string $translation,
        ITranslatable $entity,
        ObjectManager $manager
    ): void
    {
        $setter = 'set'.\ucfirst(Library::snakeToCamelCase($field));

        $entity->setTranslatableLocale($locale);
        $entity->$setter($translation);
        $manager->persist($entity);
        $manager->flush();
        $manager->refresh($entity);
    }
}
