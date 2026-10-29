<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReportRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->role === 'pelapor';
    }

    public function rules(): array
    {
        return [
            'area_id'        => ['required', 'exists:areas,id'],
            'judul'          => ['required', 'string', 'max:150'],
            'deskripsi'      => ['required', 'string'],
            'latitude'       => ['required', 'numeric', 'between:-11.0,6.0'],
            'longitude'      => ['required', 'numeric', 'between:95.0,141.0'],
            'waktu_kejadian' => ['required', 'date', 'before_or_equal:now'],
            'bukti'          => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            'latitude.between'  => 'Koordinat Latitude harus berada pada rentang wilayah Indonesia (-11.0 s/d 6.0).',
            'longitude.between' => 'Koordinat Longitude harus berada pada rentang wilayah Indonesia (95.0 s/d 141.0).',
            'bukti.max'         => 'Ukuran bukti pendukung tidak boleh melebihi 2 MB.',
            'bukti.mimes'       => 'File bukti harus berformat JPG, JPEG, PNG, atau PDF.',
        ];
    }
}