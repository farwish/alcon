<?php

namespace Alcon\Traits;

/**
 * Sentry client class.
 * Need sentry-php sdk (sentry/sentry).
 *
 * <code>
 *  $sentryDsn = 'xxxx';
 *  \Alcon\Traits\SentryClientClass::sentryRun($sentryDsn);
 * </code>
 *
 * @farwish
 */
class SentryClientClass
{
    /**
     * Run.
     *
     * @param string $sentryDsn
     * @param array  $options
     *
     * @return void
     *
     * @farwish
     */
    public static function sentryRun($sentryDsn, $options = [])
    {
        $error_handler = new \Raven_ErrorHandler(
            new \Raven_Client($sentryDsn, $options)
        );
        $error_handler->registerExceptionHandler();
        $error_handler->registerErrorHandler();
        $error_handler->registerShutdownFunction();
    }
}
