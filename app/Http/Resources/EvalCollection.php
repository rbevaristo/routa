<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class EvalCollection extends Resource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return  [
            'filename' => $this->filename,
            'url' => 'http://localhost/routa/public/storage/pdf/'.$this->filename
        ];
    }
}
