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

        return view('campaigns.create', compact('tab', 'form'));
    }

    public function store(): RedirectResponse
    {
        $tab = request()->input('tab', '');

        if (blank($tab)) {
            $data = request()->validate([
                'name' => ['required', 'max:255'],
                'subject' => ['required', 'max:40'],
                'email_list_id' => ['nullable'],
                'template_id' => ['nullable'],
            ]);

            session()->put('campaigns::create', $data);

            return to_route('campaigns.create', ['tab' => 'template']);
        }

        return to_route('campaigns.index')
            ->with('message', __('Campaign created!'));
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
