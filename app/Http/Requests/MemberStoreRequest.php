<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class MemberStoreRequest extends FormRequest
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
      'firstname' => 'required_if:member_type,Student:in,Einzelmitglied',
      'name' => 'required_if:member_type,Student:in,Einzelmitglied',
      'institution' => 'required_if:member_type,Institution',
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
      'firstname.required_if' => 'Vorname fehlt',
      'name.required_if' => 'Name fehlt',
      'institution.required_if' => 'Institution fehlt',
      'email.required' => 'E-Mail fehlt',
      'email.email' => 'E-Mail ungültig',
    ];
  }
}