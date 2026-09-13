<?php

namespace App\Http\Controllers;

use App\Models\Template;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TemplateController extends Controller
{
    public function index(): View
    {
        $search = (string) request()->get('search', '');
        $showTrash = (bool) request()->get('show_trash', false);
        $templates = Template::query()
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

        return view('template.index', [
            'templates' => $templates,
            'search' => $search,
            'showTrash' => $showTrash
        ]);
    }

    public function create(): View
    {
        return view('template.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string']
        ]);

        Template::query()->create($data);

        return to_route('templates.index')
            ->with('message', __('Template created!'));
    }

    public function show(Template $template): View
    {
        return view('template.show', [
            'template' => $template
        ]);
    }

    public function edit(Template $template): View
    {
        return view('template.edit', [
            'template' => $template
        ]);
    }

    public function update(Request $request, Template $template): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string']
        ]);

        $template->update($data);

        return to_route('templates.edit', $template)
            ->with('message', __('Template updated!'));
    }

    public function destroy(Template $template): RedirectResponse
    {
        $template->delete();

        return to_route('templates.index')
            ->with('message', __('Template deleted!'));
    }
}
