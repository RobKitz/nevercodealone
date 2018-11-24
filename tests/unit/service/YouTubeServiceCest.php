<?php namespace NCATesting\service;
use App\Service\YouTubeService;
use Codeception\Stub;
use NCATesting\UnitTester;
use Mockery as m;

class YouTubeServiceCest
{
    private $fixture;

    public function _before(UnitTester $I)
    {
        $_ENV['GOOGLE_API_KEY'] = 'testify';
        $this->fixture = new YouTubeService();
    }

    // tests
    public function getItemsFromChannelReverseArrayFromPlaylistItemsListByPlaylistId(UnitTester $I)
    {
        $array = [
            'one',
            'two',
            'three'
        ];

        $externalMock = m::mock('overload:\Google_Service_YouTube');
        $externalMock->shouldReceive('foo')
            ->once()
            ->andReturn($array)
            ->set('playlistItems', 'listPlaylistItems')
            ;

        $externalMock->playlistItems = 'listPlaylistItems';

        $obj = new \stdClass();
        $obj->playlistItems = new \stdClass();
        $obj->playlistItems->listPlaylistItems = $array

        $this->fixture = Stub::make(
            $this->fixture,
            [
                'playlistItemsListByPlaylistId' => ['items' => $array]
            ]
        );

        $itemsFromChannel = $this->fixture->getItemsFromChannel();
        $I->assertSame(array_reverse($array), $itemsFromChannel);
    }
}
