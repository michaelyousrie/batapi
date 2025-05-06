<?php
namespace App\Controllers;

use BatAPI\DataSources\MySQL;
use BatAPI\Response;
use function BatAPI\Utils\dd;

class MainController
{
    public function index(): string
    {
        $answers = (new MySQL())
            ->table('answers')
            ->select(['question_id'])
            ->where([
                ['is_correct', '=', '1'],
                ['question_id', '>', '1']
            ])
            ->group([
                'question_id',
            ])
            ->order([
                ['question_id', 'DESC']
            ])
            ->read();

        dd($answers);
        return Response::success(['message' => "I'm the GET night Controller."]);
    }
}