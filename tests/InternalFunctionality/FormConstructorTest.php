<?php

namespace unreal4u\TelegramAPI\tests\InternalFunctionality;

use PHPUnit\Framework\TestCase;
use unreal4u\TelegramAPI\InternalFunctionality\PostOptionsConstructor;

class FormConstructorTest extends TestCase
{
    /**
     * @var PostOptionsConstructor
     */
    private $formConstructor;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->formConstructor = new PostOptionsConstructor();
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        $this->formConstructor = null;
        parent::tearDown();
    }

    public function providerBuildMultipartFormData()
    {
        $mapValues[] = [
            [
                'lala' => 'lolo',
            ],
            'non-existant',
            null,
            [
                'headers' => [
                    'Content-Type' => 'multipart/form-data'
                ],
                'body' => [
                    [
                        'name' => 'lala',
                        'contents' => 'lolo',
                    ]
                ]
            ]
        ];

        //$mapValues[] = [[], '', null, new MultipartStream([[]])];

        return $mapValues;
    }

    /**
     * @dataProvider providerBuildMultipartFormData
     * @param array $data
     * @param string $fileKeyName
     * @param null $stream
     * @param array $multiPartData
     */
    public function testBuildMultipartFormData(
        array $data,
        string $fileKeyName,
        $stream = null,
        array $multiPartData = []
    ) {
        $result = $this->formConstructor->constructMultipartOptions($data, $fileKeyName, $stream);
        $this->assertEquals($multiPartData, $result);
    }
}
