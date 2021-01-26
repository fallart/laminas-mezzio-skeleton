<?php


namespace Api\Routes\Transfer\Avail;


class ResponseMapper
{
    static public function getRules(): array
    {
        return [
            [
                'name'       => 'status',
                'required'   => true,
                'description' => 'Foo',
                'filter' => [
                ],
            ],
        ];
    }
}