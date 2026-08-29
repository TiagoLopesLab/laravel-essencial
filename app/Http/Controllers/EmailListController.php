<?php

namespace App\Http\Controllers;

use App\Models\EmailList;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use RuntimeException;

class EmailListController extends Controller
{
    public function index(): View
    {
        return view('email-list.index', [
            'emailLists' => EmailList::query()->paginate()
        ]);
    }

    public function create(): View
    {
        return view('email-list.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'title' => ['required', 'max:255'],
            'file' => ['required', 'file', 'mimes:csv']
        ]);

        /** @var UploadedFile $file */
        $file = $request->file('file');
        $fileHandle = fopen(filename: $file->getRealPath(), mode: 'r');
        if ($fileHandle === false) {
            throw new RuntimeException('Erro na leitura do CSV');
        }

        $items = [];

        while (($row = fgetcsv($fileHandle)) !== false) {
            if ($row[0] === 'Name' && $row[1] === 'Email') {
                continue;
            }

            $items[] = [
                'name' => $row[0],
                'email' => $row[1]
            ];
        }

        $emailList = EmailList::query()->create([
            'title' => $data['title']
        ]);
        $emailList->subscribers()->createMany($items);

        return to_route('email-list.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(EmailList $list)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EmailList $list)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EmailList $list)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EmailList $list)
    {
        //
    }
}
