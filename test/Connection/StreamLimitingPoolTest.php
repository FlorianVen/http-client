<?php declare(strict_types=1);

namespace Amp\Http\Client\Connection;

use Amp\Future;
use Amp\Http\Client\HttpClientBuilder;
use Amp\Http\Client\Request;
use Amp\PHPUnit\AsyncTestCase;
use Amp\Sync\LocalKeyedMutex;
use function Amp\async;

class StreamLimitingPoolTest extends AsyncTestCase
{
    public function testByHost(): void
    {
        $client = (new HttpClientBuilder)
            ->usingPool(StreamLimitingPool::byHost(new UnlimitedConnectionPool, new LocalKeyedMutex))
            ->build();

        $this->setTimeout(5);
        $this->setMinimumRuntime(2);

        Future\await([
            async(fn () => $client->request(new Request('http://httpbin.org/delay/1'))),
            async(fn () => $client->request(new Request('http://httpbin.org/delay/1'))),
        ]);
    }
}
