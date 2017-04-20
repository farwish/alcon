<?php

namespace Alcon\Traits;

/**
 * Sentry client trait.
 * Need sentry-php sdk (sentry/sentry).
 *
 * NOTICE: modify the $_sentryDsn for your own.
 *
 * <code>
 *  class Demo
 *  {
 *      use Alcon\Traits\SentryClientTrait;
 *
 *      public function __construct($sentryDsn = '')
 *      {
 *          static::sentryRun($sentryDsn);
 *      }
 *  }
 *  new Demo($dsn);
 * </code>
 *
 * @farwish
 */
trait SentryClientTrait
{
    /**
     * sentry dsn address.
     *
     * @var string
     */
    private static $_sentryDsn = 'https://8dd7b553546745949820ddeb68044c96:4a1a9ce5de3e4a8fb839a75383565c62@sentry.io/160169';

    /**
     * Run.
     *
     * @farwish
     */
    private static function sentryRun($sentryDsn = '')
    {
        $dsn = $sentryDsn ?: static::$_sentryDsn;
        
        $error_handler = new \Raven_ErrorHandler(
            new \Raven_Client($dsn)
        );
        $error_handler->registerExceptionHandler();
        $error_handler->registerErrorHandler();
        $error_handler->registerShutdownFunction();
    }
}
