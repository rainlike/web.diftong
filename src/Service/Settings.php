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

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface as TokenStorage;

use Doctrine\ORM\EntityManagerInterface as EntityManager;

use App\Service\Logger;

use App\Entity\User;
use App\Entity\ValueType;
use App\Entity\SiteSetting;
use App\Entity\UserSetting;

use App\Repository\ValueTypeRepository;

/** Class Settings */
class Settings
{
    /** @var TokenStorage */
    private $token_storage;

    /** @var EntityManager */
    private $em;

    /** @var Transformer */
    private $transformer;

    /** @var Logger */
    private $logger;

    /**
     * Name of log file for this service
     * @var string
     */
    public const LOG_FILE_NAME = 'settings.log';

    /**
     * Was set User
     * @var User
     */
    private $user;

    /**
     * Settings constructor
     *
     * @param TokenStorage $token_storage
     * @param EntityManager $em
     * @param Transformer $transformer
     * @param Logger $logger
     */
    public function __construct(
        TokenStorage $token_storage,
        EntityManager $em,
        Transformer $transformer,
        Logger $logger
    ) {
        $this->token_storage = $token_storage;
        $this->em = $em;
        $this->transformer = $transformer;
        $this->logger = $logger;

        $this->presetLogger();
    }

    /**
     * Settings destructor
     */
    public function __destruct()
    {
        $this->resetUser();
    }

    /**
     * Set user
     *
     * @param User $user
     * @return self
     */
    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get setting
     *
     * @param string $name
     * @param User|null $user
     * @param bool $onlyEnabled
     * @return mixed|null
     * @throws NonUniqueResultException
     */
    public function getSetting(string $name, ?User $user = null, bool $onlyEnabled = true)
    {
        if ($user) {
            $this->setUser($user);
        }

        /** @var ValueTypeRepository */
        $repository = $this->em->getRepository(ValueType::class);

        /** @var ValueType $valueType */
        $valueType = $onlyEnabled
            ? $repository->findEnabled('name', $name)
            : $repository->find(['name' => $name]);
        if (!$valueType) {
            /** @TODO: use Notifier here */
            $logMessage = 'Value type was not found.';
            $this->logger->logMessage($logMessage, Logger::TYPE_WARNING);

            return null;
        }

        $priority = $valueType->getPriority();

        $getter = (!$priority || !\in_array($priority, ValueType::PRIORITIES))
            ? 'getSiteSetting'
            : 'get'.\ucfirst($priority).'Setting';

        return $this->$getter($name, $onlyEnabled);
    }

    /**
     * Get site setting
     * -- called in getSetting() method
     *
     * @param string $name
     * @param bool $onlyEnabled
     * @return mixed|null
     * @throws NonUniqueResultException
     */
    private function getSiteSetting(string $name, bool $onlyEnabled = true)
    {
        $settingRepository = $this->em->getRepository(SiteSetting::class);

        if (!\method_exists($settingRepository, 'getSettingRecord')) {
            return null;
        }

        $setting = $settingRepository->getSettingRecord($name, $onlyEnabled);
        if (!$setting) {
            /** @TODO: use Notifier here */
            $logMessage = 'Site setting was not found.';
            $this->logger->logMessage($logMessage, Logger::TYPE_WARNING);

            return null;
        }

        $value = $setting->getValue();
        $type = $setting->getType()->getType();

        return $this->transformer->transform($value, $type);
    }

    /**
     * Get user setting
     * -- called in getSetting() method
     *
     * @param string $name
     * @param bool $onlyEnabled
     * @return mixed|null
     * @throws NonUniqueResultException
     */
    private function getUserSetting(string $name, bool $onlyEnabled = true)
    {
        $settingRepository = $this->em->getRepository(UserSetting::class);

        if (!\method_exists($settingRepository, 'getSettingRecord')) {
            return null;
        }

        $user = $user ?? $this->token_storage->getToken()->getUser();

        if (!$user || $user === User::USER_ANON) {
            return $this->getSiteSetting($name, $onlyEnabled);
        }

        /** @var User $user */
        $setting = $settingRepository->getSettingRecord($name, $user, $onlyEnabled);
        if (!$setting) {
            /** @TODO: use Notifier here */
            $logMessage = 'User setting was not found.';
            $this->logger->logMessage($logMessage, Logger::TYPE_WARNING);

            return null;
        }

        $value = $setting->getValue();
        $type = $setting->getType()->getType();

        return $this->transformer->transform($value, $type);
    }

    /**
     * Preset Logger settings
     *
     * @return void
     */
    private function presetLogger(): void
    {
        $this->logger->setFileName(self::LOG_FILE_NAME);
    }

    /**
     * Reset current user
     *
     * @return void
     */
    private function resetUser(): void
    {
        $this->user = null;
    }
}
