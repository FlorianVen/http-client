<?php declare(strict_types=1);

namespace Amp\Http\Client;

use Amp\Cancellation;
use Amp\Closable;

/**
 * Base HTTP client interface for use in {@see ApplicationInterceptor}.
 *
 * Applications and implementations should depend on {@see HttpClient} instead. The intent of this interface is to
 * allow static analysis tools to find interceptors that forget to pass the cancellation down. This situation is
 * created because of the cancellation being optional.
 *
 * Before executing or delegating the request, any client implementation must call {@see EventListener::startRequest()}
 * on all event listeners registered on the given request in the order defined by {@see Request::getEventListeners()}.
 * Before calling the next listener, the promise returned from the previous one must resolve successfully.
 *
 * @see HttpClient
 */
interface DelegateHttpClient
{
    /**
     * Request a specific resource from an HTTP server.
     */
    public function request(Request $request, Cancellation $cancellation): Response;
}
