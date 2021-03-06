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
 *      public function __construct($sentryDsn = '', $options = [])
 *      {
 *          static::sentryRun($sentryDsn, $options);
 *      }
 *  }
 *  new Demo($dsn, $options);
 * </code>
 *
 * @farwish
 */
trait SentryClientTrait
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
    private static function sentryRun($sentryDsn, $options = [])
    {
        $error_handler = new \Raven_ErrorHandler(
            new \Raven_Client($sentryDsn, $options)
        );
        $error_handler->registerExceptionHandler();
        $error_handler->registerErrorHandler();
        $error_handler->registerShutdownFunction();
    }
}
