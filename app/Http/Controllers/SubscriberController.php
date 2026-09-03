<?php

namespace App\Http\Controllers;

use App\Models\EmailList;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;

class SubscriberController extends Controller
{
    public function index(EmailList $emailList): View
    {
        $search = request()->search ?? '';
        $subscribers = $emailList->subscribers()
            ->when($search !== '', function (Builder $query) use ($search) {
                $query->where(function (Builder $q) use ($search) {
                    $q->whereLike('name', "%$search%")
                        ->orWhereLike('email', "%$search%");

                    if (is_numeric($search)) {
                        $q->orWhere('id', $search);
                    }
                });
            })
            ->paginate(20);

        return view('subscriber.index', compact('search', 'emailList', 'subscribers'));
    }

    public function create(int $emailList): View
    {
        return view('subscriber.create', [
            'emailList' => $emailList
        ]);
    }
}
