<?php
/**
 * DbRebuild Command
 * Command for rebuild database
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

use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputOption;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Symfony\Component\Console\Question\ConfirmationQuestion;

use Symfony\Component\Console\Helper\ProgressBar;

use Symfony\Contracts\Translation\TranslatorInterface as Translator;

use App\Command\Library\Traits\LocaleTrait;
use App\Command\Library\Traits\WrapperTrait;

/** Class DbRebuild */
class DbRebuild extends Command
{
    use LocaleTrait;
    use WrapperTrait;

    /** @var int */
    private const SUCCESS_CODE = 0;

    /** @var string */
    private const TRANS_PREFIX = 'db_rebuild';

    /**
     * Lazy loading
     * @var string
     */
    protected static $defaultName = 'app:db:rebuild';

    /** @var bool */
    private $sure;

    /** @var Translator */
    private $translator;

    /**
     * DbRebuild constructor
     *
     * @param Translator $translator
     * @param array $locales
     * @param bool $sure
     */
    public function __construct(
        Translator $translator,
        array $locales,
        bool $sure = false
    ) {
        $this->sure = $sure;
        $this->translator = $translator;

        self::$locales = $locales;

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
            ->setName('app:db:rebuild')
            ->setDescription('Rebuild data base.')
            ->setHelp('This command rebuilds data base, loads fixtures and runs migrations.')
            ->addOption(
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
        $localeOption = $input->getOption('locale');
        if ($localeOption) {
            self::setLocale($localeOption);
        }
    }

    /**
     * Command interaction
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return void
     */
    protected function interact(InputInterface $input, OutputInterface $output): void
    {
        $helper = $this->getHelper('question');
        $question = new ConfirmationQuestion(
            $this->translator->trans('db_rebuild.question', [], 'commands', self::$locale),
            true
        );

        $answer = $helper->ask($input, $output, $question);

        $this->sure = $answer;

        if (!$this->sure) {
            return;
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
        if (!$this->sure) {
            return;
        }

        $progressBar = new ProgressBar($output, \count($this->getCommandsList()));

        foreach ($this->getCommandsList() as $commandName => $commandParameters) {
            $commandArguments = $commandParameters['arguments'];
            $commandTranslation = $commandParameters['translation'];

            $command = $this->getApplication()->find($commandName);
            $commandArguments['command'] = $commandName;

            $commandInput = new ArrayInput($commandArguments);
            $commandCode = $command->run($commandInput, $output);

            $translationKey = self::TRANS_PREFIX.'.'.$commandTranslation.'.';

            if ($commandCode === self::SUCCESS_CODE) {
                $this->writeInfo(
                    $this->translator->trans($translationKey.'success', [], 'commands', self::$locale),
                    $output
                );
                $progressBar->advance();
                $this->writeBreak($output);
            } else {
                $this->writeError(
                    $this->translator->trans($translationKey.'success', [], 'commands', self::$locale),
                    $output
                );
                return;
            }
        }

        $this->writeInfo(
            $this->translator->trans(self::TRANS_PREFIX.'.all_done', [], 'commands', self::$locale),
            $output
        );
    }

    /**
     * Get list of commands to execute with parameters
     *
     * @return array
     */
    private function getCommandsList(): array
    {
        return [
            'doctrine:database:drop' => [
                'arguments' => [
                    '--force' => true
                ],
                'translation' => 'database_drop'
            ],
            'doctrine:database:create' => [
                'arguments' => [],
                'translation' => 'database_create'
            ],
            'doctrine:schema:update' => [
                'arguments' => [
                    '--force' => true
                ],
                'translation' => 'schema_update'
            ],
            'doctrine:fixtures:load' => [
                'arguments' => [
                    '--no-interaction' => true
                ],
                'translation' => 'fixtures_load'
            ],
            'doctrine:migrations:version' => [
                'arguments' => [
                    'version' => '20180401235430',
                    '--add' => true
                ],
                'translation' => 'migrations_version'
            ],
            'doctrine:migrations:migrate' => [
                'arguments' => [
                    '--no-interaction' => true
                ],
                'translation' => 'migrations_migrate'
            ],
            'cache:clear' => [
                'arguments' => [
                    '--no-warmup' => true
                ],
                'translation' => 'cache_clear'
            ]
        ];
    }
}
