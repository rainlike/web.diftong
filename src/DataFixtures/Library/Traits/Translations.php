<?php
declare(strict_types=1);

namespace App\DataFixtures\Library\Traits;

use Doctrine\Common\Persistence\ObjectManager;

use App\Entity\Library\Interfaces\ITranslatable;

/**
 * Trait Translations
 *
 * @package App\DataFixtures\Library\Traits
 */
trait Translations
{
    /**
     * Save Translations
     *
     * @param array $translations
     * @param ITranslatable $entity
     * @param ObjectManager $manager
     */
    private function saveTranslations(
        array $translations,
        ITranslatable $entity,
        ObjectManager $manager
    ): void
    {
        foreach ($translations as $translationName => $targetTranslations) {
            foreach ($targetTranslations as $locale => $translation) {
                $setterName = $this->mapping($translationName) ?: $translationName;

                $setter = 'set'.\ucfirst($setterName);

                $entity->setTranslatableLocale($locale);
                $entity->$setter($translation);
                $manager->persist($entity);
                $manager->flush();
            }
        }
    }
}
