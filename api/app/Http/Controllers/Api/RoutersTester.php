<?php


namespace App\Http\Controllers\Api;


use App\Actions\RoutersTester\CheckNicknameAction;
use App\Actions\RoutersTester\CheckNicknameRequest;

class RoutersTester extends ApiController
{

    public function __construct()
    {
    }
    
    public function checkNickname(
        string $nickname,
        CheckNicknameAction $action
    ) {
        $action->execute(new CheckNicknameRequest($nickname));
        return $this->emptyResponse();
    }
}
