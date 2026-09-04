<?php

namespace App\Http\Controllers;

use App\Models\EmailList;
use App\Models\Subscriber;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;

class SubscriberController extends Controller
{
    public function index(EmailList $emailList): View
    {
        $search = request()->search ?? '';
        $showTrash = (bool) request()->get('show_trash', false);

        $subscribers = $emailList->subscribers()
            ->when($showTrash, fn (Builder $query) => $query->withTrashed())
            ->when($search !== '', function (Builder $query) use ($search) {
                $query->where(function (Builder $q) use ($search) {
                    $q->whereLike('name', "%$search%")
                        ->orWhereLike('email', "%$search%");

                    if (is_numeric($search)) {
                        $q->orWhere('id', $search);
                    }
                });
            })
            ->orderBy('id')
            ->paginate(20);

        return view(
            'subscriber.index',
            compact('search', 'emailList', 'subscribers', 'showTrash')
        );
    }

    public function create(EmailList $emailList): View
    {
        return view('subscriber.create', [
            'emailList' => $emailList
        ]);
    }

    public function destroy(int $emailList, Subscriber $subscriber): RedirectResponse
    {
        $subscriber->delete();

        return back()->with('message', __('Subscriber deleted!'));
    }
}
