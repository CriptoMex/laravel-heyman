<?php

use Imanghafoori\HeyMan\Chain;

class ResponderTest extends TestCase
{
    public function testRedirectToIntended()
    {
        $methods = [
            'stream',
            'streamDownload',
            'view',
            'make',
            'json',
            'jsonp',
            'download',
        ];
        foreach ($methods as $method) {
            $param = str_random(3);
            $reaction = app(\Imanghafoori\HeyMan\Actions::class);
            \Facades\Imanghafoori\HeyMan\Chain::shouldReceive('submitChainConfig')->once();
            \Facades\Imanghafoori\HeyMan\Chain::shouldReceive('addResponse');
            $reaction->response()->{$method}($param);
        }
    }

    public function testRedirect()
    {
        $methods = [
            'intended',
            'action',
            'route',
            'guest',
            'to',
        ];

        foreach ($methods as $method) {
            $param = str_random(3);
            \Facades\Imanghafoori\HeyMan\Chain::shouldReceive('submitChainConfig')->once();
            \Facades\Imanghafoori\HeyMan\Chain::shouldReceive('addRedirect')->with($method, [$param]);

            $reaction = app(\Imanghafoori\HeyMan\Actions::class);
            $reaction->redirect()->{$method}($param);
        }
    }

    public function testRedirectMsg()
    {
        $methods = [
            'with',
            'withCookies',
            'withInput',
            'onlyInput',
            'exceptInput',
            'withErrors',
            'no',
        ];

        foreach ($methods as $method) {
            $param = str_random(2);
            $chain = Mockery::mock(Chain::class);
            $chain->shouldReceive('addRedirect')->once()->with($method, [[$param]]);
            $redirectionMsg = new \Imanghafoori\HeyMan\RedirectionMsg($chain, '');
            $redirectionMsg->{$method}([$param]);
        }
    }
}
