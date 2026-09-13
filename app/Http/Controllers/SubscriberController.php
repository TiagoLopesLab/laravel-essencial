<?php

namespace App\Http\Controllers;

use App\Models\EmailList;
use App\Models\Subscriber;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;

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
            ->paginate(20)
            ->appends([
                'search' => $search,
                'show_trash' => $showTrash
            ]);

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

    public function store(EmailList $emailList): RedirectResponse
    {
        $data = request()->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('subscribers')->where('email_list_id', $emailList->id)]
        ]);

        $emailList->subscribers()->create($data);

        return to_route('subscribers.index', $emailList)
            ->with('message', __('Subscriber created!'));
    }

    public function destroy(int $emailList, Subscriber $subscriber): RedirectResponse
    {
        $subscriber->delete();

        return back()->with('message', __('Subscriber deleted!'));
    }
}
