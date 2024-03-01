<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Statamic\Facades\Entry;
use Statamic\Fields\Value;
use App\Http\Requests\SubscribStoreRequest;
use App\Http\Requests\MemberStoreRequest;
use Illuminate\Support\Facades\Notification;
// use App\Notifications\SupporterUserEmail;
// use App\Notifications\SupporterOwnerEmail;
// use App\Notifications\TestimonialUserEmail;
// use App\Notifications\TestimonialOwnerEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FormController extends Controller
{
  /**
   * @param SubscribStoreRequest $request 
   * @return \Illuminate\Http\Response
   */
  public function storeSubscriber(SubscribStoreRequest $request)
  { 
    // $subscriber = Entry::make()
    //   ->collection('subscribers')
    //   ->slug($title)
    //   ->data(
    //     array_merge(
    //       [
    //         'title' => $title,
    //         'image' => $path,
    //       ], 
    //       $request->except(
    //         ['image']
    //       )
    //     )
    //   );

    // $subscriber->published(false);
    // $subscriber->save();
    // Notification::route('mail', $request->input('email'))->notify(new TestimonialUserEmail($subscriber));
    // Notification::route('mail', env('MAIL_TO'))->notify(new TestimonialOwnerEmail($subscriber));
    // Notification::route('mail', env('MAIL_TO_CC'))->notify(new TestimonialOwnerEmail($subscriber));

    return response()->json(200);
  }

  /**
   * @param MemberStoreRequest $request 
   * @return \Illuminate\Http\Response
   */
  public function storeMember(MemberStoreRequest $request)
  { 
    // $subscriber = Entry::make()
    //   ->collection('subscribers')
    //   ->slug($title)
    //   ->data(
    //     array_merge(
    //       [
    //         'title' => $title,
    //         'image' => $path,
    //       ], 
    //       $request->except(
    //         ['image']
    //       )
    //     )
    //   );

    // $subscriber->published(false);
    // $subscriber->save();
    // Notification::route('mail', $request->input('email'))->notify(new TestimonialUserEmail($subscriber));
    // Notification::route('mail', env('MAIL_TO'))->notify(new TestimonialOwnerEmail($subscriber));
    // Notification::route('mail', env('MAIL_TO_CC'))->notify(new TestimonialOwnerEmail($subscriber));

    return response()->json(200);
  }
}
