<?php declare(strict_types=1);

namespace Becklyn\Hosting\Git;

/**
 * Integration with git
 */
class GitIntegration
{

    /**
     * Fetches the commit hash of the current HEAD
     *
     * @return string|null
     */
    public function fetchHeadCommitHash () : ?string
    {
        $git = $this->run('command -v git');

        if ("" === $git)
        {
            return null;
        }

        return $this->run("{$git} rev-parse HEAD");
    }


    /**
     * Runs the given command
     *
     * @param string $command
     * @return string|null
     */
    private function run (string $command) : ?string
    {
        $result = \shell_exec($command);

        if (null === $result)
        {
            return null;
        }

        $result = \trim($result);

        return "" !== $result
            ? $result
            : null;
    }
}
