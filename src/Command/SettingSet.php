<?php
/**
 * SettingSet Command
 * Command for set values for setting
 *
 * @package App\Command
 * @version 1.0.0
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @copyright 2018 diftong.com (https://www.diftong.com)
 * @author Alexander Saveliev <me@rainlike.com>
 */
declare(strict_types=1);

namespace App\Command;

use Symfony\Component\Console\Command\Command;

use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Symfony\Contracts\Translation\TranslatorInterface as Translator;

use Doctrine\ORM\EntityManagerInterface as EntityManager;

use App\Entity\Library\Interfaces\ISetting;
use App\Command\Library\Interfaces\ICleanup;

use App\Command\Library\Traits\LocaleTrait;
use App\Command\Library\Traits\WrapperTrait;

use App\Entity\User;
use App\Entity\ValueType;
use App\Entity\SiteSetting;
use App\Entity\UserSetting;

/** Class SettingSet */
class SettingSet extends Command implements ICleanup
{
    use LocaleTrait;
    use WrapperTrait;

    /** @var string */
    private const TRANS_PREFIX = 'setting_set';

    /**
     * Lazy loading
     * @var string
     */
    protected static $defaultName = 'app:setting:set';

    /** @var EntityManager */
    private $em;

    /** @var Translator */
    private $translator;

    /**
     * Specified setting
     * @var SiteSetting|UserSetting|ISetting
     */
    private $setting;

    /**
     * Specified value
     * @var mixed
     */
    private $value;

    /**
     * Specified user
     * @var User
     */
    private $user;

    /**
     * Whether needs to exit from the command
     * @var bool
     */
    private $do_return;

    /**
     * SettingCheck constructor
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
            ->setName('app:setting:set')
            ->setDescription('Show list of settings.')
            ->setHelp('This command shows list of settings.')
            ->addArgument(
                'setting',
                InputArgument::REQUIRED,
                'Setting name.',
                null
            )->addArgument(
                'value',
                InputArgument::REQUIRED,
                'Setting value will be set.',
                null
            )
            ->addOption(
                'user',
                'u',
                InputOption::VALUE_REQUIRED,
                'Show settings for user.',
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
        $settingArgument = $input->getArgument('setting');
        $valueArgument = $input->getArgument('value');

        if (!$settingArgument || $valueArgument === null) {
            $this->writeError(
                $this->translator->trans(
                    self::TRANS_PREFIX.'.required_not_set',
                    [],
                    'commands',
                    self::$locale
                ),
                $output
            );

            $this->do_return = true;
            return;
        }

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

        $valueType = $this->em->getRepository(ValueType::class)->findOneBy(['name' => $settingArgument]);

        if (!$valueType) {
            $this->outputSettingNotFoundMessage($settingArgument, $output);

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
            $this->outputSettingNotFoundMessage($settingArgument, $output);

            $this->do_return = true;
            return;
        }

        $this->setting = $setting;
        $this->value = $valueArgument;

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

        try {
            $this->setting->setValue($this->transformToString($this->value));

            $this->em->persist($this->setting);
            $this->em->flush();

            $this->writeInfo(
                $this->translator->trans(self::TRANS_PREFIX.'.success_set', [], 'commands', self::$locale),
                $output
            );
        } catch (\Exception $error) {
            $this->writeError(
                $this->translator->trans(self::TRANS_PREFIX.'.error_set', [], 'commands', self::$locale),
                $output
            );
        }

        $this->cleanUp();
    }

    /**
     * Transform value to string
     *
     * @param string|mixed $value
     * @return string
     */
    private function transformToString($value): string
    {
        return (string)$value;
    }

    /**
     * Clean up all variables
     *
     * @return void
     */
    public function cleanUp(): void
    {
        $this->setting = null;
        $this->value = null;
        $this->user = null;
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
