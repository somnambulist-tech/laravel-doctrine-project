<?php

namespace App\Support\Traits\Seeder;

/**
 * Trait ExecShellStatement
 *
 * @package    App\Support\Traits\Seeder
 * @subpackage App\Support\Traits\Seeder\ExecShellStatement
 */
trait ExecShellStatement
{

    /**
     * @param string $file
     *
     * @return string
     */
    protected function createShellExecStatement($file)
    {
        $shell_exec = 'mysql -u :username -p:password :database < :file';

        $exec = strtr($shell_exec, [
            ':username' => env('DB_USERNAME'),
            ':password' => env('DB_PASSWORD'),
            ':database' => env('DB_DATABASE'),
            ':file'     => $file,
        ]);

        return $exec;
    }
}
