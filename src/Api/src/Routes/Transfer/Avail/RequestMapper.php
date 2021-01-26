<?php


namespace Api\Routes\Transfer\Avail;


class RequestMapper
{
    static public function getRules()
    {
        return [
            [
                'name'       => 'status',
                'required'   => true,
                'description' => 'Foo',
                'validators' => [
                    [
                        'name'    => InArray::class,
                        'options' => [
                            'haystack' => ['OK', 'FAIL'],
                        ],
                    ],
                ],
                'filter' => [
                [
                    'name'    => ToInt::class,
                    'options' => [
                        'haystack' => ['OK', 'FAIL'],
                    ],
                ],
            ],
            ],
        ];

    }
}