<?php
/**
 * Settings Service
 * Provides methods for settings tuning
 *
 * @package App\Service
 * @version 1.0.0
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @copyright 2018 spbcrew.com (https://www.spbcrew.com)
 * @author Alexander Saveliev <alex@spbcrew.com>
 */
declare(strict_types=1);

namespace App\Service;

use Doctrine\ORM\NonUniqueResultException;

use Doctrine\ORM\EntityManagerInterface as EntityManager;

use App\Repository\Library\Interfaces\ISetting as ISettingRepository;

use App\Entity\ValueType;
use App\Entity\SiteSetting;

use App\Repository\ValueTypeRepository;

/** Class Settings */
class Settings
{
    /** @var EntityManager */
    private $em;

    /** @var Transformer */
    private $transformer;

    /**
     * Settings constructor
     *
     * @param EntityManager $em
     * @param Transformer $transformer
     */
    public function __construct(
        EntityManager $em,
        Transformer $transformer
    ) {
        $this->em = $em;
        $this->transformer = $transformer;
    }

    /**
     * Get setting
     *
     * @param string $name
     * @param bool $onlyEnabled
     * @return mixed|null
     * @throws NonUniqueResultException
     */
    public function getSetting(string $name, bool $onlyEnabled = true)
    {
        /** @var ValueTypeRepository */
        $repository = $this->em->getRepository(ValueType::class);

        /** @var ValueType $valueType */
        $valueType = $onlyEnabled
            ? $repository->findEnabled('name', $name)
            : $repository->find(['name' => $name]);
        if (!$valueType) {
            return null;
        }

        $priority = $valueType->getPriority();

        /** @var $settingRepository ISettingRepository */
        if (!$priority || !\in_array($priority, ValueType::PRIORITIES)) {
            $settingRepository = $this->em->getRepository(SiteSetting::class);
        } else {
            $settingRepositoryName = \ucfirst($priority).'Setting';
            $settingRepositoryClass = Library::entityPathByName($settingRepositoryName);
            $settingRepository = $this->em->getRepository($settingRepositoryClass);
        }

        if (!\method_exists($settingRepository, 'getSettingRecord')) {
            return null;
        }

        $setting = $settingRepository->getSettingRecord($name, $onlyEnabled);

        $value = $setting->getValue();
        $type = $setting->getType()->getType();

        return $this->transformer->transform($value, $type);
    }
}
