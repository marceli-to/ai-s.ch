<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class SubscribStoreRequest extends FormRequest
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
    return [
      'firstname' => 'required',
      'name' => 'required',
      'email' => 'required|email',
    ];
  }

  /**
   * Custom message for validation
   *
   * @return array
   */

  public function messages()
  {
    return [
      'firstname.required' => 'Vorname fehlt',
      'name.required' => 'Name fehlt',
      'email.required' => 'E-Mail fehlt',
      'email.email' => 'E-Mail ungültig',
    ];
  }
}