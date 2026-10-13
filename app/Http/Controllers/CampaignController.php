<?php

namespace App\Http\Controllers;

use App\Http\Requests\CampaignStoreRequest;
use App\Models\Campaign;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use InvalidArgumentException;

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
                'show_trash' => $showTrash,
            ]);

        return view('campaigns.index', [
            'campaigns' => $campaigns,
            'showTrash' => $showTrash,
            'search' => $search,
        ]);
    }

    public function create(): View
    {
        $tab = (string) request()->input('tab', '_config');
        $form = match ($tab) {
            'template' => '_template',
            'schedule' => '_schedule',
            default => '_config'
        };
        $data = session()->get('campaigns::create', [
            'name' =>  null,
            'subject' =>  null,
            'email_list_id' => null,
            'template_id' => null,
            'body' => null,
            'track_click' => null,
            'track_open' => null,
            'send_at' => null
        ]);

        return view('campaigns.create', compact('tab', 'form', 'data'));
    }

    public function store(CampaignStoreRequest $request): RedirectResponse
    {
        $tab = request()->input('tab', '');

        $data = $request->getData();
        $toRoute = $request->getToRoute();

        if ($tab === 'schedule') {
            Campaign::query()->create($data);
        }

        return response()->redirectTo($toRoute);
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
