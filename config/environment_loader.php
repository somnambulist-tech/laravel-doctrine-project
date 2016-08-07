<?php

return [

    /*
     * Add the full qualified class names to the providers that should be registered
     * during the boot() call. These may or may not work. e.g. Debugbar and IDE
     * helper should be entered into the register section.
     */
    'boot' => [
        /*
         * This is the default dev scope: local. Add keys for each environment that
         * you use e.g.: production, testing, staging etc.
         */
        'local' => [

        ],
    ],

    /*
     * Add the fully qualified class names to the providers that should be registered
     * on the register() call.
     */
    'register' => [
        /*
         * This is the default dev scope: local. Add keys for each environment that
         * you use e.g.: production, testing, staging etc.
         */
        'local' => [
            Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class,
            Barryvdh\Debugbar\ServiceProvider::class,
        ],
    ],

    /*
     * Add any aliases to facades that should be run. These happen during register().
     */
    'facades' => [
        /*
         * This is the default dev scope: local. Add keys for each environment that
         * you use e.g.: production, testing, staging etc.
         */
        'local' => [
            'Debugbar' => Barryvdh\Debugbar\Facade::class,
        ],
    ],
];
