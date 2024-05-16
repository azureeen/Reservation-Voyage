<?php

namespace App\EventListener;

use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Twig\Environment;

class ExceptionListener
{
    private $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        $statusCode = $exception instanceof HttpExceptionInterface ? $exception->getStatusCode() : Response::HTTP_INTERNAL_SERVER_ERROR;

        // Log error details to the server's error log for development purposes
        error_log("Exception caught: " . $exception->getMessage());
        error_log("Status code: " . $statusCode);
        error_log("Trace: " . $exception->getTraceAsString());

        // Optional: To output directly to the console during development, use the following:
        // This will appear in the console if you're running PHP's built-in server or it's configured to display errors
        if (PHP_SAPI === 'cli') {
            echo "Exception caught: " . $exception->getMessage() . "\n";
            echo "Status code: " . $statusCode . "\n";
            echo "Trace: " . $exception->getTraceAsString() . "\n";
        }

        // Render the appropriate Twig template based on the status code
        $template = $this->selectTemplate($statusCode);
        $content = $this->twig->render($template, [
            'exception' => $exception,
            'status_code' => $statusCode,
            'message' => $exception->getMessage(),
        ]);

        $response = new Response($content, $statusCode);
        $event->setResponse($response);
    }

    private function selectTemplate(int $statusCode): string
    {
        switch ($statusCode) {
            case 404:
                return 'bundles/TwigBundle/Exception/error404.html.twig';
            case 500:
                return 'bundles/TwigBundle/Exception/error500.html.twig';
            default:
                return 'bundles/TwigBundle/Exception/error.html.twig';
        }
    }
}
