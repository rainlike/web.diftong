<?php
declare(strict_types=1);

namespace App\Helper;

use Symfony\Component\Translation\Exception\InvalidArgumentException;

use Symfony\Component\Translation\TranslatorInterface as Translator;

use Doctrine\ORM\EntityManagerInterface as EntityManager;

use Gedmo\Translatable\TranslatableListener;

/**
 * Class TranslationHelper
 *
 * @package App\Helper
 * @author Alexander Saveliev <alex@spbcrew.com>
 */
class TranslationHelper
{
    /** @var EntityManager */
    private $em;

    /** @var Translator */
    private $translator;

    /**
     * TranslationHelper constructor
     *
     * @param EntityManager $em
     * @param Translator $translator
     */
    public function __construct(EntityManager $em, Translator $translator)
    {
        $this->em = $em;
        $this->translator = $translator;
    }

    /**
     * Set locale for Gedmo Translatable Listener
     *
     * @param string $locale
     * @return void
     * @throws InvalidArgumentException
     */
    public function setLocaleForTranslatableListener(string $locale): void
    {
        $this->translator->setLocale($locale);

        foreach ($this->em->getEventManager()->getListeners() as $listeners) {
            /** @var array $listeners */
            foreach ($listeners as $key => $listener) {
                if ($listener instanceof TranslatableListener) {
                    $listener->setTranslatableLocale($locale);
                }
            }
        }
    }
}
