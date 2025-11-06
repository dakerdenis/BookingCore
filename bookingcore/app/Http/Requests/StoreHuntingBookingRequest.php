<?php


namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Carbon\Carbon;


class StoreHuntingBookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'tour_name' => ['required', 'string', 'min:2', 'max:120'],
            'hunter_name' => ['required', 'string', 'min:2', 'max:120'],
            'guide_id' => ['required', 'integer', Rule::exists('guides', 'id')->where('is_active', true)],
            'date' => ['required', 'date_format:Y-m-d', 'after_or_equal:today'],
            'participants_count' => ['required', 'integer', 'min:1', 'max:10'],
        ];
    }


    protected function prepareForValidation(): void
    {
        $this->merge([
            'tour_name' => is_string($this->tour_name) ? trim(preg_replace('/\s+/', ' ', $this->tour_name)) : $this->tour_name,
            'hunter_name' => is_string($this->hunter_name) ? trim(preg_replace('/\s+/', ' ', $this->hunter_name)) : $this->hunter_name,
            'participants_count' => (int) $this->participants_count,
        ]);
    }
}
