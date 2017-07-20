<?php

namespace App\Http\Requests;

class UpdateBeritaRequest extends BeritaRequest
{

    public function rules()
    {

    $rules = parent::rules();
    $rules['judul']='required|unique:beritas,judul,' .$this->route('berita');
    return $rules;
    }
}
