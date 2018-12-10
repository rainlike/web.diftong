<?php
/**
 * SettingList Command
 * Command for show list of settings
 *
 * @package App\Service
 * @version 1.0.0
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @copyright 2018 spbcrew.com (https://www.spbcrew.com)
 * @author Alexander Saveliev <alex@spbcrew.com>
 */
declare(strict_types=1);

namespace App\Command;

use Symfony\Component\Console\Command\Command;

use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Symfony\Component\Translation\TranslatorInterface as Translator;

use Doctrine\ORM\EntityManagerInterface as EntityManager;

use App\Entity\Library\Interfaces\ISetting;

use App\Command\Traits\TableTrait;
use App\Command\Traits\LocaleTrait;
use App\Command\Traits\WrapperTrait;

use App\Entity\User;
use App\Entity\ValueType;
use App\Entity\SiteSetting;
use App\Entity\UserSetting;

/** Class SettingList */
class SettingList extends Command
{
    use TableTrait;
    use LocaleTrait;
    use WrapperTrait;

    /** @var string */
    private const TRANS_PREFIX = 'setting_check';

    /**
     * Lazy loading
     * @var string
     */
    protected static $defaultName = 'app:setting:check';

    /** @var EntityManager */
    private $em;

    /** @var Translator */
    private $translator;

    /**
     * Specified user
     * @var User
     */
    private $user;

    /**
     * Specified setting
     * @var SiteSetting|UserSetting|ISetting
     */
    private $setting;

    /**
     * Whether needs to exit from the command
     * @var bool
     */
    private $do_return;

    /**
     * SettingList constructor
     *
     * @param EntityManager $em
     * @param Translator $translator
     * @param array $locales
     */
    public function __construct(
        EntityManager $em,
        Translator $translator,
        array $locales
    ) {
        $this->em = $em;
        $this->translator = $translator;

        self::$locales = $locales;

        $this->do_return = false;

        parent::__construct();
    }

    /**
     * Configure command
     *
     * @return void
     */
    protected function configure(): void
    {
        $this
            ->setName('app:setting:check')
            ->setDescription('Show list of settings.')
            ->setHelp('This command shows list of settings.')
            ->addOption(
                'user',
                'u',
                InputOption::VALUE_REQUIRED,
                'Show settings for user.',
                null
            )
            ->addOption(
                'setting',
                's',
                InputOption::VALUE_REQUIRED,
                'Show specified setting.',
                null
            )->addOption(
                'locale',
                'l',
                InputOption::VALUE_REQUIRED,
                'Output messages language.',
                null
            );
    }

    /**
     * Initialize command
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return void
     */
    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        $userOption = $input->getOption('user');
        if ($userOption) {
            $isId = \is_numeric($userOption);

            $user = $isId
                ? $this->em->getRepository(User::class)->find($userOption)
                : $this->em->getRepository(User::class)->findOneBy(['username' => $userOption]);

            if (!$user) {
                $this->writeError(
                    $this->translator->trans(
                        self::TRANS_PREFIX.'.user_not_found', [
                            '{{field}}' => $isId ? 'id' : 'username',
                            '{{value}}' => $userOption
                        ],
                        'commands',
                        self::$locale
                    ),
                    $output
                );

                $this->do_return = true;
                return;
            }

            $this->user = $user;
        }

        $settingOption = $input->getOption('setting');
        if ($settingOption) {
            $valueType = $this->em->getRepository(ValueType::class)->findOneBy(['name' => $settingOption]);

            if (!$valueType) {
                $this->outputSettingNotFoundMessage($settingOption, $output);

                $this->do_return = true;
                return;
            }

            /** @var ISetting $setting */
            $setting = $this->user
                ? $this->em->getRepository(UserSetting::class)->findOneBy([
                    'type' => $valueType->getId(),
                    'user' => $this->user->getId()
                ])
                : $this->em->getRepository(SiteSetting::class)->findOneBy(['type' => $valueType->getId()]);

            if (!$setting) {
                $this->outputSettingNotFoundMessage($settingOption, $output);

                $this->do_return = true;
                return;
            }

            $this->setting = $setting;
        }

        $localeOption = $input->getOption('locale');
        if ($localeOption) {
            self::setLocale($localeOption);
        }
    }

    /**
     * Execute command
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return void
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        if ($this->do_return === true) {
            return;
        }

        $table = $this->getTable($output, $this->getDefaultTableStyle());
        $table->setHeaders($this->getHeader());

        if ($this->setting) {
            if (!$this->setting->getEnabled() || !$this->setting->getType()->getEnabled()) {
                $this->writeComment(
                    $this->translator->trans(
                        self::TRANS_PREFIX.'.setting_is_disabled',
                        [],
                        'commands',
                        self::$locale
                    ),
                    $output
                );
            }

            $table->setRows([$this->generateRow($this->setting)]);
        } else {
            $settings = $this->user
                ? $this->em->getRepository(UserSetting::class)->findBy(['user' => $this->user->getId()])
                : $this->em->getRepository(SiteSetting::class)->findAll();

            $rows = [];
            foreach ($settings as $setting) {
                $rows[] = $this->generateRow($setting);
            }

            $table->setRows($rows);
        }

        $table->render();
    }

    /**
     * Generate single table row
     *
     * @param SiteSetting|UserSetting|ISetting $setting
     * @return array
     */
    private function generateRow(ISetting $setting): array
    {
        /** @var SiteSetting|UserSetting|ISetting $setting */

        $type = $setting->getType();

        $type->setTranslatableLocale(self::$locale);
        $this->em->refresh($type);

        $row = [
            'id' => $setting->getId(),
            'type_name' => $type->getName(),
            'type_type' => $type->getType(),
            'type_region' => $type->getRegion(),
            'type_priority' => $type->getPriority(),
            'type_title' => $type->getTitle(),
            'value' => $setting->getValue(),
            'enabled' => $setting->getEnabled(),
            'created' => $setting->getCreated()->format('Y-m-d'),
            'updated' => $setting->getUpdated()->format('Y-m-d')
        ];

        return \array_values($row);
    }

    /**
     * Get header columns
     *
     * @return array
     */
    private function getHeader(): array
    {
        return [
            'id',
            'name',
            'type',
            'region',
            'priority',
            'title',
            'value',
            'enabled',
            'created',
            'updated'
        ];
    }

    /**
     * Write an error message when setting wasn't found
     *
     * @param string $settingOption
     * @param OutputInterface $output
     * @return void
     */
    private function outputSettingNotFoundMessage(string $settingOption, OutputInterface $output): void
    {
        $this->writeError(
            $this->translator->trans(
                self::TRANS_PREFIX.'.setting_not_found', [
                    '{{name}}' => $settingOption
                ],
                'commands',
                self::$locale
            ),
            $output
        );
    }
}
