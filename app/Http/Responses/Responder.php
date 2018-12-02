<?php

namespace App\Responses;

Interface Responder
{
    public function respond($data);

    public function respondWithError($error);

    public function respondWithValidationError($error);

    public function respondWithAuthenticationError($error = 'Forbidden!');
}
