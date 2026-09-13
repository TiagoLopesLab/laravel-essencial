<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;

class CampaignController extends Controller
{
    public function index(): View
    {
        $search = (string) request()->get('search', '');
        $showTrash = (bool) request()->get('show_trash', false);
        $campaigns = Campaign::query()
            ->when($showTrash, fn (Builder $query) => $query->withTrashed())
            ->when($search !== '', function (Builder $query) use ($search) {
                $query->where(function (Builder $q) use ($search) {
                    $q->whereLike('name', "%$search%");

                    if (is_numeric($search)) {
                        $q->orWhere('id', $search);
                    }
                });
            })
            ->orderBy('id')
            ->paginate(5)
            ->appends([
                'search' => $search,
                'show_trash' => $showTrash
            ]);

        return view('campaigns.index', [
            'campaigns' => $campaigns,
            'showTrash' => $showTrash,
            'search' => $search
        ]);
    }

    public function create(): View
    {
        return view('campaigns.create');
    }

    public function destroy(Campaign $campaign): RedirectResponse
    {
        $campaign->delete();

        return to_route('campaigns.index')
            ->with('message', __('Campaign deleted!'));
    }

    public function restore(Campaign $campaign): RedirectResponse
    {
        $campaign->restore();

        return to_route('campaigns.index')
            ->with('message', __('Campaign restored!'));
    }
}
