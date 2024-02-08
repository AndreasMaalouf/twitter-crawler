<?php

namespace App\Http\Requests;

use App\Repositories\InstrumentRepository;
use Illuminate\Foundation\Http\FormRequest;

class TweetRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $instruments = (new InstrumentRepository)->getData();

        return $instruments->has($this->route('tag'));
    }
}
