<?php declare(strict_types=1);

namespace Becklyn\Hosting\Git;

/**
 * Integration with git.
 */
class GitIntegration
{
    /** @var string */
    private $projectDir;


    /**
     */
    public function __construct (string $projectDir)
    {
        $this->projectDir = $projectDir;
    }

    /**
     * Fetches the commit hash of the current HEAD.
     */
    public function fetchHeadCommitHash () : ?string
    {
        if (!\is_dir("{$this->projectDir}/.git"))
        {
            return null;
        }

        $git = $this->run('command -v git');

        return null !== $git
            ? $this->run("{$git} rev-parse HEAD")
            : null;
    }


    /**
     * Runs the given command.
     */
    private function run (string $command) : ?string
    {
        $result = \trim(\shell_exec($command) ?? "");

        return "" !== $result
            ? $result
            : null;
    }
}
