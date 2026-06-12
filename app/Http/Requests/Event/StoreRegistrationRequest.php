<?php

namespace App\Http\Requests\Event;

use Illuminate\Foundation\Http\FormRequest;

class StoreRegistrationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch ($this->category_type) {
        case 'wedding':
            return $this->validateWedding();
        case 'travel':
            return $this->validateTravel();
        case 'celebration':
            return $this->validateCelebration();
        default:
            return [
                'name' => 'required|string|max:255',
                'email' => 'required|email',
                'mobile' => 'required|string|max:20',
                'city' => 'required|string|max:255',
                'category' => 'required|min:1',
                'biggest_challenge' => 'required',
                'style' => 'required'
            ];
        }
    }

    private function validateWedding() {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'mobile' => 'required|string|max:20',
            'city' => 'required|string|max:255',
            'category' => 'required|min:1',
            'biggest_challenge' => 'required',
            'style' => 'required',
            'event.date' => 'required|date',
            'event.budget' => 'required',
            'event.guests' => 'required|numeric',
            'event.type' => 'required',
            'event.needs' => 'required|array|min:1'
        ];
    }

    private function validateTravel() {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'mobile' => 'required|string|max:20',
            'city' => 'required|string|max:255',
            'category' => 'required|min:1',
            'biggest_challenge' => 'required',
            'style' => 'required',
            'event.country' => 'required|string|max:255',
            'event.budget' => 'required',
            'event.type' => 'required',
            'event.needs' => 'required|array|min:1'
        ];
    }

    private function validateCelebration() {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'mobile' => 'required|string|max:20',
            'city' => 'required|string|max:255',
            'category' => 'required|min:1',
            'biggest_challenge' => 'required',
            'style' => 'required',
            'event.budget' => 'required',
            'event.type' => 'required',
            'event.needs' => 'required|array|min:1'
        ];
    }

    private function weddingMessages() {
        return [
            'event.date.required' => 'Target date is required',
            'event.date.date' => 'Invalid date format',
            'event.budget.required' => 'Estimated budget is required',
            'event.guests.required' => 'Estimated number of guests is required',
            'event.type.required' => 'Wedding type is required',
            'event.needs.required' => 'Please provide wedding services needs.',
            'event.needs.min' => 'Please provide wedding services needs.',
        ];
    }

    private function celebrationMessages() {
        return [
            'event.needs.required' => 'Please provide event/celebration services needs.',
            'event.needs.min' => 'Please provide event/celebration services needs.',
            'event.budget.required' => 'Event budget is required.',
            'event.type.required' => 'Event type is required.',
        ];
    }

    private function travelMessages() {
        return [
            'event.country.required' => 'Country/Destination is required.',
            'event.budget.required' => 'Estimated budget is required.',
            'event.type.required' => 'Travel Interest is required.',
            'event.needs.required' => 'Please provide travel services needs.',
            'event.needs.min' => 'Please provide travel services needs.',
        ];
    }

    public function messages()
    {   
        $basicMessages = [
            'name.required' => 'Name is required.',
            'name.string' => 'Name must be a string.',
            'name.max' => 'Name may not be greater than 255 characters.',
            'email.required' => 'Email is required.',
            'email.email' => 'Invalid email format.',
            'mobile.required' => 'Mobile number is required.',
            'mobile.string' => 'Mobile number must be a string.',
            'mobile.max' => 'Mobile number may not be greater than 20 characters.',
            'city.required' => 'City is required.',
            'city.string' => 'City must be a string.',
            'city.max' => 'City may not be greater than 255 characters.',
            'category.required' => 'Category is required.',
            'biggest_challenge.required' => 'Biggest challenge is required.',
            'style.required' => 'Preferred Theme/Style is required.',
        ];
        
        switch ($this->category_type) {
            case 'wedding':
                return array_merge($basicMessages, $this->weddingMessages());
            case 'travel':
                return array_merge($basicMessages, $this->travelMessages());
            case 'celebration':
                return array_merge($basicMessages, $this->celebrationMessages());
            default:
                return $basicMessages;
        }
    }
}
