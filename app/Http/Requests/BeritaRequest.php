<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class BeritaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [

            'judul'=>'required|unique:beritas,judul',
            'kategori_id'=>'required|exists:kategoris,id',
            'isi_berita'=>'required|unique:beritas,isi_berita',
            'cover'=>'image|max:2048'
        ];
    }
}
